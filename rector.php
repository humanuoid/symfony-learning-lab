<?php

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withRules([
        TypedPropertyFromStrictConstructorRector::class
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true
    )
    ->withPreparedSets(symfonyCodeQuality: true)
    ->withComposerBased(symfony: true)
    ->withPreparedSets(doctrineCodeQuality: true)
    ->withComposerBased(doctrine: true);
