<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImportRequest;
use App\Models\Import;
use App\Models\Item;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


class ImportCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


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


    protected function setupListOperation()
    {
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
    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(ImportRequest::class);


        CRUD::addField([
            'name' => 'amount', 'label' => 'amount', 'attributes' => ['min' => 0,]
        ]);
        CRUD::addField([
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
        CRUD::addField([
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
    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}