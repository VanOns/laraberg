<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'example',
        'node_modules',
        'public',
        'resources',
        'vendor',
        'webpack',
    ]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => [
            'syntax' => 'short'
        ],
        "array_indentation" => true,
        "explicit_indirect_variable" => true,
        "explicit_string_variable" => true,
        "method_chaining_indentation" => true,
        "no_unused_imports" => true,
        "single_quote" => true,
        "trailing_comma_in_multiline" => true
    ])
    ->setFinder($finder)
;
