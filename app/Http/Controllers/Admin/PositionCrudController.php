<?php

namespace App\Http\Controllers\Admin;

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
        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');
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
        CRUD::column('created_at')->label('Дата создания');
        CRUD::column('updated_at')->label('Дата обновления');
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::field('title')->type('text')->label('Название');
        /*
        CRUD::field([   // select_grouped
            'label'     => "Подразделения/отделы",
            'type'      => 'select_grouped',
            'name'      => 'division_id',
            'entity'    => 'divisions',
            'model'     => Division::class,
            'attribute' => 'title',
            'group_by'  => 'companies',
            'group_by_attribute' => 'title',
            'group_by_relationship_back' => 'divisions',
        ]);
        */

        /*
                CRUD::field([   // select_grouped
                    'label'     => "Подразделения/отделы",
                    'type'      => 'select_grouped',
                    'name'      => 'divisions',
                    'entity'    => 'divisions',
                    'model'     => Division::class,
                    'attribute' => 'title',
                    'allows_null' => true,
                    'pivot'     => true,
                    //'relation_type' => 'belongsToMany',
                    'attributes' => ['multiple' => 'multiple', 'size' => 10],
                    'group_by'  => 'companies',
                    'group_by_attribute' => 'title',
                    'group_by_relationship_back' => 'divisions',
                ]);
        */
        CRUD::field([
            'label'                      => 'Подразделения/отдел',
            'type'                       => 'select_grouped',
            'name'                       => 'divisions',
            'entity'                     => 'divisions',
            'model'                      => Division::class,
            'attribute'                  => 'title',
            'pivot'                      => true,
            //'relation_type'              => 'belongsToMany',
            'attributes'                 => ['size' => 10],
            'multiple'                   => true,
            'allows_null'                => false,
            'group_by'                   => 'companies',
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
    }

    public function store()
    {
        return $this->traitStore();
    }

    public function update()
    {
        // do something before validation, before save, before everything; for example:
        // $this->crud->addField(['type' => 'hidden', 'name' => 'author_id']);
        // $this->crud->removeField('password_confirmation');

        // Note: By default Backpack ONLY saves the inputs that were added on page using Backpack fields.
        // This is done by stripping the request of all inputs that do NOT match Backpack fields for this
        // particular operation. This is an added security layer, to protect your database from malicious
        // users who could theoretically add inputs using DeveloperTools or JavaScript. If you're not properly
        // using $guarded or $fillable on your model, malicious inputs could get you into trouble.

        // However, if you know you have proper $guarded or $fillable on your model, and you want to manipulate
        // the request directly to add or remove request parameters, you can also do that.
        // We have a config value you can set, either inside your operation in `config/backpack/crud.php` if
        // you want it to apply to all CRUDs, or inside a particular CrudController:
        // $this->crud->setOperationSetting('saveAllInputsExcept', ['_token', '_method', 'http_referrer', 'current_tab', 'save_action']);
        // The above will make Backpack store all inputs EXCEPT for the ones it uses for various features.
        // So you can manipulate the request and add any request variable you'd like.
        // $this->crud->getRequest()->request->add(['author_id'=> backpack_user()->id]);
        // $this->crud->getRequest()->request->remove('password_confirmation');
        // $this->crud->getRequest()->request->add(['author_id'=> backpack_user()->id]);
        // $this->crud->getRequest()->request->remove('password_confirmation');

        $response = $this->traitUpdate();

        // do something after save
        return $response;
    }

}
