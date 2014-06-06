<?php

namespace Pinq\Iterators;

/**
 * Interface for a factory for the required range of iterator classes
 * to fulfill the ITraversable iteraface.
 *
 * @author Elliot Levin <elliot@aanet.com.au>
 */
interface IIteratorScheme
{
    const IITERATOR_SCHEME_TYPE = __CLASS__;
    
    /**
     * Creates an ordered map from the supplied iterator.
     * Keys can only be associated with a single value and such
     * if the iterator returns duplicate keys the last respective
     * value will be used.
     * 
     * @return IOrderedMap
     */
    public function createOrderedMap(\Traversable $iterator = null);
    
    /**
     * Creates an ordered map from the supplied array of keys and values.
     * The key value pairs are associated by their order in their array.
     * 
     * @throws \Pinq\PinqException If the supplied arrays are not equal in length
     * @return IOrderedMap
     */
    public function createOrderedMapFrom(array $keys, array $values);
    
    /**
     * Creates an set from the supplied iterator values.
     * A set can only contain unique values and such duplicates
     * will be lost.
     * 
     * @return ISet
     */
    public function createSet(\Traversable $iterator = null);

    /**
     * Returns the supplied traversable or array as an iterator
     * compatible with this scheme.
     * 
     * @param \Traversable|array $traversableOrArray
     * @return \Traversable
     */
    public function toIterator($traversableOrArray);
    
    /**
     * Safely converts the supplied iterator to an array.
     * Non scalar keys will be reindexed to respective incremented integers.
     * 
     * @return array
     */
    public function toArray(\Traversable $iterator);
    
    /**
     * Iterate over the keys and values of the supplied iterator and
     * passes them (value, key) to the supplied function.
     * 
     * @return void
     */
    public function walk(\Traversable $iterator, callable $function);
    
    /**
     * Returns an iterator for the supplied array.
     * 
     * @param array $array
     * @return \Traversable
     */
    public function arrayIterator(array $array);
    
    /**
     * Returns an iterator which will map any non scalar keys
     * to incrementing integers.
     * 
     * @param \Traversable  $iterator
     * @return \Traversable
     */
    public function arrayCompatibleIterator(\Traversable $iterator);

    /**
     * Returns an empty iterator.
     * 
     * @return \Traversable
     */
    public function emptyIterator();
    
    /**
     * Returns an iterator which will filter the elements according to
     * the supplied predicate function.
     * 
     * @param \Traversable  $iterator
     * @param callable      $predicate
     * @return \Traversable
     */
    public function filterIterator(\Traversable $iterator, callable $predicate);

    /**
     * Returns an iterator with will sort the elements according to
     * the supplied function and direction.
     * 
     * @param \Traversable  $iterator
     * @param callable      $function
     * @param boolean       $isAscending
     * @return IOrderedIterator
     */
    public function orderedIterator(\Traversable $iterator, callable $function, $isAscending);

    /**
     * Returns an iterator which will group the elements according to
     * the supplied function and wrap each group in a traversable 
     * implementation from the supplied factory.
     * 
     * @param \Traversable  $iterator
     * @param callable      $groupKeyFunction
     * @param callable      $traversableFactory
     * @return \Traversable
     */
    public function groupedIterator(
            \Traversable $iterator, 
            callable $groupKeyFunction,
            callable $traversableFactory);

    /**
     * Returns an iterator which will only iterate the elements in the
     * supplied range.
     * 
     * @param \Traversable  $iterator
     * @param int           $start
     * @param int|null      $amount
     * @return \Traversable
     */
    public function rangeIterator(\Traversable $iterator, $start, $amount);

    /**
     * Returns an iterator which will return the elements mapped by
     * the supplied functions or the original if no function is supplied.
     * 
     * @param \Traversable  $iterator
     * @param callable|null $keyProjectionFunction
     * @param callable|null $valueProjectionFunction
     * @return \Traversable
     */
    public function projectionIterator(
            \Traversable $iterator, 
            callable $keyProjectionFunction = null, 
            callable $valueProjectionFunction = null);

    /**
     * Returns an iterator which will return the outer elements joined
     * to the inner elements according to the supplied join on function.
     * Each outer and inner element will be mapped to a value according to 
     * the joining function.
     * 
     * \Traversable $outerIterator, 
     * \Traversable $innerIterator,
     * @param callable $joinOnFunction
     * @param callable $joiningFunction
     * @return \Traversable
     */
    public function customJoinIterator(
            \Traversable $outerIterator, 
            \Traversable $innerIterator,
            callable $joinOnFunction,
            callable $joiningFunction);

    /**
     * Returns an iterator which will return the outer elements joined
     * to the inner elements according to strict equality on the returned
     * values for each inner and outer element. Each outer and inner element 
     * will be mapped to a value according to the joining function.
     * 
     * \Traversable $outerIterator, 
     * \Traversable $innerIterator,
     * @param callable $outerKeyFunction
     * @param callable $innerKeyFunction
     * @param callable $joiningFunction
     * @return \Traversable
     */
    public function equalityJoinIterator(
            \Traversable $outerIterator, 
            \Traversable $innerIterator,
            callable $outerKeyFunction, 
            callable $innerKeyFunction, 
            callable $joiningFunction);

    /**
     * Returns an iterator which will return the outer elements joined
     * to the inner elements according to the supplied join on function.
     * All matched inner elements for each outer element will be wrapped 
     * in a traversable implementation from the supplied factory. Each 
     * outer element and inner group will be mapped to a value according to 
     * the joining function.
     * 
     * \Traversable $outerIterator, 
     * \Traversable $innerIterator,
     * @param callable $joinOnFunction
     * @param callable $joiningFunction
     * @param callable $traversableFactory
     * @return \Traversable
     */
    public function customGroupJoinIterator(
            \Traversable $outerIterator, 
            \Traversable $innerIterator,
            callable $joinOnFunction,
            callable $joiningFunction,
            callable $traversableFactory);

    /**
     * Returns an iterator which will return the outer elements joined
     * to the inner elements according to strict equality on the returned
     * values for each inner and outer element. All matched inner elements 
     * for each outer element will be wrapped in a traversable implementation 
     * from the supplied factory. Each outer element and inner group will 
     * be mapped to a value according to the joining function.
     * 
     * \Traversable $outerIterator, 
     * \Traversable $innerIterator,
     * @param callable $outerKeyFunction
     * @param callable $innerKeyFunction
     * @param callable $joiningFunction
     * @param callable $traversableFactory
     * @return \Traversable
     */
    public function equalityGroupJoinIterator(
            \Traversable $outerIterator, 
            \Traversable $innerIterator,
            callable $outerKeyFunction, 
            callable $innerKeyFunction, 
            callable $joiningFunction,
            callable $traversableFactory);

    /**
     * Returns an iterator which will iterate each element
     * of the inner iterator's values. An exception will be thrown
     * if an invalid iterator is returned from the supplied iterator.
     * 
     * @param \Traversable  $iterator
     * @return \Traversable
     */
    public function flattenedIterator(\Traversable $iterator);
    
    /**
     * Returns an iterator which will return unique values using
     * strict equality.
     * 
     * @param \Traversable  $iterator
     * @return \Traversable
     */
    public function uniqueIterator(\Traversable $iterator);

    /**
     * Returns an iterator which will return all values from both
     * the supplied iterators.
     * 
     * @param \Traversable  $iterator
     * @param \Traversable  $otherIterator
     * @return \Traversable
     */
    public function appendIterator(\Traversable $iterator, \Traversable $otherIterator);

    /**
     * Returns an iterator which will return all values in the first
     * iterator present in the second.
     * 
     * @param \Traversable  $iterator
     * @param \Traversable  $otherIterator
     * @return \Traversable
     */
    public function whereInIterator(\Traversable $iterator, \Traversable $otherIterator);

    /**
     * Returns an iterator which will return all values in the first
     * but not present in the second iterator.
     * 
     * @param \Traversable  $iterator
     * @param \Traversable  $otherIterator
     * @return \Traversable
     */
    public function exceptIterator(\Traversable $iterator, \Traversable $otherIterator);

    /**
     * Returns an iterator which will return unique values present 
     * in the first or second iterator.
     * 
     * @param \Traversable  $iterator
     * @param \Traversable  $otherIterator
     * @return \Traversable
     */
    public function unionIterator(\Traversable $iterator, \Traversable $otherIterator);

    /**
     * Returns an iterator which will return unique values present 
     * in the first and second iterator.
     * 
     * @param \Traversable  $iterator
     * @param \Traversable  $otherIterator
     * @return \Traversable
     */
    public function intersectionIterator(\Traversable $iterator, \Traversable $otherIterator);

    /**
     * Returns an iterator which will return uniqe values present 
     * in the first but not the second iterator.
     * 
     * @param \Traversable  $iterator
     * @param \Traversable  $otherIterator
     * @return \Traversable
     */
    public function differenceIterator(\Traversable $iterator, \Traversable $otherIterator);
}