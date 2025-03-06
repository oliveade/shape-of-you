<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('config')
    ->exclude('var')
    ->exclude('public/bundles')
    ->exclude('public/build')
    ->notPath('public/index.php')
    ->notPath('importmap.php')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
		'no_whitespace_in_blank_line' => false,
		'indentation_type' => false,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__.'/var/.php-cs-fixer.cache')
    ;

