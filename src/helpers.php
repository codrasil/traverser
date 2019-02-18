<?php

use Codrasil\Tree\Tree;

if (! function_exists('tree')) {
    /**
     * Initialise a Codrasil\Tree\Tree instance
     * via given nodes.
     *
     * @param array $nodes
     * @param array $options
     * @return \Codrasil\Tree\Tree
     */
    function tree($nodes = [], $options = [])
    {
        return new Tree($nodes, $options);
    }
}
