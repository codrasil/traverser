<?php

namespace Codrasil\Traverser\Test\Unit;

use Codrasil\Traverser\Test\TestCase;
use Codrasil\Traverser\Traverser;

/**
 * @package Tests\Unit
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class TraverserTest extends TestCase
{
    public function menus()
    {
        $path = realpath(__DIR__.'/../factories/menus.php');

        return [
            [file_exists($path) ? require $path : [], [], true]
        ];
    }

    /**
     * @test
     * @group  unit
     * @group  unit:traverser
     * @dataProvider  menus
     * @return void
     */
    public function it_accepts_arrays_of_items_upon_initialization($menus)
    {
        $traverser = new Traverser($menus);

        $this->assertInstanceof('\Codrasil\Traverser\Traverser', $traverser);
        $this->assertInternalType('array', $traverser->items());
    }

    /**
     * @test
     * @group  unit
     * @group  unit:traverser
     * @dataProvider  menus
     * @return void
     */
    public function it_accepts_arrays_of_options_upon_initialization($array)
    {
        // $traverser = new Traverser($array, $options);

        // $this->assertInstanceof('\Codrasil\Traverser\Traverser', $traverser);
        // $this->assertInternalType('array', $traverser->items());
    }

    /**
     * @test
     * @group  unit
     * @group  unit:traverser
     * @dataProvider  menus
     * @return void
     */
    public function it_builds_the_array_into_adjacent_list($array)
    {
        $traverser = new Traverser($array);
        $traverser->build();

        // $this->
    }
}
