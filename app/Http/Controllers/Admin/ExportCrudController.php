<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExportRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


class ExportCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Export::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/export');
        CRUD::setEntityNameStrings('export', 'exports');
    }


    protected function setupListOperation()
    {
        // CRUD::column('item_id');
        CRUD::column('customer_id');
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
        CRUD::setValidation(ExportRequest::class);


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
            'label'     => "customer",
            'type'      => 'select',
            'name'      => 'customer_id',
            'entity'    => 'customer',
            'model'     => "App\Models\Customer",
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