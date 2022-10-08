<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Validation\Rule;


class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings(trans('category.category'), trans('category.categories'));
    }


    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'code', 'label' => trans('category.code')]);
        CRUD::addColumn(['name' => 'name', 'label' => trans('category.name')]);
        CRUD::addColumn(['name' => 'created_at', 'label' => trans('category.created')]);
        CRUD::addColumn(['name' => 'updated_at', 'label' => trans('category.updated')]);
    }
    protected function setupShowOperation()
    {

        $this->setupListOperation();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoryRequest::class);

        CRUD::addField(['name' => 'name', 'label' => trans('category.name')]);
        CRUD::addField(['name' => 'code', 'label' => trans('category.code')]);
    }


    protected function setupUpdateOperation()
    {

        $this->setupCreateOperation();
    }
}