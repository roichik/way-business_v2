<?php

namespace App\Http\Controllers\Admin;

use App\Services\Security\Dictionaries\PermissionDictionary;
use Backpack\CRUD\app\Exceptions\AccessDeniedException;

class AdminController extends \Backpack\CRUD\app\Http\Controllers\AdminController
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title

        return view('vendor.backpack.base.dashboard', $this->data);
    }
}
