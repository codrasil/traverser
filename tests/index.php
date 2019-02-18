<?php

include __DIR__.'/../vendor/autoload.php';
include __DIR__.'/../src/Tree.php';
include __DIR__.'/../src/Branch.php';

use Codrasil\Tree\Tree;

$provider = require __DIR__.'/factories/menus.php';

$menus = new Tree($provider, ['key' => 'name']);

echo "<style>body{background:#eee;font-family:'Fira Mono','Ubuntu Mono',monospace;}</style>";

echo "<h2>Codrasil\Tree\Tree Demo</h2>";

echo "<pre>";
    echo '-------------------------------------------'.'<br>';
    echo 'Displaying Closure Keys Left + Right Values'.'<br>';
    echo '-------------------------------------------'.'<br>';
    foreach ($menus->all() as $menu) {
        echo "-- [".str_pad($menu->left, 2, '0', STR_PAD_LEFT)."] {$menu->key()} [".str_pad($menu->right, 2, '0', STR_PAD_LEFT)."]" . '<br>';
        foreach ($menu->children() as $submenu) {
            echo "---- [".str_pad($submenu->left, 2, '0', STR_PAD_LEFT)."] {$submenu->key()} [".str_pad($submenu->right, 2, '0', STR_PAD_LEFT)."]" . '<br>';
            foreach ($submenu->children() as $grandmenu) {
                echo "------ [".str_pad($grandmenu->left, 2, '0', STR_PAD_LEFT)."] {$grandmenu->key()} [".str_pad($grandmenu->right, 2, '0', STR_PAD_LEFT)."]" . '<br>';
                foreach ($grandmenu->children() as $deepmenu) {
                    echo "-------- [".str_pad($deepmenu->left, 2, '0', STR_PAD_LEFT)."] {$deepmenu->key()} [".str_pad($deepmenu->right, 2, '0', STR_PAD_LEFT)."]" . '<br>';
                }
            }
        }
    }
echo "</pre>";
echo "<br>";
echo "<br>";
echo "<pre>";
    echo '-------------------------------------------'.'<br>';
    echo 'Using the helper function tree()'.'<br>';
    echo '-------------------------------------------'.'<br>';
echo "</pre>";
echo "<pre>";

?><code style="display:inline-block;padding:.5rem;background-color: #e2e2e2">foreach (tree($menus, $options)->get() as $subtree) {
    echo $subtree->key();
}
</code><?php

echo "</pre>";
foreach (tree($provider, ['key' => 'name'])->get() as $subtree) {
    echo "{$subtree->key()}" . '<br>';
}
