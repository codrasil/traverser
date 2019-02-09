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
     * Set the items to the items property.
     *
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
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
}
