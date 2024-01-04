<?php

declare(strict_types=1);

namespace FriendsOfBehat\SymfonyExtension\Mink;

use ArrayAccess;
use IteratorAggregate;
use ReturnTypeWillChange;

/**
 * @template-implements ArrayAccess<int,int>
 * @template-implements IteratorAggregate<string, int>
 */
class MinkParameters implements \Countable, IteratorAggregate, ArrayAccess
{
    public function __construct(private array $minkParameters)
    {
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->minkParameters);
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->minkParameters);
    }

    #[ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->minkParameters[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        throw new \BadMethodCallException(sprintf('"%s" is immutable.', self::class));
    }

    public function offsetUnset($offset): void
    {
        throw new \BadMethodCallException(sprintf('"%s" is immutable.', self::class));
    }

    public function count(): int
    {
        return count($this->minkParameters);
    }
}
