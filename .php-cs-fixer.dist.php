<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('var')
    ->notPath([
        'config/bundles.php',
        'config/reference.php',
    ])
;

// Instanciation directe au lieu de Config::create()
$config = new Config();
$config->setRules([
    // Espacement & indentation
    'indentation_type' => true,
    'no_trailing_whitespace' => true,
    'no_whitespace_in_blank_line' => true,
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_statement' => ['statements' => ['return', 'throw', 'continue', 'break']],
    'array_indentation' => true,
    'binary_operator_spaces' => ['default' => 'single_space'],
    'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],

    // Lignes vides
    'no_extra_blank_lines' => ['tokens' => ['extra', 'throw', 'use', 'curly_brace_block', 'parenthesis_brace_block', 'square_brace_block']],

    // Use / imports (tri uniquement, ne supprime rien)
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'single_import_per_statement' => true,
    // 'no_unused_imports' => true,  // ⚠ pas activé, pourrait supprimer un use

    // Style général
    'lowercase_keywords' => true,
    'single_quote' => true,
    'concat_space' => ['spacing' => 'one'],
    'trailing_comma_in_multiline' => ['elements' => ['arrays']],
    'braces' => ['position_after_functions_and_oop_constructs' => 'same', 'position_after_control_structures' => 'same'],
    'visibility_required' => ['elements' => ['method', 'property']],

    // Docblocks / commentaires
    'phpdoc_align' => true,
    'phpdoc_order' => true,
    'phpdoc_trim' => true,
    'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'alpha'],
]);

$config->setFinder($finder);

return $config;