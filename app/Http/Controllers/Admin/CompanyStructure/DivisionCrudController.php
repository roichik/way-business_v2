<?php

namespace App\Http\Controllers\Admin\CompanyStructure;

use App\Http\Controllers\Admin\BaseCrudController;
use App\Models\CompanyStructure\Company;
use App\Models\CompanyStructure\Division;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DivisionCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DivisionCrudController extends BaseCrudController
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

    /**
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Division::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/divisions');
        CRUD::setEntityNameStrings('Подразделение/отдел', 'Подразделения/отделы');
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();
        /*
        if (!$this->crud->getRequest()->has('order')) {
            $this->crud->orderBy('lft', 'desc');
        }
        */

        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');
        CRUD::column([
            'label'     => 'Компания',
            'type'      => 'select',
            'name'      => 'company_id',
            'entity'    => 'company',
            'model'     => Company::class,
            'attribute' => 'title',
            'options'   => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
        ]);
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата обновления');
    }

    /**
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');
        CRUD::column([
            'label'     => 'Компания',
            'type'      => 'select',
            'name'      => 'company_id',
            'entity'    => 'company',
            'model'     => Company::class,
            'attribute' => 'title',
            'pivot'     => true,
            'options'   => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
        ]);
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата обновления');
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::field('title')->type('text')->label('Название');
        CRUD::field([
            'label'     => 'Компания',
            'type'      => 'select',
            'name'      => 'company_id',
            'entity'    => 'company',
            'model'     => Company::class,
            'attribute' => 'title',
            'pivot'     => true,
            'options'   => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),
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
