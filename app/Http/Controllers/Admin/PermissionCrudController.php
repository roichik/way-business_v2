<?php

namespace App\Http\Controllers\Admin;

use App\Dictionaries\User\GenderDictionary;
use App\Dictionaries\UserRoleDictionary;
use App\Helpers\CryptoHelper;
use App\Http\Requests\Admin\User\UserCreateRequest;
use App\Http\Requests\UserRequest;
use App\Models\Permission;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\RedirectResponse;
use Jenssegers\Agent\Agent;

/**
 * Class PermissionCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PermissionCrudController extends BaseCrudController
{
    use ListOperation;
    use ShowOperation;

    /**
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Permission::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/permissions');
        CRUD::setEntityNameStrings('Право доступа', 'Права доступа');
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();

        CRUD::column('id')->label('ID');
        CRUD::column('name')->type('text')->label('Название');
        CRUD::column('groupLabel')->type('text')->label('Группа');
        CRUD::column('description')->type('text')->label('Описание');
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата редактирование');
    }

     /**
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column('id')->label('ID');
        CRUD::column('name')->type('text')->label('Название');
        CRUD::column('groupLabel')->type('text')->label('Группа');
        CRUD::column('description')->type('text')->label('Описание');
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата редактирование');
    }
}
