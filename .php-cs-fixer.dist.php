<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PhpCsFixer' => true,
        'phpdoc_to_comment' => false,
        'PedroTroller/line_break_between_method_arguments' => [ 'max-args' => 1, 'max-length' => 100, 'automatic-argument-merge' => true, 'inline-attributes' => true ]
    ])
    ->setFinder($finder)
    ->registerCustomFixers(new PedroTroller\CS\Fixer\Fixers());
;
