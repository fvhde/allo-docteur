<?php

declare(strict_types=1);

$finder = new PhpCsFixer\Finder();
$finder
    ->in(__DIR__)
    ->exclude(['var', 'bin'])
;

// change the order of |'case', 'constant_public', 'constant_protected', 'constant_private'|
//   by |'constant_public', 'constant_protected', 'constant_private', 'case'|
//   in order to allow case using self file constants.
$ENUMCASE_AFTER_ENUMCONST = ['use_trait', 'constant_public', 'constant_protected', 'constant_private', 'case', 'property_public', 'property_protected', 'property_private', 'construct', 'destruct', 'magic', 'phpunit', 'method_public', 'method_protected', 'method_private'];

return (new PhpCsFixer\Config())
    ->setCacheFile('.php_cs.cache')
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'no_whitespace_in_blank_line' => true,
        'ordered_class_elements' => [
            'order' => $ENUMCASE_AFTER_ENUMCONST,
        ],
        'ordered_imports' => true,
    ])
    ->setFinder($finder)
;
