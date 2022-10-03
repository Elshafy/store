<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExportRequest;
use App\Models\Export;
use App\Models\Item;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


class ExportCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Export::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/export');
        CRUD::setEntityNameStrings('export', 'exports');

        // //! adjest amount in the table items  after creat and update an import record

        Export::created(function ($entry) {


            $this->changeAmount($entry);
        });
    }


    protected function setupListOperation()
    {
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
    public function changeAmount($entry)
    {
        $item = Item::find($entry->item_id);
        $item->amount =  $item->amount - $entry->amount;
        $item->save();
    }

    public function checkEnoughAmount($id, $amount)
    {
        $item = Item::find($id);

        return (($item->amount - $item->min) >= $amount);
    }
    public function store()
    {


        if (!$this->checkEnoughAmount(request()->input('item_id'), request()->input('amount'))) {
            \Alert::add('warning', 'thers is no enought amount  ')->flash();

            return back();
        }
        $response = $this->traitStore();
        return $response;
    }
}
