<?php

namespace VanOns\Laraberg\Blocks\Wordpress;

/**
 * Class WP_Block_Parser_Frame
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
    public $block;

    /**
     * Byte offset into document for start of parse token
     *
     * @since 5.0.0
     * @var int
     */
    public $tokenStart;

    /**
     * Byte length of entire parse token string
     *
     * @since 5.0.0
     * @var int
     */
    public $tokenLength;

    /**
     * Byte offset into document for after parse token ends
     * (used during reconstruction of stack into parse production)
     *
     * @since 5.0.0
     * @var int
     */
    public $prevOffset;

    /**
     * Byte offset into document where leading HTML before token starts
     *
     * @since 5.0.0
     * @var int
     */
    public $leadingHtmlStart;

    /**
     * Constructor
     *
     * Will populate object properties from the provided arguments.
     *
     * @since 5.0.0
     *
     * @param WordPressBlockParserBlock $block              Full or partial block.
     * @param int                   $token_start        Byte offset into document for start of parse token.
     * @param int                   $token_length       Byte length of entire parse token string.
     * @param int                   $prev_offset        Byte offset into document for after parse token ends.
     * @param int                   $leading_html_start Byte offset into document where leading HTML before token starts.
     */
    public function __construct($block, $token_start, $token_length, $prev_offset = null, $leading_html_start = null)
    {
        $this->block              = $block;
        $this->tokenStart        = $token_start;
        $this->tokenLength       = $token_length;
        $this->prevOffset        = isset($prev_offset) ? $prev_offset : $token_start + $token_length;
        $this->leadingHtmlStart = $leading_html_start;
    }
}
