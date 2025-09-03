<?php

namespace App\Http\Controllers\Admin;

use App\Dictionaries\CompanyStructure\CompanyStructureTypeFlagDictionary;
use App\Models\CompanyStructureType;
use App\Dictionaries\UserRoleDictionary;
use App\Helpers\CryptoHelper;
use App\Http\Requests\UserRequest;
use App\Models\CompanyStructureTypeRel;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Jenssegers\Agent\Agent;

/**
 * Class PermissionCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompanyStructureTypeCrudController extends BaseCrudController
{
    use ListOperation;
    use ShowOperation;
    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }
    use DeleteOperation;
    use ReorderOperation;

    /**
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(CompanyStructureType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/company-structure/types');
        CRUD::setEntityNameStrings('Тип структуры компании', 'Типы структуры компании');
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::orderBy('lft');
        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');
        CRUD::column('slug')->type('text')->label('Метка');
        CRUD::column([
            'label'     => 'Связанные типы',
            'type'      => 'select_multiple',
            'name'      => 'companyStructureTypeRel',
            'model'     => CompanyStructureType::class,
            'attribute' => 'title',
            'attributes' => [
                'size' => 8,
            ],
        ]);
    }

    /**
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');
        CRUD::column('slug')->type('text')->label('Метка');
        CRUD::column([
            'label'     => 'Связанные типы',
            'type'      => 'select_multiple',
            'name'      => 'companyStructureTypeRel',
            'model'     => CompanyStructureType::class,
            'attribute' => 'title',
            'attributes' => [
                'size' => 8,
            ],
        ]);




    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::field('title')->type('text')->label('Название');
        CRUD::field('slug')->type('text')->label('Метка');
        CRUD::addField([
            'label'     => 'Связанные типы',
            'type'      => 'select_multiple',
            'name'      => 'companyStructureTypeRel',
            'model'     => CompanyStructureType::class,
            'attribute' => 'title',
            'attributes' => [
                'size' => 8,
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

    /**
     * @return void
     */
    protected function setupReorderOperation()
    {
        CRUD::set('reorder.label', 'title');
        CRUD::set('reorder.max_level', 1);
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function destroy($id)
    {
        if ($this->crud->getCurrentEntry()->hasFlag(CompanyStructureTypeFlagDictionary::DISABLE_DELETION)) {

            \Alert::add('error', 'Удаление сущности запрещено');

            return false;
        }

        return CRUD::delete($id);
    }
}
