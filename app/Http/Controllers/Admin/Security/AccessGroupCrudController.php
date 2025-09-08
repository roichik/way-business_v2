<?php

namespace App\Http\Controllers\Admin\Security;

use App\Http\Controllers\Admin\BaseCrudController;
use App\Models\Security\AccessGroup;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AccessGroupCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AccessGroupCrudController extends BaseCrudController
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
        CRUD::setModel(AccessGroup::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/access-group');
        CRUD::setEntityNameStrings('Группа доступа', 'Группы доступа');
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();

        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');
        CRUD::column('flags')->label('Дополнительные параметры');
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата редактирование');
    }

    /**
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');
        CRUD::column('flags')->label('Дополнительные параметры');
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата редактирование');
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        //CRUD::setValidation(RoleCreateRequest::class);
        CRUD::field('title')->type('text')->label('Название');
        CRUD::field('description')->type('text')->label('Описание');

        /**
        CRUD::field([   // two interconnected entities
            'label'             => 'Роли и права доступа',
            'field_unique_name' => 'role_permission',
            'type'              => 'checklist_dependency',
            'name'              => 'roles,permissions', // the methods that define the relationship in your Models
            'subfields'         => [
                'primary' => [
                    'label'            => 'Роли',
                    'name'             => 'roles', // the method that defines the relationship in your Model
                    'entity'           => 'roles', // the method that defines the relationship in your Model
                    'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                    'attribute'        => 'name', // foreign key attribute that is shown to user
                    'model'            => Role::class,
                    'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                    'number_columns'   => 3, //can be 1,2,3,4,6

                ],
                'secondary' => [
                    'label'          => 'Права доступа',
                    'name'           => 'permissions', // the method that defines the relationship in your Model
                    'entity'         => 'permissions', // the method that defines the relationship in your Model
                    'entity_primary' => 'roles', // the method that defines the relationship in your Model
                    'attribute'      => 'name', // foreign key attribute that is shown to user
                    'model'          => Permission::class,
                    'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                    'number_columns' => 3, //can be 1,2,3,4,6

                ],
            ],
        ]);
         */
        /*
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
        */
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
