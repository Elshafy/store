<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use App\Models\User;
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
        CRUD::addColumn([
            'name'  => 'user.name',
            'label' => 'Title',
            'type'  => 'text'
        ],);
        CRUD::addColumn([
            'name'  => 'user.email',
            'label' => 'email',
            'type'  => 'text'
        ],);
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }
    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        $request = $this->crud->validateRequest();
        $this->crud->registerFieldEvents();


        $user = User::create([
            'name'     => request()->input('name'),
            'email'    => request()->input('email'),
            'password' => bcrypt(request()->input('phone'))
        ]);


        $item = $this->crud->create(['user_id' => $user->id]);
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $response = $this->crud->performSaveAction($item->getKey());

        return $response;
    }



    protected function setupCreateOperation()
    {
        CRUD::setValidation(SupplierRequest::class);

        CRUD::field('active');
        CRUD::field('name');
        CRUD::field('email');
        CRUD::field('phone');
    }
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();

        $user = $this->crud->getCurrentEntry()->user;
        $user->name = request()->input('name');
        $user->email = request()->input('email');
        $user->save();

        // update the row in the db
        $item = $this->crud->update(
            $request->get($this->crud->model->getKeyName()),
            ['active' => request('active')]
        );
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }


    protected function setupUpdateOperation()
    {

        // $this->setupCreateOperation();
        CRUD::setValidation(SupplierRequest::class);
        $user = $this->crud->getCurrentEntry()->user;

        CRUD::field('active');
        $this->crud->addField([
            'name' => 'email',
            'type' => 'email',
            'label' => "email",
            'default' => $user->email
        ]);
        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "name",
            'default' => $user->name
        ]);
    }
}