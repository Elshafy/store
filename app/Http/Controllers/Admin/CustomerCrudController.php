<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Validation\Rule;


class CustomerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer');
        CRUD::setEntityNameStrings('customer', 'customers');
        if (!backpack_user()->can('edit-customer')) {
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
        CRUD::setValidation(CustomerRequest::class);

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