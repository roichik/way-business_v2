<?php

namespace App\Http\Controllers\Admin\Security;

use App\Http\Controllers\Admin\BaseCrudController;
use App\Http\Requests\Admin\User\RoleCreateRequest;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RoleCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RoleCrudController extends BaseCrudController
{
    use ListOperation;
    use DeleteOperation;
    use ShowOperation;
    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }

    /**
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Security\Role::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/roles');
        CRUD::setEntityNameStrings('Роль', 'Роли');
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();

        CRUD::column('id')->label('ID');
        CRUD::column('name')->type('text')->label('Название');
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
        CRUD::column('description')->type('text')->label('Описание');
        CRUD::addColumn([
            'label'      => 'Права доступа',
            'type'       => 'select_multiple',
            'name'       => 'permissions',
            'model'      => Permission::class,
            'attribute'  => 'concatGroupAndNameLabels',
            'options'    => (function ($query) {
                return $query
                    ->orderBy('group', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->get();
            }),
            'attributes' => [
                'size' => 15,
            ],
        ]);
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата редактирование');
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RoleCreateRequest::class);
        CRUD::field('name')->type('text')->label('Название');
        CRUD::field('description')->type('text')->label('Описание');
        CRUD::addField([
            'label'      => 'Права доступа',
            'type'       => 'select_multiple',
            'name'       => 'permissions',
            'entity'     => 'permissions',
            'model'      => Permission::class,
            'attribute'  => 'concatGroupAndNameLabels',
            'options'    => (function ($query) {
                return $query
                    ->orderBy('group', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->get();
            }),
            'attributes' => [
                'size' => 15,
            ],
        ]);
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
