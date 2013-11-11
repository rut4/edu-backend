<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 01.11.13
 * Time: 0:27
 */

class Collection implements Iterator
{
    protected $_collection = array();
    private $_limit = 0;
    private $_offset = 0;
    private $_sortField = null;

    private $_position = 0;

    public function __construct(array $collection)
    {
        $this->_collection = $collection;
        $this->_limit = count($collection);
    }

    protected function getCollection()
    {
        if (isset($this->_sortField))
        {
            usort($this->_collection,
                function (CollectionElement $first, CollectionElement $second)
                {
                    return $first[$this->_sortField] > $second[$this->_sortField];
                });
        }
        return array_slice($this->_collection, $this->_offset, $this->_limit);
    }

    public function getSize()
    {
        return count($this->getCollection());
    }

    public function limit($value)
    {
        $this->_limit = $value;
    }

    public function offset($value)
    {
        $this->_offset = $value;
    }

    public function sort($field)
    {
        $this->_sortField = $field;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        $delta = $this-> _deltaForPosition();
        return $this->_collection[$this->_position + $delta];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->_position++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        $delta = $this-> _deltaForPosition();
        return $this->_position + $delta < $this->_limit ?
            isset($this->_collection[$this->_position + $delta]) : false;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->_position = $this-> _deltaForPosition();
    }

    private function _deltaForPosition()
    {
        return $this->_offset >= 0 ? $this->_offset : count($this->_collection) + $this->_offset;
    }
}
