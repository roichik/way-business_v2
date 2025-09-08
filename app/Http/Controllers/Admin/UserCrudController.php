<?php

namespace App\Http\Controllers\Admin;

use App\Dictionaries\User\GenderDictionary;
use App\Http\Requests\Admin\User\UserCreateRequest;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use App\Models\User\User;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\RedirectResponse;

/**
 * Class UserCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends BaseCrudController
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
        CRUD::setModel(\App\Models\User\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/users');
        CRUD::setEntityNameStrings('Пользователь', 'Пользователи');
        Widget::add()->type('script')->content('/js/admin/access-group.js');
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();

        CRUD::column('id')->label('ID');
        CRUD::column('nickname')->type('text')->label('Пользователь');
        CRUD::column('email')->type('text')->label('Email');
        CRUD::column('userDetail.last_name')->type('text')->label('Фамилия');
        CRUD::column('userDetail.first_name')->type('text')->label('Имя');
        CRUD::column('userDetail.father_name')->type('text')->label('Отчество');
        CRUD::column('is_enabled')->type('boolean')->label('Enabled');
        CRUD::column('created_at')->label('Дата создания');
    }

    /**
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column('id')->label('ID');
        CRUD::column('nickname')->type('text')->label('Пользователь');
        CRUD::column('email')->type('text')->label('Email');
        CRUD::column('email_verified_at')->type('text')->label('Дата верификации Email');
        CRUD::column('phone')->type('text')->label('Телефон');
        CRUD::column('phone_verified_at')->type('text')->label('Дата верификации телефона');
        CRUD::column('userDetail.last_name')->type('text')->label('Фамилия');
        CRUD::column('userDetail.first_name')->type('text')->label('Имя');
        CRUD::column('userDetail.father_name')->type('text')->label('Отчество');
        CRUD::column('userDetail.gender')
            ->type('select_from_array')
            ->label('Пол')
            ->options(GenderDictionary::getTitleCollection());
        CRUD::column('is_enabled')->type('boolean')->label('Активный');
        CRUD::column('userDetail.birthday_at')->type('date')->label('День рождения');
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата обновления');
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserCreateRequest::class);

        CRUD::field('nickname')->type('text')->label('Пользователь')->tab('Общие сведенья');
        CRUD::field('email')->type('text')->label('Email')->attributes(['autocomplete' => 'off'])->tab('Общие сведенья');
        CRUD::field('password')->label('Пароль')->value('')->attributes(['autocomplete' => 'off'])->tab('Общие сведенья');
        CRUD::field('email_verified_at')->type('datetime')->label('Дата верификации Email')->tab('Общие сведенья');
        CRUD::field('phone')->type('text')->label('Телефон')->tab('Общие сведенья');
        CRUD::field('phone_verified_at')->type('datetime')->label('Дата верификации телефона')->tab('Общие сведенья');
        CRUD::field('userDetail.last_name')->label('Фамилия')->tab('Общие сведенья');
        CRUD::field('userDetail.first_name')->label('Имя')->tab('Общие сведенья');
        CRUD::field('userDetail.father_name')->label('Отчество')->tab('Общие сведенья');
        CRUD::field('userDetail.gender')
            ->type('select_from_array')
            ->label('Пол')
            ->options(GenderDictionary::getTitleCollection())
            ->tab('Общие сведенья');
        CRUD::field('is_enabled')->type('boolean')->label('Активный')->tab('Общие сведенья');
        CRUD::field('userDetail.birthday_at')->type('date')->label('День рождения')->tab('Общие сведенья');
        CRUD::field('created_at')->attributes(['disabled' => 'disabled'])->label('Дата создания')->tab('Общие сведенья');
        CRUD::field('updated_at')->attributes(['disabled' => 'disabled'])->label('Дата обновления')->tab('Общие сведенья');
/*
        CRUD::field([
            'label'             => 'Группы доступа',
            'field_unique_name' => 'role_permission',
            'type'              => 'checklist_dependency',
            'name'              => 'roles,permissions',
            'tab'               => 'Права доступа',
            'subfields'         => [
                'primary'   => [
                    'label'            => 'Роли',
                    'name'             => 'userAccess.roles',
                    'entity'           => 'roles',
                    'entity_secondary' => 'permissions',
                    'attribute'        => 'name',
                    'model'            => Role::class,
                    'pivot'            => true,
                    'number_columns'   => 3,
                ],
                'secondary' => [
                    'label'          => 'Права доступа',
                    'name'           => 'userAccess.permissions',
                    'entity'         => 'permissions',
                    'entity_primary' => 'roles',
                    'attribute'      => 'name',
                    'model'          => Permission::class,
                    'pivot'          => true,
                    'number_columns' => 3,
                ],
            ],
        ]);
*/
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::field('nickname')->type('text')->label('Пользователь')->attributes(['disabled' => 'disabled'])->tab('Общие сведенья');
        CRUD::field('email')->type('text')->label('Email')->attributes(['autocomplete' => 'off', 'disabled' => 'disabled'])->tab('Общие сведенья');
        CRUD::field('password')->label('Пароль')->value('')->attributes(['autocomplete' => 'off'])->tab('Общие сведенья');
        CRUD::field('email_verified_at')->type('datetime')->label('Дата верификации Email')->tab('Общие сведенья');
        CRUD::field('phone')->type('text')->label('Телефон')->tab('Общие сведенья');
        CRUD::field('phone_verified_at')->type('datetime')->label('Дата верификации телефона')->tab('Общие сведенья');
        CRUD::field('userDetail.last_name')->label('Фамилия')->tab('Общие сведенья');
        CRUD::field('userDetail.first_name')->label('Имя')->tab('Общие сведенья');
        CRUD::field('userDetail.father_name')->label('Отчество')->tab('Общие сведенья');
        CRUD::field('userDetail.gender')
            ->type('select_from_array')
            ->label('Пол')
            ->options(GenderDictionary::getTitleCollection())
            ->tab('Общие сведенья');
        CRUD::field('is_enabled')->type('boolean')->label('Активный')->tab('Общие сведенья');
        CRUD::field('userDetail.birthday_at')->type('date')->label('День рождения')->tab('Общие сведенья');
        CRUD::field('created_at')->attributes(['disabled' => 'disabled'])->label('Дата создания')->tab('Общие сведенья');
        CRUD::field('updated_at')->attributes(['disabled' => 'disabled'])->label('Дата обновления')->tab('Общие сведенья');


        CRUD::field([
            'label'             => 'Группы доступа',
            'field_unique_name' => 'role_permission',
            'type'              => 'checklist_dependency',
            'name'              => 'roles,permissions',
            'tab'               => 'Права доступа',
            'subfields'         => [
                'primary'   => [
                    'label'            => 'Роли',
                    'name'             => 'userAccess.roles',
                    'entity'           => 'roles',
                    'entity_secondary' => 'permissions',
                    'attribute'        => 'name',
                    'model'            => Role::class,
                    'pivot'            => true,
                    'number_columns'   => 3,
                ],
                'secondary' => [
                    'label'          => 'Права доступа',
                    'name'           => 'userAccess.permissions',
                    'entity'         => 'permissions',
                    'entity_primary' => 'roles',
                    'attribute'      => 'name',
                    'model'          => Permission::class,
                    'pivot'          => true,
                    'number_columns' => 3,
                ],
            ],
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function store()
    {
        $password = $this->crud->getRequest()->request->get('password');
        if ($password === null || $password === '') {
            $this->crud->getRequest()->request->remove('password');
        }

        $response = $this->traitStore();

        return $response;
    }

    /**
     * @return RedirectResponse
     */
    public function update()
    {
        $all = $this->crud->getRequest()->request->all();
        /** @var User $user */
        $user = User::find($this->crud->getCurrentEntryId());
        if(!$user->userAccess){
            $user->userAccess()->create();
        }

        $password = $this->crud->getRequest()->request->get('password');
        if ($password === null || $password === '') {
            $this->crud->getRequest()->request->remove('password');
        }

        $response = $this->traitUpdate();

        return $response;
    }
}
