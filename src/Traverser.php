<?php

namespace Codrasil\Traverser;

/**
*  Traverser Class
*
*  Generate an adjacent list from array.
*
*  @author John Lioneil Dionisio <john.dionisio1@gmail.com>
*/
class Traverser
{
    /**
     * The items array to iterate.
     *
     * @var array
     */
    protected $items = [];

    /**
     * The options array to configure the traverser.
     *
     * @var array
     */
    protected $options = [
        'id' => 'id',
        'parent' => 'parent',
        'children' => 'children',
        'siblings' => 'siblings',
        'left' => 'left',
        'right' => 'right',
    ];

    /**
     * The Root parent of all traversables.
     *
     * @var array
     */
    protected $root = [
        'root' => [
            'name' => 'root',
            'parent' => false,
            'left' => '0',
            'right' => '0',
        ],
    ];

    /**
     * Check if the build method was run.
     *
     * @var boolean
     */
    protected $built = false;

    /**
     * Set the items to the items property.
     *
     * @param array $items
     * @param array $options
     */
    public function __construct(array $items, array $options = [])
    {
        $this->items = $items;
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Retrieve the items array.
     *
     * @return array
     */
    public function items()
    {
        return $this->items;
    }

    /**
     * Retrieve the options array.
     *
     *
     * @param string $key
     * @return array
     */
    public function options($key = null)
    {
        if (! is_null($key)) {
            return $this->options[$key];
        }

        return $this->options;
    }

    /**
     * Build the adjacent list using the options array.
     *
     * @return array
     */
    public function build()
    {
        $this->set(
            $this->prepare(
                $this->items()
            )
        );

        $this->built = true;
    }

    /**
     * Set items array.
     *
     * @param array $items
     */
    public function set($items)
    {
        $this->items = $items;
    }

    /**
     * Retrieve the generated items array.
     *
     * @return array
     */
    public function get()
    {
        if (! $this->built) {
            $this->build();
        }

        return $this->root();
    }

    /**
     * Add child to the specified key.
     *
     * @param array $items
     * @param string $key
     * @return void
     */
    public function child($items, $key = 'items')
    {
        $this->{$key}[$this->options('children')] = $items;
    }

    /**
     * Add items as child of root.
     *
     * @param array $items
     * @param string $parent
     * @return array
     */
    protected function prepare($items, $parent = 'root')
    {
        foreach ($items as $item) {
            // $item = array_combine();
            if ($item[$this->options('parent')] === $parent) {
                $children = $this->prepare($item, $item[$this->options('name')]);
                $item['has_children'] = ! empty($children);
                if ($item['has_children']) {
                    $item[$this->options('children')] = $children;
                }
                $this->branch[] = $item;
            }
        }

        return $this->child($this->branch, 'root');
    }

    /**
     * Retrieve the root array.
     *
     * @return array
     */
    protected function root()
    {
        return $this->root;
    }
}
