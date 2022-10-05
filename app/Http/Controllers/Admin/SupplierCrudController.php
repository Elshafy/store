<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Validation\Rule;


class SupplierCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Supplier::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/supplier');
        CRUD::setEntityNameStrings('supplier', 'suppliers');
        if (!backpack_user()->can('editSupplier', Supplier::class)) {
            $this->crud->denyAccess(['update', 'create', 'delete', 'list']);
        }
    }


    protected function setupListOperation()
    {
        CRUD::addColumn([
            'label'   => 'active',
            'name'    => 'active',
            'type'    => 'boolean',
            'options' => [true => 'active', false => 'inactive'],
        ]);
        CRUD::column('name');
        CRUD::column('email');
        CRUD::column('phone');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(SupplierRequest::class);

        CRUD::field('active');
        CRUD::field('name');
        CRUD::field('email');
        CRUD::field('phone');
    }


    protected function setupUpdateOperation()
    {

        $this->setupCreateOperation();
    }
}