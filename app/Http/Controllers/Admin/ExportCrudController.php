<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExportRequest;
use App\Models\Export;
use App\Models\Item;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

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

        // Export::created(function ($entry) {


        //     $this->changeAmount(request()->input('item_id'), request()->input('amount')));
        // });
        if (!backpack_user()->can('edit-export')) {
            $this->crud->denyAccess(['update', 'create', 'delete']);
        }
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
    public function store()
    {
        $response = null;

        if (!$this->checkEnoughAmount(request()->input('item_id'), request()->input('amount'))) {
            \Alert::add('warning', 'thers is no enought amount  ')->flash();

            return back();
        }
        DB::transaction(function () use (&$response) {
            $response = $this->traitStore();
            $this->changeAmount(request()->input('item_id'), request()->input('amount'));
        });



        return $response;
    }
    public function checkEnoughAmount($id, $amount)
    {
        $item = Item::find($id);

        return ($item->amount >= $amount);
    }

    public function changeAmount($id, $amount)
    {
        $item = Item::find($id);
        $item->amount =  $item->amount - $amount;
        $item->save();
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
}
