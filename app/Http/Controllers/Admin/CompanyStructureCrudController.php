<?php

namespace App\Http\Controllers\Admin;

use App\Dictionaries\CompanyStructure\CompanyStructureTypeFlagDictionary;
use App\Dictionaries\UserRoleDictionary;
use App\Helpers\CryptoHelper;
use App\Http\Requests\UserRequest;
use App\Models\CompanyStructure;
use App\Models\CompanyStructureType;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;
use Exception;

/**
 * Class CompanyStructureCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompanyStructureCrudController extends BaseCrudController
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
     * @var CompanyStructureType
     */
    private $companyStructureType;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->companyStructureType = CompanyStructureType::whereSlug($this->findSlug())->first();
    }

    /**
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(CompanyStructure ::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/company-structure/' . $this->companyStructureType->slug);
        CRUD::setEntityNameStrings($this->companyStructureType->title, $this->companyStructureType->title);
        CRUD::addClause('where', 'type_id', $this->companyStructureType->id);
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');
        foreach ($this->companyStructureType->companyStructureTypeRel as $companyStructureTypeRel) {
            /** @var Collection $options */
            $options = CompanyStructure::whereTypeId($companyStructureTypeRel->id)->get();
            $options = $options->pluck('title', 'id');
            $companyStructure = CompanyStructure::find($this->crud->getCurrentEntryId());

            CRUD::column([   // select_from_array
                'name'        => $companyStructureTypeRel->slug,
                'label'       => $companyStructureTypeRel->title,
                'type'        => 'text',
                //'default'     =>
                'value' => function($entity) use ($companyStructureTypeRel){
                    return $entity
                        ?->parent()
                        ->whereTypeId($companyStructureTypeRel->id)
                        ->first()
                        ?->title;
                },
            ]);
        }
    }

    /**
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('title')->type('text')->label('Название');

        foreach ($this->companyStructureType->companyStructureTypeRel as $companyStructureTypeRel) {
            /** @var Collection $options */
            $options = CompanyStructure::whereTypeId($companyStructureTypeRel->id)->get();
            $options = $options->pluck('title', 'id');
            $companyStructure = CompanyStructure::find($this->crud->getCurrentEntryId());

            CRUD::column([   // select_from_array
                'name'        => $companyStructureTypeRel->slug,
                'label'       => $companyStructureTypeRel->title,
                'type'        => 'select_from_array',
                'options'     => $options,
                'allows_null' => true,
                'default'     => $companyStructure->parent()->whereTypeId($companyStructureTypeRel->id)->first()?->title,
            ]);
        }
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::field('title')->type('text')->label('Название');

        foreach ($this->companyStructureType->companyStructureTypeRel as $companyStructureTypeRel) {
            /** @var Collection $options */
            $options = CompanyStructure::whereTypeId($companyStructureTypeRel->id)->get();
            $options = $options->pluck('title', 'id');
            $companyStructure = CompanyStructure::find($this->crud->getCurrentEntryId());

            CRUD::field([   // select_from_array
                'name'        => $companyStructureTypeRel->slug,
                'label'       => $companyStructureTypeRel->title,
                'type'        => 'select_from_array',
                'options'     => $options,
                'allows_null' => true,
                'default'     => $companyStructure?->parent()->first()?->id,
            ]);
        }
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

    /**
     * @return string|null
     */
    private function findSlug()
    {
        $slug = null;
        $i = count(Request::segments());
        while ($i > 0) {
            $slug = Request::segment($i);
            if (CompanyStructureType::whereSlug($slug)->exists()) {
                break;
            }
            $i--;
        }

        return $slug;
    }
}
