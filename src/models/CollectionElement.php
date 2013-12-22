<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 01.11.13
 * Time: 16:55
 */
namespace App\Model;

class CollectionElement
    implements \ArrayAccess
{
    protected $_data = array();
    protected $_resource;

    public function __construct(array $data = [], Resource\IResourceEntity $resource = null)
    {
        $this->_resource = $resource;
        $this->_data = $data;
    }

    public function getId()
    {
        return $this[$this->_resource->getPrimaryKeyField()];
    }


    public function setData($data)
    {
        $this->_data = $data;
    }

    public function load($id)
    {
        $this->_data = $this->_resource->find($id);
    }

    public function save()
    {
        $id = $this->_resource->save($this->_data);
        $this->_data[$this->_resource->getPrimaryKeyField()] = $id;
    }

    public function remove()
    {
        $this->_resource->remove($this->getId());
    }


    private function _getData($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return (bool)$this->_getData($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->_getData($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @throws Exception
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        throw new \Exception('Property is read only');
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @throws Exception
     * @return void
     */
    public function offsetUnset($offset)
    {
        throw new \Exception('Property is read only');
    }
}