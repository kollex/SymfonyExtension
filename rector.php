<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertEqualsToSameRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\Set\SymfonySetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->sets(
        [
            LevelSetList::UP_TO_PHP_82,
            SymfonySetList::SYMFONY_64,
            SymfonySetList::SYMFONY_CODE_QUALITY,
            SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
            SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
        ]
    );

    $rectorConfig->skip(
        [
            AssertEqualsToSameRector::class => [
                __DIR__ . '/tests',
            ],
        ]
    );
};
