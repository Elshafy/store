<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;


class ItemCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Item::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/item');
        CRUD::setEntityNameStrings(trans('item.item'), trans('item.items'));
        if (!backpack_user()->can('edit-item')) {
            $this->crud->denyAccess(['update', 'create', 'delete']);
        }
    }


    protected function setupListOperation()
    {
        if (backpack_user()->can('changeState')) {
            $this->crud->addButtonFromView('line', 'changeStateItem',  'changeStateItem', 'beginning');
        }
        if (backpack_user()->can('edit-item')) {
        }
        CRUD::addColumn(
            [
                'name' => 'name',
                'label'  => trans('item.name')
            ]
        );
        CRUD::addColumn(
            [
                'name' => 'category_id',
                'label'  => trans('item.category')
            ]
        );
        CRUD::addColumn(
            [
                'name' => 'code',
                'label'   => trans('item.code')
            ]
        );
        CRUD::addColumn(
            [
                'name' => 'min',
                'label'    => trans('item.min')
            ]
        );
        CRUD::addColumn(
            [
                'name' => 'amount',
                'label'       => trans('item.amount')
            ]
        );
        CRUD::addColumn(
            [
                'name' => 'price',
                'label'        => trans('item.price')
            ]
        );

        CRUD::addColumn([
            'label'   => trans('item.active'),
            'name'    => 'active',
            'type'    => 'boolean',
            'options' => [true => 'active', false => 'inactive'],
        ]);
        CRUD::addColumn(
            [
                'name' => 'created_at',
                'label'        => trans('item.created')
            ]
        );
        CRUD::addColumn(
            [
                'name' => 'updated_at',
                'label'        => trans('item.updated')
            ]
        );
    }
    protected function setupShowOperation()
    {

        $this->setupListOperation();
        CRUD::addColumn(
            [
                'name'      => 'image', // The db column name
                'label'     => trans('item.image'), // Table column heading
                'type'      => 'image',
                'height' => '200px',
                'width'  => '200px',
                'prefix' => 'uploads/',

            ]
        );
    }



    protected function setupCreateOperation()
    {
        CRUD::setValidation(ItemRequest::class);
        $this->crud->removeColumn('image');
        CRUD::addField(
            [
                'name' => 'category_id',
                'label'  => trans('item.category')
            ]
        );
        CRUD::addField(['name' => 'name', 'label' => trans('item.name')]);
        CRUD::addField(['name' => 'code', 'label' => trans('item.code')]);
        CRUD::addField(
            [
                'name' => 'min', '
                 label' => trans('item.min'),
                'attributes' => ['min' => 0,]
            ]
        );
        CRUD::addField([
            'name' => 'amount', 'label' => trans('item.amount'), 'attributes' => ['min' => 0,]
        ]);
        CRUD::addField([
            'name'      => 'image',
            'label'     => trans('item.image'),
            'type'      => 'upload',
            'upload'    => true,
            'disk'   => 'uploads',

        ]);
        CRUD::addField(
            [
                'name' => 'price',
                'label' => trans('item.price'),
                'type' => 'number',

                // optionals
                'attributes' => ["step" => "any", 'min' => 0,], // allow decimals



            ]
        );
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     * [
            'name' => ['required', Rule::unique('items', 'name')->ignore($entry)],
            'code' => 'required|min:5|max:255',
            'amount' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'image',
            // 'active' => 'required|boolean'

        ]
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        CRUD::setValidation(ItemRequest::class);
    }
    public function changeState($id)
    {
        Gate::authorize('activeItem', Item::class);
        $item =  Item::find($id);
        $item->active = !$item->active;
        $item->save();
        return back();
    }
}