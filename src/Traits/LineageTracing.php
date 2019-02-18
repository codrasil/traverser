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
     * @return array
     */
    public function descendants($key)
    {
        $node = $this->find($key);
        $options = $this->options();

        foreach ($this->flatten() as $name => $descendant) {
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

    public function parent($left, $right)
    {
        $ancestors = $this->ancestors($left, $right);

        return end($ancestors);
    }

    public function siblings($left, $right)
    {
        $parent = $this->parent($left, $right);

        return $parent['children'];
    }
}
