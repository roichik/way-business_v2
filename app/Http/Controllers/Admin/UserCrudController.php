<?php

namespace App\Http\Controllers\Admin;

use App\Dictionaries\User\GenderDictionary;
use App\Dictionaries\UserRoleDictionary;
use App\Helpers\CryptoHelper;
use App\Http\Requests\Admin\User\UserCreateRequest;
use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\RedirectResponse;
use Jenssegers\Agent\Agent;

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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/users');
        CRUD::setEntityNameStrings('Пользователя', 'Пользователи');
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
        CRUD::field('nickname')->type('text')->label('Пользователь');
        CRUD::field('email')->type('text')->label('Email')->attributes(['autocomplete' => 'off']);
        CRUD::field('password')->label('Пароль')->value('')->attributes(['autocomplete' => 'off']);
        CRUD::field('email_verified_at')->type('datetime')->label('Дата верификации Email');
        CRUD::field('phone')->type('text')->label('Телефон');
        CRUD::field('phone_verified_at')->type('datetime')->label('Дата верификации телефона');
        CRUD::field('userDetail.last_name')->label('Фамилия');
        CRUD::field('userDetail.first_name')->label('Имя');
        CRUD::field('userDetail.father_name')->label('Отчество');
        CRUD::field('userDetail.gender')
            ->type('select_from_array')
            ->label('Пол')
            ->options(GenderDictionary::getTitleCollection());
        CRUD::field('is_enabled')->type('boolean')->label('Активный');
        CRUD::field('userDetail.birthday_at')->type('date')->label('День рождения');
        CRUD::field('created_at')->attributes(['disabled' => 'disabled'])->label('Дата создания');
        CRUD::field('updated_at')->attributes(['disabled' => 'disabled'])->label('Дата обновления');

        /*
        CRUD::field([   // select_from_array
            'name'        => 'roles',
            'label'       => "Роли",
            'type'        => 'select_from_array',
            'options'     => UserRoleDictionary::getTitleCollection(),
            'allows_null' => false,
            'default'     => UserRoleDictionary::ADMINISTRATOR,
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
        $password = $this->crud->getRequest()->request->get('password');
        if ($password === null || $password === '') {
            $this->crud->getRequest()->request->remove('password');
        }

        $response = $this->traitUpdate();

        return $response;
    }
}
