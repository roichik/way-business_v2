<?php

namespace App\Http\Controllers\Admin\Security;

use App\Dictionaries\Security\AccessGroupFlagDictionary;
use App\Http\Controllers\Admin\BaseCrudController;
use App\Http\Requests\Admin\Security\AccessGroupCreateRequest;
use App\Http\Requests\Admin\Security\AccessGroupUpdateRequest;
use App\Models\CompanyStructure\Company;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use App\Models\User\UserAdminAccessGroup;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Support\Facades\DB;
use App\Services\BackPackAdmin\BackPackAdminService;

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
        CRUD::setModel(UserAdminAccessGroup::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/access-group');
        CRUD::setEntityNameStrings('Группа доступа', 'Группы доступа');
        Widget::add()->type('script')->content('/js/admin/access-group.js');
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();

        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');
        CRUD::column([
            'label'             => 'Роли и права доступа',
            'field_unique_name' => 'role_permission',
            'type'              => 'checklist_dependency',
            'name'              => 'roles,permissions',
            'subfields'         => [
                'primary'   => [
                    'label'            => 'Роли',
                    'name'             => 'roles',
                    'entity'           => 'roles',
                    'entity_secondary' => 'permissions',
                    'attribute'        => 'name',
                    'model'            => Role::class,
                    'pivot'            => true,
                    'number_columns'   => 3,
                ],
                'secondary' => [
                    'label'          => 'Права доступа',
                    'name'           => 'permissions',
                    'entity'         => 'permissions',
                    'entity_primary' => 'roles',
                    'attribute'      => 'name',
                    'model'          => Permission::class,
                    'pivot'          => true,
                    'number_columns' => 3,
                ],
            ],
        ]);

        //Флаги
        CRUD::column([
            'label'    => 'Дополнительные параметры',
            'type'     => 'closure',
            'name'     => 'flags',
            'function' => function (UserAdminAccessGroup $entry) {
                $values = [];
                foreach ($entry->flags as $k => $b) {
                    foreach (AccessGroupFlagDictionary::getTitleCollection() as $key => $label) {
                        if ($key != $k || !$b) {
                            continue;
                        }
                        $values[] = $label;
                    }
                }

                return implode(', ', $values);
            }
        ]);

        //Компании
        CRUD::column([
            'label'           => 'Компании',
            'type'            => 'checklist',
            'name'            => 'companies',
            'entity'          => 'companies',
            'attribute'       => 'title',
            'model'           => Company::class,
            'pivot'           => true,
            'show_select_all' => true,
        ]);

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

        CRUD::column([
            'label'             => 'Роли и права доступа',
            'field_unique_name' => 'role_permission',
            'type'              => 'checklist_dependency',
            'name'              => 'roles,permissions',
            'subfields'         => [
                'primary'   => [
                    'label'            => 'Роли',
                    'name'             => 'roles',
                    'entity'           => 'roles',
                    'entity_secondary' => 'permissions',
                    'attribute'        => 'name',
                    'model'            => Role::class,
                    'pivot'            => true,
                    'number_columns'   => 3,
                ],
                'secondary' => [
                    'label'          => 'Права доступа',
                    'name'           => 'permissions',
                    'entity'         => 'permissions',
                    'entity_primary' => 'roles',
                    'attribute'      => 'name',
                    'model'          => Permission::class,
                    'pivot'          => true,
                    'number_columns' => 3,
                ],
            ],
        ]);

        //Флаги
        $flags = UserAdminAccessGroup::find($this->crud->getCurrentEntryId())->flags;
        foreach (AccessGroupFlagDictionary::getTitleCollection() as $key => $label) {
            CRUD::column([
                'label'    => $label,
                'type'     => 'checkbox',
                'name'     => $key,
                'value'    => array_key_exists($key, $flags) && (bool)$flags[$key],
                'fake'     => true,
                'store_in' => 'flags',
            ]);
        }

        //Компании
        CRUD::column([
            'label'           => 'Компании',
            'type'            => 'checklist',
            'name'            => 'companies',
            'entity'          => 'companies',
            'attribute'       => 'title',
            'model'           => Company::class,
            'pivot'           => true,
            'show_select_all' => true,
        ]);

        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата редактирование');
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AccessGroupCreateRequest::class);
        CRUD::field('title')->type('text')->label('Название');
        CRUD::field('description')->type('text')->label('Описание');
        CRUD::field([
            'label'             => 'Роли и права доступа',
            'field_unique_name' => 'role_permission',
            'type'              => 'checklist_dependency',
            'name'              => 'roles,permissions',
            'subfields'         => [
                'primary'   => [
                    'label'            => 'Роли',
                    'name'             => 'roles',
                    'entity'           => 'roles',
                    'entity_secondary' => 'permissions',
                    'attribute'        => 'name',
                    'model'            => Role::class,
                    'pivot'            => true,
                    'number_columns'   => 3,
                ],
                'secondary' => [
                    'label'          => 'Права доступа',
                    'name'           => 'permissions',
                    'entity'         => 'permissions',
                    'entity_primary' => 'roles',
                    'attribute'      => 'name',
                    'model'          => Permission::class,
                    'pivot'          => true,
                    'number_columns' => 3,
                ],
            ],
        ]);

        //Флаги
        foreach (AccessGroupFlagDictionary::getTitleCollection() as $id => $label) {
            $flagValue = AccessGroupFlagDictionary::getDefaultValueById($id);
            if ($this->crud->getCurrentEntryId()) {
                $flagValue = UserAdminAccessGroup::find($this->crud->getCurrentEntryId())
                    ->flagById(
                        $id,
                        AccessGroupFlagDictionary::getDefaultValueById($id)
                    );
            }

            CRUD::field([
                'label'    => $label,
                'type'     => 'checkbox',
                'name'     => $id,
                'default'  => $flagValue,
                'fake'     => true,
                'store_in' => 'flags',
            ]);
        }

        //Компании
        CRUD::field([
            'label'           => 'Компании',
            'type'            => 'checklist',
            'name'            => 'companies',
            'entity'          => 'companies',
            'attribute'       => 'title',
            'model'           => Company::class,
            'pivot'           => true,
            'show_select_all' => true,
            'number_columns'  => 2,
        ]);
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        CRUD::setValidation(AccessGroupUpdateRequest::class);
    }

    /**
     * @return RedirectResponse
     */
    public function update()
    {
        DB::beginTransaction();
        try {
            $response = $this->traitUpdate();
            foreach (UserAdminAccessGroup::find($this->crud->getCurrentEntryId())->users as $user) {
                /** @var BackPackAdminService $backPackService */
                $backPackService = resolve(BackPackAdminService::class);
                $backPackService
                    ->security()
                    ->syncAllPermissionsByUser(
                        $user
                    );
            }

        } catch (\Throwable $exception) {
            DB::rollback();
            throw $exception;
        }
        DB::commit();

        return $response;
    }
}
