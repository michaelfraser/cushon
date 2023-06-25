<?php

declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

$header = <<<'EOF'
This file is part of PHP CS Fixer.
(c) Fabien Potencier <fabien@symfony.com>
    Dariusz Rumiński <dariusz.ruminski@gmail.com>
This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('db')
    ->exclude('bin')
    ->exclude('docker')
    ->exclude('test-reports')
    ->exclude('var')
    ->exclude('vendor')
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'align_multiline_comment' => ['comment_type' => 'phpdocs_only'],
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_after_opening_tag' => false,
        'binary_operator_spaces' => true,
        'braces' => ['position_after_functions_and_oop_constructs' => 'next'],
        'cast_spaces' => ['space' => 'single'],
        'class_attributes_separation' => ['elements' => ['method' => 'one']],
        'concat_space' => ['spacing' => 'one'],
        'fully_qualified_strict_types' => true,
        'function_typehint_space' => true,
        'include' => true,
        'lowercase_cast' => true,
        'lowercase_static_reference' => true,
        'linebreak_after_opening_tag' => false,
        'magic_constant_casing' => true,
        'magic_method_casing' => true,
        'mb_str_functions' => false, // Risky if any of the functions are overridden
        'modernize_types_casting' => false, // Risky if any of the functions are overridden
        'native_function_casing' => true,
        'native_function_type_declaration_casing' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_mixed_echo_print' => ['use' => 'echo'],
        'no_null_property_initialization' => true,
        'no_unused_imports' => true,
        'no_useless_else' => false,
        'no_useless_return' => true,
        'no_whitespace_in_blank_line' => true,
        'normalize_index_brace' => true,
        'object_operator_without_whitespace' => true,
        'protected_to_private' => true,
        'return_type_declaration' => [ 'space_before' => 'none' ],
        'single_quote' => true,
        'space_after_semicolon' => true,
        'standardize_not_equals' => true,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline' => true,
        'unary_operator_spaces' => true,
        'visibility_required' => ['elements' => ['method', 'property', 'const']],
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder)
;
