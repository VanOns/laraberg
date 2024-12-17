<?php

namespace VanOns\Laraberg\Blocks\Wordpress;

/**
 * Class WordPressBlockParser
 *
 * Parses a document and constructs a list of parsed block objects
 *
 * @since 5.0.0
 * @since 4.0.0 returns arrays not objects, all attributes are arrays
 */
class WordPressBlockParser
{
    /**
     * Input document being parsed
     *
     * @example "Pre-text\n<!-- wp:paragraph -->This is inside a block!<!-- /wp:paragraph -->"
     *
     * @since 5.0.0
     * @var string
     */
    public string $document;

    /**
     * Tracks parsing progress through document
     *
     * @since 5.0.0
     * @var int
     */
    public int $offset;

    /**
     * List of parsed blocks
     *
     * @since 5.0.0
     * @var WordPressBlockParserBlock[]
     */
    public array $output;

    /**
     * Stack of partially-parsed structures in memory during parse
     *
     * @since 5.0.0
     * @var WordPressBlockParserFrame[]
     */
    public array $stack;

    /**
     * Empty associative array, here due to PHP quirks
     *
     * @since 4.4.0
     * @var array empty associative array
     */
    public array $emptyAttrs;

    /**
     * Parses a document and returns a list of block structures
     *
     * When encountering an invalid parse will return a best-effort
     * parse. In contrast to the specification parser this does not
     * return an error on invalid inputs.
     *
     * @since 5.0.0
     *
     * @param string $document Input document being parsed.
     *
     * @return WordPressBlockParserBlock[]
     */
    public function parse(string $document): array
    {
        $this->document    = $document;
        $this->offset      = 0;
        $this->output      = [];
        $this->stack       = [];
        $this->emptyAttrs = json_decode('{}', true);

        do {
            // twiddle our thumbs.
        } while ($this->proceed());

        return $this->output;
    }

    /**
     * Processes the next token from the input document
     * and returns whether to proceed eating more tokens
     *
     * This is the "next step" function that essentially
     * takes a token as its input and decides what to do
     * with that token before descending deeper into a
     * nested block tree or continuing along the document
     * or breaking out of a level of nesting.
     *
     * @internal
     * @since 5.0.0
     * @return bool
     */
    public function proceed(): bool
    {
        $nextToken = $this->next_token();
        [$tokenType, $blockName, $attrs, $startOffset, $tokenLength] = $nextToken;
        $stackDepth = count($this->stack);

        // we may have some HTML soup before the next block.
        $leadingHtmlStart = $startOffset > $this->offset ? $this->offset : null;

        switch ($tokenType) {
            case 'no-more-tokens':
                // if not in a block then flush output.
                if (0 === $stackDepth) {
                    $this->addFreeform();
                    return false;
                }

                /*
                 * Otherwise we have a problem
                 * This is an error
                 *
                 * we have options
                 * - treat it all as freeform text
                 * - assume an implicit closer (easiest when not nesting)
                 */

                // for the easy case we'll assume an implicit closer.
                if (1 === $stackDepth) {
                    $this->addBlockFromStack();
                    return false;
                }

                /*
                 * for the nested case where it's more difficult we'll
                 * have to assume that multiple closers are missing
                 * and so we'll collapse the whole stack piecewise
                 */
                while (0 < count($this->stack)) {
                    $this->addBlockFromStack();
                }
                return false;

            case 'void-block':
                /*
                 * easy case is if we stumbled upon a void block
                 * in the top-level of the document
                 */
                if (0 === $stackDepth) {
                    if (isset($leadingHtmlStart)) {
                        $this->output[] = (array) $this->freeform(
                            substr(
                                $this->document,
                                $leadingHtmlStart,
                                $startOffset - $leadingHtmlStart
                            )
                        );
                    }

                    $this->output[] = (array) new WordPressBlockParserBlock($blockName, $attrs, [], '', []);
                    $this->offset   = $startOffset + $tokenLength;
                    return true;
                }

                // otherwise we found an inner block.
                $this->addInnerBlock(
                    new WordPressBlockParserBlock($blockName, $attrs, [], '', []),
                    $startOffset,
                    $tokenLength
                );
                $this->offset = $startOffset + $tokenLength;
                return true;

            case 'block-opener':
                // track all newly-opened blocks on the stack.
                $this->stack[] = new WordPressBlockParserFrame(
                    new WordPressBlockParserBlock($blockName, $attrs, [], '', []),
                    $startOffset,
                    $tokenLength,
                    $startOffset + $tokenLength,
                    $leadingHtmlStart
                );
                $this->offset = $startOffset + $tokenLength;
                return true;

            case 'block-closer':
                /*
                 * if we're missing an opener we're in trouble
                 * This is an error
                 */
                if (0 === $stackDepth) {
                    /*
                     * we have options
                     * - assume an implicit opener
                     * - assume _this_ is the opener
                     * - give up and close out the document
                     */
                    $this->addFreeform();
                    return false;
                }

                // if we're not nesting then this is easy - close the block.
                if (1 === $stackDepth) {
                    $this->addBlockFromStack($startOffset);
                    $this->offset = $startOffset + $tokenLength;
                    return true;
                }

                /*
                 * otherwise we're nested, and we have to close out the current
                 * block and add it as a new innerBlock to the parent
                 */
                $stackTop                         = array_pop($this->stack);
                $html                             = substr($this->document, $stackTop->prevOffset, $startOffset - $stackTop->prevOffset);
                $stackTop->block->innerHTML      .= $html;
                $stackTop->block->innerContent[]  = $html;
                $stackTop->prevOffset             = $startOffset + $tokenLength;

                $this->addInnerBlock(
                    $stackTop->block,
                    $stackTop->tokenStart,
                    $stackTop->tokenLength,
                    $startOffset + $tokenLength
                );
                $this->offset = $startOffset + $tokenLength;
                return true;

            default:
                // This is an error.
                $this->addFreeform();
                return false;
        }
    }

    /**
     * Scans the document from where we last left off
     * and finds the next valid token to parse if it exists
     *
     * Returns the type of the find: kind of find, block information, attributes
     *
     * @internal
     * @since 5.0.0
     * @since 4.6.1 fixed a bug in attribute parsing which caused catastrophic backtracking on invalid block comments
     * @return array
     */
    public function next_token(): array
    {
        $matches = null;

        /*
         * aye the magic
         * we're using a single RegExp to tokenize the block comment delimiters
         * we're also using a trick here because the only difference between a
         * block opener and a block closer is the leading `/` before `wp:` (and
         * a closer has no attributes). we can trap them both and process the
         * match back in PHP to see which one it was.
         */
        $hasMatch = preg_match(
            '/<!--\s+(?P<closer>\/)?wp:(?P<namespace>[a-z][a-z0-9_-]*\/)?(?P<name>[a-z][a-z0-9_-]*)\s+(?P<attrs>{(?:(?:[^}]+|}+(?=})|(?!}\s+\/?-->).)*+)?}\s+)?(?P<void>\/)?-->/s',
            $this->document,
            $matches,
            PREG_OFFSET_CAPTURE,
            $this->offset
        );

        // if we get here we probably have catastrophic backtracking or out-of-memory in the PCRE.
        if (false === $hasMatch) {
            return ['no-more-tokens', null, null, null, null];
        }

        // we have no more tokens.
        if (0 === $hasMatch) {
            return ['no-more-tokens', null, null, null, null];
        }

        [$match, $startedAt] = $matches[0];

        $length    = strlen($match);
        $isCloser  = isset($matches['closer']) && -1 !== $matches['closer'][1];
        $isVoid    = isset($matches['void']) && -1 !== $matches['void'][1];
        $namespace = $matches['namespace'];
        $namespace = (isset($namespace) && -1 !== $namespace[1]) ? $namespace[0] : 'core/';
        $name      = $namespace . $matches['name'][0];
        $has_attrs = isset($matches['attrs']) && -1 !== $matches['attrs'][1];

        /*
         * Fun fact! It's not trivial in PHP to create "an empty associative array" since all arrays
         * are associative arrays. If we use `array()` we get a JSON `[]`
         */
        $attrs = $has_attrs
            ? json_decode($matches['attrs'][0], /* as-associative */ true)
            : $this->emptyAttrs;

        /*
         * This state isn't allowed
         * This is an error
         */
        if ($isCloser && ($isVoid || $has_attrs)) {
            // we can ignore them since they don't hurt anything.
        }

        if ($isVoid) {
            return ['void-block', $name, $attrs, $startedAt, $length];
        }

        if ($isCloser) {
            return ['block-closer', $name, null, $startedAt, $length];
        }

        return ['block-opener', $name, $attrs, $startedAt, $length];
    }

    /**
     * Returns a new block object for freeform HTML
     *
     * @internal
     * @since 3.9.0
     *
     * @param string $innerHTML HTML content of block.
     * @return WordPressBlockParserBlock freeform block object.
     */
    public function freeform(string $innerHTML): WordPressBlockParserBlock
    {
        return new WordPressBlockParserBlock(null, $this->emptyAttrs, [], $innerHTML, [$innerHTML]);
    }

    /**
     * Pushes a length of text from the input document
     * to the output list as a freeform block.
     *
     * @internal
     * @since 5.0.0
     * @param null $length how many bytes of document text to output.
     */
    public function addFreeform($length = null): void
    {
        $length = $length ?: strlen($this->document) - $this->offset;

        if (0 === $length) {
            return;
        }

        $this->output[] = (array) $this->freeform(substr($this->document, $this->offset, $length));
    }

    /**
     * Given a block structure from memory pushes
     * a new block to the output list.
     *
     * @internal
     * @since 5.0.0
     * @param WordPressBlockParserBlock $block        The block to add to the output.
     * @param int                   $tokenStart  Byte offset into the document where the first token for the block starts.
     * @param int                   $tokenLength Byte length of entire block from start of opening token to end of closing token.
     * @param int|null              $lastOffset  Last byte offset into document if continuing form earlier output.
     */
    public function addInnerBlock(WordPressBlockParserBlock $block, int $tokenStart, int $tokenLength, ?int $lastOffset = null): void
    {
        $parent                       = $this->stack[count($this->stack) - 1];
        $parent->block->innerBlocks[] = (array) $block;
        $html                         = substr($this->document, $parent->prevOffset, $tokenStart - $parent->prevOffset);

        if (! empty($html)) {
            $parent->block->innerHTML     .= $html;
            $parent->block->innerContent[] = $html;
        }

        $parent->block->innerContent[] = null;
        $parent->prevOffset            = $lastOffset ?: $tokenStart + $tokenLength;
    }

    /**
     * Pushes the top block from the parsing stack to the output list.
     *
     * @internal
     * @since 5.0.0
     * @param int|null $endOffset byte offset into document for where we should stop sending text output as HTML.
     */
    public function addBlockFromStack(?int $endOffset = null): void
    {
        $stackTop   = array_pop($this->stack);
        $prevOffset = $stackTop->prevOffset;

        $html = isset($endOffset)
            ? substr($this->document, $prevOffset, $endOffset - $prevOffset)
            : substr($this->document, $prevOffset);

        if (! empty($html)) {
            $stackTop->block->innerHTML     .= $html;
            $stackTop->block->innerContent[] = $html;
        }

        if (isset($stackTop->leadingHtmlStart)) {
            $this->output[] = (array) $this->freeform(
                substr(
                    $this->document,
                    $stackTop->leadingHtmlStart,
                    $stackTop->tokenStart - $stackTop->leadingHtmlStart
                )
            );
        }

        $this->output[] = (array) $stackTop->block;
    }
}
