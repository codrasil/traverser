<?php

namespace Codrasil\Tree\Traits;

trait Closurable
{
    /**
     * Closure left key.
     *
     * @var integer
     */
    protected $left = 1;

    /**
     * Closure right key.
     *
     * @var integer
     */
    protected $right = 1;

    /**
     * Apply the closure keys, left + right.
     *
     * @param string $parent
     * @param integer $left
     * @return void
     */
    protected function traverse($parent = 'root', $left = 1)
    {
        $right = $left + 1;
        $options = $this->options();

        foreach ($this->nodes() as $name => &$node) {
            $node = (array) $node;

            if ('root' === $node[$options['key']]) {
                $node[$options['parent']] = null;
            }

            if (! isset($node[$options['parent']]) && 'root' !== $node[$options['key']]) {
                $node[$options['parent']] = 'root';
            }

            if ($parent === $node[$options['parent']]) {
                $right = $this->traverse($node[$options['key']], $right);
            }
        }

        $this->setClosureKeysToNodes($parent, $left, $right);

        return $right + 1;
    }

    /**
     * Set the left and right closure key values.
     *
     * @param string $parent
     * @param int $left
     * @param int $right
     */
    protected function setClosureKeysToNodes($parent, $left, $right)
    {
        $nodes = $this->nodes();
        $options = $this->options();

        foreach ($nodes as $key => &$node) {
            if ($parent === $node[$options['key']]) {
                $node[$options['left']] = $left;
                $node[$options['right']] = $right;
            }

            if (isset($node[$options['right']])) {
                if (($descendants = ($node[$options['right']] - $node[$options['left']] - 1) / 2) > 0) {
                    $node[$options['has_children']] = $descendants;
                }
            }
        }

        $this->set($nodes);
    }
}
