<?php

declare(strict_types=1);

namespace FriendsOfBehat\SymfonyExtension\Driver\Factory;

use Behat\Mink\Driver\BrowserKitDriver;
use Behat\MinkExtension\ServiceContainer\Driver\DriverFactory;
use FriendsOfBehat\SymfonyExtension\Driver\SymfonyDriver;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final readonly class SymfonyDriverFactory implements DriverFactory
{
    public function __construct(private string $name, private Reference $kernel)
    {
    }

    public function getDriverName(): string
    {
        return $this->name;
    }

    public function supportsJavascript(): bool
    {
        return false;
    }

    public function configure(ArrayNodeDefinition $builder): void
    {
    }

    public function buildDriver(array $config): Definition
    {
        if (!class_exists(BrowserKitDriver::class)) {
            throw new \RuntimeException('Install "friends-of-behat/mink-browserkit-driver" (drop-in replacement for "behat/mink-browserkit-driver") in order to use the "symfony" driver.');
        }

        return new Definition(SymfonyDriver::class, [
            $this->kernel,
            '%mink.base_url%',
        ]);
    }
}
