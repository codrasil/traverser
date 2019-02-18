<?php

namespace Codrasil\Tree\Traits;

trait LineageTracing
{
    /**
     * Retrieve the nodes ancestors.
     *
     * @param string $key
     * @param array  $nodes
     * @return array
     */
    public function ancestors($key, $nodes = null)
    {
        $node = $this->find($key);
        $options = $this->options();
        $tree = [];

        foreach ($nodes ?? $this->get() as $name => $ancestor) {
            if ($ancestor->left() < $node->left() && $ancestor->right() > $node->right()) {
                $tree[] = $ancestor;
            }

            if ($ancestor->hasChild()) {
                $next = $this->ancestors($key, $ancestor->children());
                $tree = array_merge($tree, $next);
            }
        }

        return $tree ?? [];
    }

    /**
     * Retrieve the nodes descendants.
     *
     * @param string $key
     * @param array  $nodes
     * @return array
     */
    public function descendants($key, $nodes = null)
    {
        $node = $this->find($key);
        $tree = [];

        foreach ($nodes ?? $this->get() as $name => $descendant) {
            if ($node->left() < $descendant->left() && $node->right() > $descendant->right()) {
                $tree[] = $descendant;
            }

            if ($descendant->hasChild()) {
                $next = $this->descendants($key, $descendant->children());
                $tree = array_merge($tree, $next);
            }
        }

        return $tree ?? [];
    }

    /**
     * Retrieve the parent of the node.
     * @param string $key
     * @return \Codrasil\Tree\Branch
     */
    public function parent($key)
    {
        $node = $this->find($key);
        $parent = $this->find($node->parent());

        return $parent;
    }

    /**
     * Retrieve the siblings of the given node.
     *
     * @param string $key
     * @return array
     */
    public function siblings($key)
    {
        $parent = $this->parent($key);

        return $parent->children();
    }
}
