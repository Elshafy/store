<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

/**
 * Class ItemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ItemCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Item::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/item');
        CRUD::setEntityNameStrings('item', 'items');
        Gate::authorize('editItem', Item::class);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if (backpack_user()->can('changeState')) {
            $this->crud->addButtonFromView('line', 'changeStateItem', "button", 'changeStateItem', 'beginning');
        }
        // $this->crud->addButton('line', 'changeStateItem', 'changeStateItem', 'beginning');
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
        CRUD::addColumn(
            [
                'name'      => 'image', // The db column name
                'label'     => trans('item.image'), // Table column heading
                'type'      => 'image',
                'height' => '30px',
                'width'  => '30px',
                'prefix' => 'uploads/',

            ]
        );
        CRUD::addColumn([
            'label'   => 'active',
            'name'    => 'active',
            'type'    => 'boolean',
            'options' => [true => 'active', false => 'pendding'],
        ]);
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }


    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ItemRequest::class);
        $this->crud->removeColumn('image');
        CRUD::field('category_id');
        CRUD::addField(['name' => 'name', 'label' => trans('item.name')]);
        CRUD::addField(['name' => 'code', 'label' => trans('item.code')]);
        CRUD::addField(['name' => 'min', 'label' => trans('item.min')]);
        CRUD::addField(['name' => 'amount', 'label' => trans('item.amount')]);
        CRUD::addField([
            'name'      => 'image',
            'label'     => 'image',
            'type'      => 'upload',
            'upload'    => true,
            'disk'   => 'uploads',

        ]);
        // CRUD::field('active');

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
        $entry = $this->crud->getCurrentEntry();
        CRUD::setValidation([
            'name' => ['required', Rule::unique('items', 'name')->ignore($entry)],
            'code' => 'required|min:5|max:255',
            'amount' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'image',
            // 'active' => 'required|boolean'

        ]);
        $this->setupCreateOperation();
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