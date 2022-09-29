<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImportRequest;
use App\Models\Import;
use App\Models\Item;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ImportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ImportCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Import::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/import');
        CRUD::setEntityNameStrings('import', 'imports');
        //! adjest amount in the table items  after creat and update an import record
        Import::created(function ($entry) {
            $item = Item::find($entry->item_id);
            $item->amount =  $item->amount + $entry->amount;
            $item->save();
        });
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::column('item_id');
        CRUD::column('supplier_id');
        CRUD::addColumn([

            'label'     => 'item',
            'type'      => 'select',
            'name'      => 'item_id',
            'entity'    => 'item',
            'attribute' => 'name',
            'model'     => "App\Models\Item",
        ],);
        CRUD::column('amount');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ImportRequest::class);

        // CRUD::field('item_id');
        // CRUD::field('supplier_id');
        CRUD::field('amount');
        CRUD::addField([  // Select
            'label'     => "item",
            'type'      => 'select',
            'name'      => 'item_id',
            'entity'    => 'item',
            'model'     => "App\Models\Item",
            'attribute' => 'name',
            'options'   => (function ($query) {
                return $query->where('active', true)->get();
            })
        ],);
        CRUD::addField([  // Select
            'label'     => "supplier",
            'type'      => 'select',
            'name'      => 'supplier_id',
            'entity'    => 'supplier',
            'model'     => "App\Models\Supplier",
            'attribute' => 'name',
            'options'   => (function ($query) {
                return $query->where('active', true)->get();
            }),
        ],);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
