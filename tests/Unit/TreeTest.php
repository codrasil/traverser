<?php

namespace Codrasil\Tree\Test\Unit;

use Codrasil\Tree\Test\TestCase;
use Codrasil\Tree\Tree;

/**
 * @package Tests\Unit
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class TreeTest extends TestCase
{
    /**
     * @group  unit
     * @group  unit:tree
     * @dataProvider  menusProvider
     * @return void
     */
    public function testItAcceptsArraysOfItemsUponInitialization($provider)
    {
        $tree = new Tree($provider);

        $this->assertInstanceof('\Codrasil\Tree\Tree', $tree);
        $this->assertInternalType('array', $tree->get());
        $this->assertFalse(array_key_exists('root', $tree->get()));
        $this->assertTrue(array_key_exists('root', $tree->all()));
    }

    /**
     * @group  unit
     * @group  unit:tree
     * @depends testItAcceptsArraysOfItemsUponInitialization
     * @dataProvider  menusWithOptionsProvider
     * @return void
     */
    public function testItAcceptsArraysOfOptionsUponInitialization($provider)
    {
        $tree = new Tree($provider['menus'], $provider['options']);

        $this->assertInstanceof('\Codrasil\Tree\Tree', $tree);
        $this->assertInternalType('array', $tree->options());
        $this->assertEquals($provider['options']['key'], $tree->options('key'));
        $this->assertEquals($provider['options']['children'], $tree->options('children'));
        $this->assertEquals($tree->options('key'), $provider['options']['key']);
        $this->assertEquals($tree->options('children'), $provider['options']['children']);
    }

    /**
     * @group  unit
     * @group  unit:tree
     * @dataProvider  menusWithOptionsProvider
     * @return void
     */
    public function testItBuildsTheArrayIntoAdjacentList($provider)
    {
        $menus = new Tree($provider['menus'], $provider['options']);
        $menus->build();

        $this->assertInternalType('array', $menus->get());
        $this->assertEquals($provider['menus']['module:user']['name'], $menus->find('module:user')->key());
        $this->assertEquals(2, $menus->find('module:dashboard')->left());
        $this->assertEquals(3, $menus->find('module:dashboard')->right());
    }

    /**
     * @group  unit
     * @group  unit:tree
     * @dataProvider  menusWithOptionsProvider
     * @return void
     */
    public function testItCanRetrieveAncestors($provider)
    {
        $menus = new Tree($provider['menus'], $provider['options']);
        $menus->build();

        $this->assertInternalType('array', $menus->ancestors('users.roles'));
        $this->assertEquals(2, count($menus->ancestors('users.roles')));
    }

    /**
     * @group  unit
     * @group  unit:tree
     * @dataProvider  menusWithOptionsProvider
     * @return void
     */
    public function testItCanRetrieveDescendants($provider)
    {
        $menus = new Tree($provider['menus'], $provider['options']);
        $menus->build();

        $this->assertInternalType('array', $menus->descendants('module:user'));
        $this->assertEquals(4, count($menus->descendants('module:user')));
    }

    /**
     * @group  unit
     * @group  unit:tree
     * @dataProvider  menusWithOptionsProvider
     * @return void
     */
    public function testItCanRetrieveParent($provider)
    {
        $menus = new Tree($provider['menus'], $provider['options']);
        $menus->build();

        $this->assertInstanceof('\Codrasil\Tree\Branch', $menus->parent('module:user'));
    }

    /**
     * @group  unit
     * @group  unit:tree
     * @dataProvider  menusWithOptionsProvider
     * @return void
     */
    public function testItCanRetrieveSiblings($provider)
    {
        $menus = new Tree($provider['menus'], $provider['options']);
        $menus->build();

        $this->assertInstanceof('\Codrasil\Tree\Branch', $menus->parent('module:user'));
    }

    public function menusProvider()
    {
        $path = realpath(__DIR__.'/../factories/menus.default.php');

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
                    'key' => 'name',
                    'parent' => 'parent',
                    'children' => 'children',
                ],
            ]],
        ];
    }
}
