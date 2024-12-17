<?php

namespace VanOns\Laraberg\Blocks\Wordpress;

/**
 * Class WordPressBlockParserFrame
 *
 * Holds partial blocks in memory while parsing
 *
 * @internal
 * @since 5.0.0
 */
class WordPressBlockParserFrame
{
    /**
     * Full or partial block
     *
     * @since 5.0.0
     * @var WordPressBlockParserBlock
     */
    public WordPressBlockParserBlock $block;

    /**
     * Byte offset into document for start of parse token
     *
     * @since 5.0.0
     * @var int
     */
    public int $tokenStart;

    /**
     * Byte length of entire parse token string
     *
     * @since 5.0.0
     * @var int
     */
    public int $tokenLength;

    /**
     * Byte offset into document for after parse token ends
     * (used during reconstruction of stack into parse production)
     *
     * @since 5.0.0
     * @var int
     */
    public int $prevOffset;

    /**
     * Byte offset into document where leading HTML before token starts
     *
     * @since 5.0.0
     * @var int|null
     */
    public ?int $leadingHtmlStart;

    /**
     * Constructor
     *
     * Will populate object properties from the provided arguments.
     *
     * @since 5.0.0
     *
     * @param WordPressBlockParserBlock $block            Full or partial block.
     * @param int                       $tokenStart       Byte offset into document for start of parse token.
     * @param int                       $tokenLength      Byte length of entire parse token string.
     * @param int|null                  $prevOffset       Byte offset into document for after parse token ends.
     * @param int|null                  $leadingHtmlStart Byte offset into document where leading HTML before token starts.
     */
    public function __construct(WordPressBlockParserBlock $block, int $tokenStart, int $tokenLength, int $prevOffset = null, ?int $leadingHtmlStart = null)
    {
        $this->block            = $block;
        $this->tokenStart       = $tokenStart;
        $this->tokenLength      = $tokenLength;
        $this->prevOffset       = $prevOffset ?? $tokenStart + $tokenLength;
        $this->leadingHtmlStart = $leadingHtmlStart;
    }
}
