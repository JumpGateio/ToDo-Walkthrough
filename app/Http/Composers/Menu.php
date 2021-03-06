<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use JumpGate\Menu\DropDown;
use JumpGate\Menu\Link;

class Menu
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $this->generateLeftMenu();
        $this->generateRightMenu();
    }

    /**
     * Adds items to the menu that appears on the left side of the main menu.
     */
    private function generateLeftMenu()
    {
        $leftMenu = \Menu::getMenu('leftMenu');

        $leftMenu->link('docs', function (Link $link) {
            $link->name = 'Documentation';
            $link->url  = route('larecipe.index');
        });

        $leftMenu->dropDown('task-list', 'Lists', function (DropDown $dropDown) {
            $dropDown->link('task-list.index', function (Link $link) {
                $link->name = 'All Lists';
                $link->url  = route('task-list.index');
            });
            $dropDown->link('task-list.create', function (Link $link) {
                $link->name = 'Create List';
                $link->url  = route('task-list.create');
            });
        });
    }

    /**
     * Adds items to the menu that appears on the right side of the main menu.
     */
    private function generateRightMenu()
    {
        $rightMenu = \Menu::getMenu('rightMenu');

        if (auth()->guest()) {
            $rightMenu->link('login', function (Link $link) {
                $link->name = 'Login';
                $link->url  = route('auth.social.login', ['google']);
            });
        }

        if (auth()->check()) {
            $rightMenu->dropdown('user', auth()->user()->gravatar, function (DropDown $dropDown) {
                $dropDown->type  = 'auth';
                $dropDown->right = true;

                $dropDown->link('user_logout', function (Link $link) {
                    $link->name = 'Logout';
                    $link->url  = route('auth.logout');
                });
            });
        }
    }
}
