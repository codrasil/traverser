<?php

namespace Codrasil\Tree;

use Codrasil\Tree\Branch;

class Tree
{
    use Traits\Closurable,
        Traits\LineageTracing;

    /**
     * Check if the build method was run.
     *
     * @var boolean
     */
    protected $built = false;

    /**
     * Array of node items.
     *
     * @var array
     */
    protected $nodes = [];

    /**
     * The node attributes.
     *
     * @var array
     */
    protected $options = [
        'key' => 'key',
        'parent' => 'parent',
        'left' => 'left',
        'right' => 'right',
        'children' => 'children',
        'has_children' => 'has_children',
        'order' => 'order',
    ];

    /**
     * The Root parent of all nodes.
     *
     * @var array
     */
    protected $root = [];

    /**
     * The flatten array of nodes.
     *
     * @var array
     */
    protected $flattens = [];

    /**
     * Initialize with the given items array as
     * the items to build.
     * The options array will modify the keys for the items.
     *
     * @param array $nodes
     * @param array $options
     * @param array $root
     */
    public function __construct(array $nodes = [], $options = [], $root = null)
    {
        $this->options(array_merge($this->options, $options));

        $this->root = $root ?? $this->root();

        $this->nodes = array_merge($this->root, $nodes);

        $this->originalNodes = $nodes;

        $this->build();
    }

    /**
     * Sorts the node tree, adding parent-child relationship
     * to the nodes array.
     *
     * @param  array  $nodes
     * @param  string $parent
     */
    public function build($parent = 'root', $nodes = null)
    {
        if ($this->hasBuilt()) {
            return $this;
        }

        /**
         * Make all children key top-level.
         *
         */
        $this->flatten();

        $this->order();

        /**
         * Add left and right closure values.
         * This will enable us to easily retrieve
         * relationships between nodes such as
         * siblings, children, parents,
         * ancestors, and descendants.
         */
        $this->traverse();

        $this->prepare();

        $nodes = $nodes ?? $this->nodes(); // flatten nodes
        $options = $this->options();
        $this->unsettables = [];

        $items = [];

        foreach ($nodes as $name => &$node) {
            if ($node->hasParent()) {
                $parent = $this->find($node->parent());
                $parent->addChild([$node->key() => $node]);

                if ($node->parent() != 'root') {
                    $this->unsettables[] = $name;
                }
            }
        }

        $this->set($nodes);

        $this->prune();

        $this->setAsBuilt();

        return $this;
    }

    /**
     * Flatten the array. Move all `children` to top level.
     *
     * @param string $key
     * @param array|null $nodes
     * @param integer $left
     * @return self
     */
    protected function flatten($key = null, $nodes = null)
    {
        $key = $key ?? $this->options('children');
        $nodes = $nodes ?? $this->nodes();

        foreach ($nodes as $parent => &$node) {
            if (isset($node[$key]) && $children = $node[$key]) {
                foreach ($children as &$child) {
                    $child['parent'] = $parent;
                    $child['order'] = $child['order'] ?? 0;
                    if (isset($child[$key])) {
                        $this->flatten($key, $child[$key]);
                    }
                }
                $nodes = array_merge($nodes, $children);
                unset($nodes[$parent][$key]);
            }
        }

        $this->set($nodes);

        $this->flattens = $nodes;

        return $this;
    }

    /**
     * Retrieve the flat
     * \Codrasil\Tree\Branch array.
     *
     * @param string $root
     * @return array
     */
    public function flat($key = null, $nodes = null)
    {
        $key = $key ?? $this->options('children');
        $nodes = $nodes ?? $this->nodes();
        $items = [];

        foreach ($nodes as $parent => $node) {
            if ($node->hasChild() && $children = $node->children()) {
                foreach ($children as $child) {
                    $child->set('parent', $parent);
                    if ($child->hasChild()) {
                        $items = $this->flatten($key, $child->children());
                    }
                }
                $items = array_merge($items, $children);
                unset($nodes[$parent][$key]);
            }
        }

        return $items;
    }

    /**
     * Sort the nodes via the order key.
     *
     * @param array/object $nodes
     * @return void
     */
    protected function order($nodes = null)
    {
        $nodes = (array) ($nodes ?? $this->nodes());

        uasort($nodes, function ($item1, $item2) {
            $item1 = (array) $item1;
            $item2 = (array) $item2;

            if (isset($item1[$this->options('order')]) && isset($item2[$this->options('order')])) {
                return $item1[$this->options('order')] <=> $item2[$this->options('order')];
            }

            return -1;
        });

        $this->set($nodes);
    }

    /**
     * Initialize each item as a Branch.
     *
     * @param array  $nodes
     * @return void
     */
    protected function prepare(&$nodes = null)
    {
        $this->set(
            array_map(function ($node) {
                return $this->branch($node);
            }, $nodes ?? $this->nodes())
        );

        return $this;
    }

    /**
     * Shake the array tree off of excess array.
     *
     * @return void
     */
    protected function prune()
    {
        $nodes = array_filter($this->nodes(), function ($node) {
            return ! in_array($node->key(), $this->unsettables);
        });

        $this->set($nodes);
    }

    /**
     * Get a node via name.
     *
     * @param  string $name
     * @return mixed
     */
    public function find($name, $nodes = null)
    {
        foreach ($nodes ?? $this->nodes() as $keyname => &$node) {
            if ($keyname === $name) {
                return $node;
            }

            if ($node->hasChild()) {
                $next = $this->find($name, $node->children());
                if ($next) {
                    return $next;
                }
            }
        }

        foreach ($this->flattens as $keyname => &$node) {
            if ($keyname === $name) {
                if (is_array($node)) {
                    return $this->branch($node);
                }
                return $node;
            }
        }

        return null;
    }

    /**
     * Retrieve the nodes array.
     *
     * @return array
     */
    public function nodes()
    {
        return $this->nodes;
    }

    /**
     * Retrieve or set the options array.
     *
     *
     * @param string $key
     * @return array
     */
    public function options($key = null)
    {
        if (is_array($key)) {
            return $this->options = $key;
        }

        if (! is_null($key)) {
            return $this->options[$key];
        }

        return $this->options;
    }

    /**
     * Sets the nodes.
     *
     * @param array $nodes
     */
    protected function set($nodes)
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * Retrieve the nodes instance without the root.
     * See method all to retrieve with root.
     *
     * @return self
     */
    public function get()
    {
        if (! $this->hasBuilt()) {
            $this->build();
        }

        return $this->find('root')->children();
    }

    /**
     * Retrieve a new \Codrasil\Tree\Branch instance
     *
     * @param array $node
     * @return \Codrasil\Tree\Branch
     */
    protected function branch($node)
    {
        if (! is_array($node)) {
            return;
        }

        $key = $node[$this->options('key')];
        $parent = $node[$this->options('key')] == 'root'
            ? null
            : ($node[$this->options('parent')] ?? 'root');

        return new Branch(
            $key,
            $node,
            $parent,
            $this->options()
        );
    }

    /**
     * Retrieve all nodes starting from root.
     *
     * @return self
     */
    public function all()
    {
        return $this->nodes();
    }

    /**
     * Reset and build the node array again.
     *
     * @return void
     */
    public function rebuild()
    {
        $this->built = false;
        $this->nodes = $this->originalNodes ?? [];
        $this->build();
    }

    /**
     * Flag that the build method was run.
     *
     */
    protected function setAsBuilt()
    {
        $this->built = true;
    }

    /**
     * Check if the build method was run.
     *
     * @return boolean
     */
    protected function hasBuilt()
    {
        return $this->built;
    }

    /**
     * Retrieve the root node.
     *
     * @return array
     */
    protected function root()
    {
        return ['root' => [
            $this->options('key') => 'root',
            $this->options('parent') => null,
            $this->options('left') => '0',
            $this->options('right') => '0',
            $this->options('children') => [],
            $this->options('order') => 0,
        ]];
    }
}
