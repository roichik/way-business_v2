<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class BaseCrudController
 */
class BaseCrudController extends CrudController
{
    protected function setupListOperation()
    {
        Widget::add()->type('script')-> stack('after_scripts')->content('/storage/js/backpack.js');
    }
}
