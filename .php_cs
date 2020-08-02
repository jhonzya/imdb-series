<?php

/*
|------------------------------------------------------------------------------
| PHP-CS-Fixer
|------------------------------------------------------------------------------
|
| The "Laravel rules" are the same as in the official laravel/framework repo,
| but updated to PHP-CS-Fixer version 2.0 rule names.
|
*/

$rules = [
    // laravel framework rules
    'array_syntax' => ['syntax' => 'short'],
    'binary_operator_spaces' => ['align_equals' => false],
    'binary_operator_spaces' => true,
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_return' => true,
    'braces' => true,
    'cast_spaces' => true,
    'concat_space' => ['spacing' => 'none'],
    'elseif' => true,
    'encoding' => true,
    'full_opening_tag' => true,
    'function_declaration' => true,
    'include' => true,
    'indentation_type' => true,
    'line_ending' => true,
    'not_operator_with_successor_space' => true,
    'lowercase_constants' => true,
    'lowercase_keywords' => true,
    'method_argument_space' => true,
    'no_alias_functions' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_empty_statement' => true,
    'no_extra_consecutive_blank_lines' => ['use'],
    'no_extra_consecutive_blank_lines' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_multiline_whitespace_before_semicolons' => true,
    'no_short_echo_tag' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_after_function_name' => true,
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_comma_in_list_call' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_trailing_whitespace' => true,
    'no_unused_imports' => true,
    'no_whitespace_in_blank_line' => true,
    'object_operator_without_whitespace' => true,
    'phpdoc_indent' => true,
    'phpdoc_inline_tag' => true,
    'phpdoc_no_access' => true,
    'phpdoc_no_alias_tag' => ['type' => 'var'],
    'phpdoc_no_package' => true,
    'phpdoc_scalar' => true,
    'phpdoc_summary' => true,
    'phpdoc_to_comment' => true,
    'phpdoc_trim' => true,
    'phpdoc_var_without_name' => true,
    'self_accessor' => true,
    'simplified_null_return' => true,
    'single_blank_line_at_eof' => true,
    'single_blank_line_before_namespace' => true,
    'single_import_per_statement' => true,
    'single_line_after_imports' => true,
    'single_quote' => true,
    'standardize_not_equals' => true,
    'ternary_operator_spaces' => true,
    'trailing_comma_in_multiline_array' => true,
    'trim_array_spaces' => true,
    'unary_operator_spaces' => true,
    'visibility_required' => true,

    // app custom rules
    'blank_line_before_statement' => [
        'statements' => [
            'declare', 'die', 'do', 'exit', 'for', 'foreach', 'goto', 'if', 'include', 'include_once',
            'require', 'require_once', 'return', 'switch', 'throw', 'try', 'while', 'yield',
        ]
    ],
    'mb_str_functions' => false,
    'no_useless_return' => true,
    'ordered_imports' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_annotation_without_dot' => true,
    'phpdoc_order' => true,
    'protected_to_private' => true,
    'ternary_to_null_coalescing' => true,
    'whitespace_after_comma_in_array' => true,
];

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'bootstrap/cache',
        'node_modules',
        'resources/views',
        'storage',
        'vendor',
    ])
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setRules($rules)
    ->setUsingCache(true);
