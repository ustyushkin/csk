<?php
/**
 * Created by IntelliJ IDEA.
 * User: yustas
 * Date: 31.08.19
 * Time: 15:31
 */

namespace CSK;

class QueryCollection implements \Countable, \Iterator, \ArrayAccess
{

    private $values = [];
    private $position = 0;

    /**
     * This constructor is there in order to be able to create a collection with
     * its values already added
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $value) {
            $this->offsetSet('', $value);
        }
    }

    /**
     * Implementation of method declared in \Countable.
     * Provides support for count()
     */
    public function count()
    {
        return count($this->values);
    }

    /**
     * Implementation of method declared in \Iterator
     * Resets the internal cursor to the beginning of the array
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Implementation of method declared in \Iterator
     * Used to get the current key (as for instance in a foreach()-structure
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Implementation of method declared in \Iterator
     * Used to get the value at the current cursor position
     */
    public function current()
    {
        return $this->values[$this->position];
    }

    /**
     * Implementation of method declared in \Iterator
     * Used to move the cursor to the next position
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Implementation of method declared in \Iterator
     * Checks if the current cursor position is valid
     */
    public function valid()
    {
        return isset($this->values[$this->position]);
    }

    /**
     * Implementation of method declared in \ArrayAccess
     * Used to be able to use functions like isset()
     */
    public function offsetExists($offset)
    {
        return isset($this->values[$offset]);
    }

    /**
     * Implementation of method declared in \ArrayAccess
     * Used for direct access array-like ($collection[$offset]);
     */
    public function offsetGet($offset)
    {
        return $this->values[$offset];
    }

    /**
     * Implementation of method declared in \ArrayAccess
     * Used for direct setting of values
     */
    public function offsetSet($offset, $value)
    {
        /*if (!is_int($value)) {
            throw new \InvalidArgumentException("Must be an int");
        }*/

        if (empty($offset)) { //this happens when you do $collection[] = 1;
            $this->values[] = $value;
        } else {
            $this->values[$offset] = $value;
        }
    }

    /**
     * Implementation of method declared in \ArrayAccess
     * Used for unset()
     */
    public function offsetUnset($offset)
    {
        unset($this->values[$offset]);
    }
}