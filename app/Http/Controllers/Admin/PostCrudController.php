<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\Tag;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Post::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post');
        CRUD::setEntityNameStrings('post', 'posts');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // $this->crud->setFromDb();
        $this->crud->addColumns(['title', 'tags', 'category']);
        // CRUD::column('id');
        // CRUD::column('title');
        // CRUD::column('introduction');
        // CRUD::column('body');
        // CRUD::column('author');
        // CRUD::column('category_id');
        // CRUD::column('created_at');
        // CRUD::column('updated_at');
        // $this->crud->addColumn([
        //     'label' => "Category",
        //     'type' => 'select',
        //     'name' => 'category',
        //     'entity' => 'category',
        //     'attribute' => 'name',
        //     'model' => Category::class
        //  ]);
        //  $this->crud->addColumn([
        //     'label' => "Tags",
        //     'type' => 'select',
        //     'name' => 'tags',
        //     'entity' => 'tags',
        //     'attribute' => 'name',
        //     'model' => Tag::class
        //  ]);
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
        $this->crud->setFromDb();
        $this->crud->removeFields(['category_id']);
        CRUD::setValidation(PostRequest::class);
        $this->crud->addField([
            'name'=>'category',
            'type'=>'select',
            'label'=>'Category',
            'entity'=>'category',
            'model'=>Category::class,
            'attribute'=>'name'
        ]);
        $this->crud->addField([
            'label'=>'Tags',
            'type'=>'select_multiple',
            'name'=>'tags',
            'entity'=>'tags',
            'model'=>Tag::class,
            'attribute'=>'name',
            'pivot'=>true
        ]);
        // CRUD::field('id');
        // CRUD::field('title');
        // CRUD::field('introduction');
        // CRUD::field('body');
        // CRUD::field('author');
        // CRUD::field('category_id');
        // CRUD::field('created_at');
        // CRUD::field('updated_at');

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
        $this->setupCreateOperation();
    }
}
