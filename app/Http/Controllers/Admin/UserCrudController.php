<?php

namespace App\Http\Controllers\Admin;

use App\Dictionaries\Security\AccessGroupFlagDictionary;
use App\Dictionaries\User\GenderDictionary;
use App\Http\Requests\Admin\User\UserCreateRequest;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Models\CompanyStructure\Company;
use App\Models\CompanyStructure\Division;
use App\Models\CompanyStructure\Position;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use App\Models\User\User;
use App\Services\BackPackAdmin\BackPackAdminService;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

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
        CRUD::column('detail.last_name')->type('text')->label('Фамилия');
        CRUD::column('detail.first_name')->type('text')->label('Имя');
        CRUD::column('detail.father_name')->type('text')->label('Отчество');
        CRUD::column('is_enabled')->type('boolean')->label('Активный');
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата обновления');
    }

    /**
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('nickname')->type('text')->label('Пользователь');
        CRUD::column('email')->type('text')->label('Email');
        CRUD::column('email_verified_at')->type('text')->label('Дата верификации Email');
        CRUD::column('phone')->type('text')->label('Телефон');
        CRUD::column('phone_verified_at')->type('text')->label('Дата верификации телефона');
        CRUD::column('detail.last_name')->type('text')->label('Фамилия');
        CRUD::column('detail.first_name')->type('text')->label('Имя');
        CRUD::column('detail.father_name')->type('text')->label('Отчество');
        CRUD::column('detail.gender')
            ->type('select_from_array')
            ->label('Пол')
            ->options(GenderDictionary::getTitleCollection());

        CRUD::column('detail.birthday_at')->type('date')->label('День рождения');

        CRUD::column([
            'label'         => 'Компания',
            'type'          => 'select',
            'name'          => 'detail.company_id',
            'entity'        => 'detail.company',
            'model'         => Company::class,
            'attribute'     => 'title',
            'options'       => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'relation_type' => 'BelongsTo',
        ]);
        CRUD::column([
            'label'         => 'Подразделение/отдел',
            'type'          => 'select',
            'name'          => 'detail.division_id',
            'entity'        => 'detail.division',
            'model'         => Division::class,
            'attribute'     => 'title',
            'options'       => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'relation_type' => 'BelongsTo',
        ]);
        CRUD::column([
            'label'         => 'Должность',
            'type'          => 'select',
            'name'          => 'detail.position_id',
            'entity'        => 'detail.position',
            'model'         => Position::class,
            'attribute'     => 'title',
            'options'       => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'relation_type' => 'BelongsTo',
        ]);

        CRUD::column([
            'label'             => 'Группы доступа',
            'field_unique_name' => 'access_groups',
            'type'              => 'checklist',
            'name'              => 'adminAccessGroups',
            'tab'               => 'Права доступа',
        ]);

        CRUD::column([
            'label'             => 'Роли и права доступа',
            'field_unique_name' => 'role_permission',
            'type'              => 'checklist_dependency',
            'name'              => 'adminAccessRoles,adminAccessPermissions',
            'tab'               => 'Права доступа',
            'subfields'         => [
                'primary'   => [
                    'label'            => 'Роли',
                    'name'             => 'adminAccessRoles',
                    'entity'           => 'adminAccessRoles',
                    'entity_secondary' => 'permissions',
                    'attribute'        => 'name',
                    'model'            => Role::class,
                    'pivot'            => true,
                    'number_columns'   => 3,
                ],
                'secondary' => [
                    'label'          => 'Права доступа',
                    'name'           => 'adminAccessPermissions',
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
        $flags = User::find($this->crud->getCurrentEntryId())->adminAccess->flags;
        foreach (AccessGroupFlagDictionary::getTitleCollection() as $id => $label) {
            CRUD::column([
                'label'    => $label,
                'type'     => 'checkbox',
                'name'     => $id,
                'value'    => array_key_exists($id, $flags) && (bool)$flags[$id],
                'fake'     => true,
                'store_in' => 'flags',
            ]);
        }

        //Компании
        CRUD::column([
            'label'           => 'Компании',
            'type'            => 'checklist',
            'name'            => 'adminAccessCompanies',
            'entity'          => 'adminAccessCompanies',
            'attribute'       => 'title',
            'model'           => Company::class,
            'pivot'           => true,
            'show_select_all' => true,
            'number_columns'  => 2,
            'tab'             => 'Права доступа',
        ]);
        CRUD::column('is_enabled')->type('boolean')->label('Активный')->tab('Общие сведенья');
        CRUD::column('created_at')->label('Дата создания')->tab('Общие сведенья');
        CRUD::column('updated_at')->label('Дата обновления')->tab('Общие сведенья');
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
        CRUD::field('detail.last_name')->label('Фамилия')->tab('Общие сведенья');
        CRUD::field('detail.first_name')->label('Имя')->tab('Общие сведенья');
        CRUD::field('detail.father_name')->label('Отчество')->tab('Общие сведенья');
        CRUD::field('detail.gender')
            ->type('select_from_array')
            ->label('Пол')
            ->options(GenderDictionary::getTitleCollection())
            ->tab('Общие сведенья');
        CRUD::field('detail.birthday_at')->type('date')->label('День рождения')->tab('Общие сведенья');
        $this->addCompanyStructureFields();
        CRUD::field('is_enabled')->type('boolean')->label('Активный')->tab('Общие сведенья');

        $this->addAccessFields();
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(UserUpdateRequest::class);

        CRUD::field('nickname')->type('text')->label('Пользователь')->attributes(['disabled' => 'disabled'])->tab('Общие сведенья');
        CRUD::field('email')->type('text')->label('Email')->attributes(['autocomplete' => 'off', 'disabled' => 'disabled'])->tab('Общие сведенья');
        CRUD::field('password')->label('Пароль')->value('')->attributes(['autocomplete' => 'off'])->tab('Общие сведенья');
        CRUD::field('email_verified_at')->type('datetime')->label('Дата верификации Email')->tab('Общие сведенья');
        CRUD::field('phone')->type('text')->label('Телефон')->tab('Общие сведенья');
        CRUD::field('phone_verified_at')->type('datetime')->label('Дата верификации телефона')->tab('Общие сведенья');
        CRUD::field('detail.last_name')->label('Фамилия')->tab('Общие сведенья');
        CRUD::field('detail.first_name')->label('Имя')->tab('Общие сведенья');
        CRUD::field('detail.father_name')->label('Отчество')->tab('Общие сведенья');
        CRUD::field('detail.gender')
            ->type('select_from_array')
            ->label('Пол')
            ->options(GenderDictionary::getTitleCollection())
            ->tab('Общие сведенья');
        CRUD::field('detail.birthday_at')->type('date')->label('День рождения')->tab('Общие сведенья');
        $this->addCompanyStructureFields();
        CRUD::field('is_enabled')->type('boolean')->label('Активный')->tab('Общие сведенья');

        $this->addAccessFields();
    }

    /**
     * @return void
     */
    private function addCompanyStructureFields()
    {
        CRUD::field([
            'label'         => 'Компания',
            'type'          => 'select',
            'name'          => 'detail.company_id',
            'entity'        => 'detail.company',
            'model'         => Company::class,
            'attribute'     => 'title',
            'options'       => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'relation_type' => 'BelongsTo',
            'tab'           => 'Общие сведенья',
        ]);
        CRUD::field([
            'label'         => 'Подразделение/отдел',
            'type'          => 'select',
            'name'          => 'detail.division_id',
            'entity'        => 'detail.division',
            'model'         => Division::class,
            'attribute'     => 'title',
            'options'       => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'relation_type' => 'BelongsTo',
            'tab'           => 'Общие сведенья',
        ]);
        CRUD::field([
            'label'         => 'Должность',
            'type'          => 'select',
            'name'          => 'detail.position_id',
            'entity'        => 'detail.position',
            'model'         => Position::class,
            'attribute'     => 'title',
            'options'       => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
            'relation_type' => 'BelongsTo',
            'tab'           => 'Общие сведенья',
        ]);
    }

    /**
     * @return void
     */
    private function addAccessFields()
    {
        CRUD::field([
            'label'             => 'Группы доступа',
            'field_unique_name' => 'access_groups',
            'type'              => 'checklist',
            'name'              => 'adminAccessGroups',
            'tab'               => 'Права доступа',
        ]);

        CRUD::field([
            'label'             => 'Роли и права доступа',
            'field_unique_name' => 'role_permission',
            'type'              => 'checklist_dependency',
            'name'              => 'adminAccessRoles,adminAccessPermissions',
            'tab'               => 'Права доступа',
            'subfields'         => [
                'primary'   => [
                    'label'            => 'Роли',
                    'name'             => 'adminAccessRoles',
                    'entity'           => 'roles',
                    'entity_secondary' => 'permissions',
                    'attribute'        => 'name',
                    'model'            => Role::class,
                    'pivot'            => true,
                    'number_columns'   => 3,
                ],
                'secondary' => [
                    'label'          => 'Права доступа',
                    'name'           => 'adminAccessPermissions',
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
                $flagValue = User::find($this->crud->getCurrentEntryId())->adminAccess->flagById(
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
                'store_in' => 'adminAccess.flags',
                'tab'      => 'Права доступа',
            ]);
        }

        //Компании
        CRUD::field([
            'label'           => 'Компании',
            'type'            => 'checklist',
            'name'            => 'adminAccessCompanies',
            'entity'          => 'adminAccessCompanies',
            'attribute'       => 'title',
            'model'           => Company::class,
            'pivot'           => true,
            'show_select_all' => true,
            'number_columns'  => 2,
            'tab'             => 'Права доступа',
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function store()
    {
        DB::beginTransaction();
        try {
            $password = $this->crud->getRequest()->request->get('password');
            if ($password === null || $password === '') {
                $this->crud->getRequest()->request->remove('password');
            }

            $response = $this->traitStore();
            $this->updateUserAdminAccessFlags();
            $this->updateUserCompanyStructure();
        } catch (\Throwable $exception) {
            DB::rollback();
            throw $exception;
        }
        DB::commit();

        /** @var BackPackAdminService $backPackService */
        $backPackService = resolve(BackPackAdminService::class);
        $backPackService
            ->security()
            ->syncAllPermissionsByUser(
                User::find($this->crud->getCurrentEntryId())
            );


        return $response;
    }

    /**
     * @return RedirectResponse
     */
    public function update()
    {
        DB::beginTransaction();
        try {
            $password = $this->crud->getRequest()->request->get('password');
            if ($password === null || $password === '') {
                $this->crud->getRequest()->request->remove('password');
            }

            $response = $this->traitUpdate();
            $this->updateUserAdminAccessFlags();
            $this->updateUserCompanyStructure();
        } catch (\Throwable $exception) {
            DB::rollback();
            throw $exception;
        }
        DB::commit();

        /** @var BackPackAdminService $backPackService */
        $backPackService = resolve(BackPackAdminService::class);
        $backPackService
            ->security()
            ->syncAllPermissionsByUser(
                User::find($this->crud->getCurrentEntryId())
            );

        return $response;
    }

    /**
     * @return void
     */
    private function updateUserCompanyStructure()
    {
        $all = $this->crud->getRequest()->request->all();
        $userDetail = User::find($this->crud->getCurrentEntryId())->detail;
        $userDetail
            ->fill([
                'company_id'  => $all['detail']['company_id'],
                'division_id' => $all['detail']['division_id'],
                'position_id' => $all['detail']['position_id'],
            ]);
        $userDetail->save();
    }

    /**
     * @return void
     */
    private function updateUserAdminAccessFlags()
    {
        $all = $this->crud->getRequest()->request->all();
        $flags = [];
        foreach (AccessGroupFlagDictionary::getCollection() as $id) {
            if (array_key_exists($id, $all)) {
                $flags[$id] = $all[$id];
                continue;
            }
            $flags[$id] = AccessGroupFlagDictionary::getDefaultValueById($id);
        }

        /** @var User $user */
        $user = User::find($this->crud->getCurrentEntryId());
        if (!$user->adminAccess) {
            $user->adminAccess()->create();
            $user->refresh();
        }

        $user->adminAccess->flags = $flags;
        $user->adminAccess->save();
    }
}
