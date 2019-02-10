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
    /**
     * @group  unit
     * @group  unit:traverser
     * @dataProvider  menusProvider
     * @return void
     */
    public function testItAcceptsArraysOfItemsUponInitialization($menus)
    {
        $traverser = new Traverser($menus);

        $this->assertInstanceof('\Codrasil\Traverser\Traverser', $traverser);
        $this->assertInternalType('array', $traverser->items());
    }

    /**
     * @group  unit
     * @group  unit:traverser
     * @depends testItAcceptsArraysOfItemsUponInitialization
     * @dataProvider  menusWithOptionsProvider
     * @return void
     */
    public function testItAcceptsArraysOfOptionsUponInitialization($provider)
    {
        $traverser = new Traverser($provider['menus'], $provider['options']);

        $this->assertInstanceof('\Codrasil\Traverser\Traverser', $traverser);
        $this->assertInternalType('array', $traverser->options());
        $this->assertEquals($provider['options']['id'], $traverser->options('id'));
        $this->assertEquals($traverser->options('siblings'), 'siblings');
    }

    /**
     * @group  unit
     * @group  unit:traverser
     * @dataProvider  menusWithOptionsProvider
     * @return void
     */
    public function testItBuildsTheArrayIntoAdjacentList($provider)
    {
        $traverser = new Traverser($provider['menus']);
        $traverser->build();

        $this->assertInternalType('array', $traverser->get());
        $this->assertTrue(in_array($provider['menus'], $traverser->get()));
    }

    public function menusProvider()
    {
        $path = realpath(__DIR__.'/../factories/menus.php');

        return [
            ['menus' => file_exists($path) ? require $path : []],
        ];
    }

    public function menusWithOptionsProvider()
    {
        $path = realpath(__DIR__.'/../factories/menus.php');

        return [
            [[
                'menus' => file_exists($path) ? require $path : [],
                'options' => [
                    'id' => 'name',
                    'parent' => 'parent',
                    'children' => 'children',
                ],
            ]],
        ];
    }
}
