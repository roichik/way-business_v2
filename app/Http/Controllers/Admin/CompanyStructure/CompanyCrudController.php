<?php

namespace App\Http\Controllers\Admin\CompanyStructure;

use App\Http\Controllers\Admin\BaseCrudController;
use App\Http\Requests\Admin\Security\CreateCompanyRequest;
use App\Http\Requests\Admin\Security\UpdateCompanyRequest;
use App\Models\CompanyStructure\Company;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CompanyStructureCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompanyCrudController extends BaseCrudController
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
        CRUD::setModel(Company::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/companies');
        CRUD::setEntityNameStrings('Компания', 'Компании');

    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();

        //change default order key
        if (!$this->crud->getRequest()->has('order')) {
            $this->crud->orderBy('lft', 'asc');
        }

        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');
        CRUD::column([
            'label'     => 'Управляющая компания',
            'type'      => 'select',
            'name'      => 'parent_id',
            'entity'    => 'parent',
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
            'label'     => 'Управляющая компания',
            'type'      => 'select',
            'name'      => 'parent_id',
            'entity'    => 'parent',
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
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CreateCompanyRequest::class);
        CRUD::field('title')->type('text')->label('Название');
        CRUD::field([
            'label'         => 'Управляющая компания',
            'type'          => 'select',
            'name'          => 'parent_id',
            'entity'        => 'parent',
            'model'         => Company::class,
            'attribute'     => 'title',
            'options'       => (function ($query) {
                $query
                    ->orderBy('title', 'ASC');

                if ($this->crud->getCurrentEntryId()) {
                    $query->where('id', '!=', $this->crud->getCurrentEntryId());
                }

                return $query->get();
            }),
        ]);
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        CRUD::setValidation(UpdateCompanyRequest::class);
    }

    /**
     * @return void
     */
    protected function setupReorderOperation()
    {
        CRUD::set('reorder.label', 'title');
        CRUD::set('reorder.max_level', 3);
    }
}
