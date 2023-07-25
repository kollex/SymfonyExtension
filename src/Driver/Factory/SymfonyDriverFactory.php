<?php

namespace FriendsOfBehat\SymfonyExtension\Driver\Factory;

use Behat\MinkExtension\ServiceContainer\Driver\DriverFactory;
use FriendsOfBehat\SymfonyExtension\Driver\SymfonyDriver;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class SymfonyDriverFactory implements DriverFactory
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Reference
     */
    private $kernel;

    /**
     * @param string $name
     * @param Reference $kernel
     */
    public function __construct($name, Reference $kernel)
    {
        $this->name = $name;
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function getDriverName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsJavascript()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function buildDriver(array $config)
    {
        return new Definition(SymfonyDriver::class, [
            $this->kernel,
            '%mink.base_url%',
        ]);
    }
}
