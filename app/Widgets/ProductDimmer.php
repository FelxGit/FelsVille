<?php

namespace App\Widgets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use App\Product;
use Arrilot\Widgets\AbstractWidget;

class ProductDimmer extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Product::count();
        $string = 'Products';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-bag',
            'title'  => "{$count} {$string}",
            'text'   => __('voyager::dimmer.product_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('voyager::dimmer.product_link_text'),
                'link' => redirect('/'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/02.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     * https://voyager-docs.devdojo.com/v/1.1/core-concepts/roles-and-permissions
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        //base on dashboard permission
        // return Auth::user()->can('browse', new Product);

        //base on user role
        return auth()->user()->hasRole('admin');
    }
}
