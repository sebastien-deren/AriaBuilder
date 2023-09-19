<?php

declare(strict_types=1);

namespace App\Infrastucture\Doctrine\Collection;

use App\Domain\Collection\CollectionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

abstract class Collection extends ArrayCollection
{
    protected Collection $collection;
    public function __construct(protected EntityManager $entityManager)
    {
    }
    public function filter(\Closure $p): static
    {
        return $this->collection->filter($p);
    }
    public function map(\Closure $p): static
    {
        return $this->collection->map($p);
    }

    /**
     * Checks whether an element is contained in the collection.
     * This is an O(n) operation, where n is the size of the collection.
     *
     * @param mixed $element The element to search for.
     * @psalm-param TMaybeContained $element
     *
     * @return bool TRUE if the collection contains the element, FALSE otherwise.
     * @psalm-return (TMaybeContained is T ? bool : false)
     *
     * @template TMaybeContained
     */
    public function contains(mixed $element)
    {
        return $this->collection->contains($element);
    }
    /**
     * Adds an element at the end of the collection.
     *
     * @param mixed $element The element to add.
     * @psalm-param T $element
     */
    public function add(mixed $element)
    {
        return $this->collection->add($element);
    }
    /**
     * Removes the specified element from the collection, if it is found.
     *
     * @param mixed $element The element to remove.
     * @psalm-param T $element
     *
     * @return bool TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeElement(mixed $element)
    {
        return $this->collection->removeElement($element);
    }
}
