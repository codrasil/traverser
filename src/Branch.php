<?php

namespace Codrasil\Tree;

class Branch
{
    /**
     * The unique identifier for the branch.
     *
     * @var int
     */
    protected $key;

    /**
     * The node instance of the branch.
     *
     * @var int
     */
    protected $node;

    /**
     * The parent key for the branch.
     *
     * @var string
     */
    protected $parent;

    /**
     * Constructor.
     *
     * @param mixed    $key
     * @param array    $node
     * @param string   $parent
     * @param array $options
     */
    public function __construct($key, $node, $parent = 'root', $options = [])
    {
        $this->node = $node;
        $this->options = $options;
        $this->key = $key;
        $this->parent = $parent;

        $this->build();
    }

    /**
     * Merge the arrays for a uniform key-value across all branch nodes.
     *
     * @return void
     */
    protected function build()
    {
        $this->node = array_merge([
            $this->options['key'] => $this->key(),
            $this->options['parent'] => $this->parent(),
            $this->options['order'] => $this->order(),
            $this->options['children'] => $this->children(),
        ], $this->node);
    }

    /**
     * Retrieve the parent name.
     *
     * @return string
     */
    public function parent()
    {
        return $this->parent;
    }

    /**
     * Retrieve the branch key.
     *
     * @return string
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Retrieve the children array.
     *
     * @return array
     */
    public function children()
    {
        return $this->node($this->options['children']) ?? [];
    }

    /**
     * Retrieve the order value.
     *
     * @return array
     */
    public function order()
    {
        return $this->node($this->options['order']) ?? 0;
    }

    /**
     * The left key value.
     *
     * @return int
     */
    public function left()
    {
        return $this->node($this->options['left']);
    }

    /**
     * The right key value.
     *
     * @return int
     */
    public function right()
    {
        return $this->node($this->options['right']);
    }

    /**
     * Retrieve the branch node.
     *
     * @param string $key
     * @return string
     */
    public function node($key = null)
    {
        if (! is_null($key)) {
            return $this->node[$key] ?? null;
        }

        return $this->node;
    }

    /**
     * Setter for node array.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->node[$key] = $value;
    }

    /**
     * Add the value to a given key.
     *
     * @param string $key
     * @param mixed $value
     */
    public function push($key, $value)
    {
        $this->node[$key] = array_merge($this->node[$key], $value);
    }

    /**
     * Add the value to the children key.
     *
     * @param mixed $value
     */
    public function addChild(array $value)
    {
        $this->node[$this->options['children']] += (array) $value;
    }

    /**
     * Identify if node is a parent.
     *
     * @return boolean
     */
    public function hasChild()
    {
        return count($this->children()) >= 1;
    }

    /**
     * Check if parent key is not null.
     *
     * @return boolean
     */
    public function hasParent()
    {
        return ! is_null($this->parent());
    }

    /**
     * Alias for hasChild.
     *
     * @return boolean
     */
    public function isParent()
    {
        return $this->hasChild();
    }

    /**
     * Magic method will return the keys from
     * the node array.
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->node($name);
    }

    public function __set($name, $value)
    {
        $this->node[$name] = $value;
    }

    public function __isset($name)
    {
        return is_null($this->node($name));
    }
}
