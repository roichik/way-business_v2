<?php

namespace App\Http\Controllers\Admin\CompanyStructure;

use App\Http\Controllers\Admin\BaseCrudController;
use App\Http\Requests\Admin\Security\CreatePositionRequest;
use App\Http\Requests\Admin\Security\UpdatePositionRequest;
use App\Models\CompanyStructure\Division;
use App\Models\CompanyStructure\Position;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PositionCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PositionCrudController extends BaseCrudController
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
        CRUD::setModel(Position::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/positions');
        CRUD::setEntityNameStrings('Должность', 'Должности');
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
            'label'                      => 'Компания',
            'type'                       => 'select',
            'name'                       => 'company_id',
            'entity'                     => 'division.company',
            'model'                      => Division::class,
            'attribute'                  => 'title',
        ]);
        CRUD::column([
            'label'                      => 'Подразделение/отдел',
            'type'                       => 'select',
            'name'                       => 'division_id',
            'entity'                     => 'division',
            'model'                      => Division::class,
            'attribute'                  => 'title',
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
            'label'                      => 'Компания',
            'type'                       => 'select',
            'name'                       => 'company_id',
            'entity'                     => 'division.company',
            'model'                      => Division::class,
            'attribute'                  => 'title',
        ]);
        CRUD::column([
            'label'                      => 'Подразделение/отдел',
            'type'                       => 'select',
            'name'                       => 'division_id',
            'entity'                     => 'division',
            'model'                      => Division::class,
            'attribute'                  => 'title',
        ]);
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата обновления');
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CreatePositionRequest::class);
        CRUD::field('title')->type('text')->label('Название');
        CRUD::field([
            'label'                      => 'Подразделение/отдел',
            'type'                       => 'select_grouped',
            'name'                       => 'division',
            'entity'                     => 'division',
            'model'                      => Division::class,
            'attribute'                  => 'title',
            'group_by'                   => 'company',
            'group_by_attribute'         => 'title',
            'group_by_relationship_back' => 'divisions',
        ]);
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        CRUD::setValidation(UpdatePositionRequest::class);
    }
}
