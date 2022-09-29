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
        CRUD::column('category_id');
        CRUD::column('name');
        CRUD::column('code');
        CRUD::column('min');
        CRUD::column('amount');
        CRUD::column('price');
        CRUD::addColumn([
            'name'      => 'image', // The db column name
            'label'     => 'image', // Table column heading
            'type'      => 'image',
            'height' => '30px',
            'width'  => '30px',
            'prefix' => 'uploads/',

        ]);
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
        CRUD::field('name');
        CRUD::field('code');
        CRUD::field('min');
        CRUD::field('amount');
        CRUD::field('price');
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