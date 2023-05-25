<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
use App\Mail\PostStatusUpdated;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Class PostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
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
        $this->crud->addColumn([
            'name' => 'title',
            'limit' => 50,
        ]);

        $this->crud->addColumn([
            'name' => 'introduction',
            'limit' => 50,
        ]);

        $this->crud->addColumn([
            'name' => 'category',
            'type' => 'relationship',
            'label' => 'Category',
            'entity'    => 'category',
            'attribute' => 'name',
            'model'     => App\Models\Category::class, // foreign key model
        ]);

        $this->crud->addColumn([
            'name' => 'author', // the method that defines the relationship in your Model
            'type' => 'relationship', // <<- this is the same always for relationship columns
            'label' => 'Author', // Table column heading
            'entity'    => 'author', // the method that defines the relationship in your Model
            'attribute' => 'name', // The column from the foreign table that you want to show
            'model'     => App\Models\User::class, // foreign key model
        ]);

        $this->crud->addColumn([
            'name' => 'tags',
            'type' => 'relationship',
            'label' => 'Tags',
            'entity'    => 'tags',
            'attribute' => 'name',
            'model'     => App\Models\Tag::class,
        ]);

        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status'
        ]);


    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PostRequest::class);

        $this->crud->addField([
            'name' => 'title'
        ]);

        $this->crud->addField([
            'name' => 'introduction',
        ]);

        $this->crud->addField([   // CKEditor
            'name' => 'body',
            'label' => 'Post Body',
            'type' => 'ckeditor',

            // optional:
            'extra_plugins' => ['widget'],
            'options' => [
                'height' => 400,
                'autoGrow_minHeight' => 200,
                'autoGrow_bottomSpace' => 50,
                'removePlugins' => 'resize,maximize',
            ]
        ]);

        $this->crud->addField([
            'name' => 'author_id',
            'type' => 'select2',
            'label' => 'Author',
            'entity' => 'author',
            'model' => User::class,
            'attribute' => 'name',
            'wrapperAttributes' => [
                'class' => 'col-md-4'
            ]
        ]);

        $this->crud->addField([
            'name' => 'category_id',
            'type' => 'select2',
            'label' => 'Category',
            'entity' => 'category',
            'model' => Category::class,
            'attribute' => 'name',
            'wrapperAttributes' => [
                'class' => 'col-md-4'
            ]
        ]);

        $this->crud->addField([
            'label' => 'Tags',
            'type' => 'select2_multiple',
            'name' => 'tags',
            'entity' => 'tags',
            'model' => Tag::class,
            'attribute' => 'name',
            'pivot' => true,
            'wrapperAttributes' => [
                'class' => 'col-md-4'
            ]
        ]);

        $this->crud->addField([
            'name' => 'status',
            'label' => 'Status',
            'type'  => 'select_from_array',
            'options' => [
                'draft' => 'draft',
                'accepted' => 'accepted',
                'declined' => 'declined'
            ]
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

    public function store(Request $request)
    {
        
      // do something before validation, before save, before everything
      $response = $this->traitStore();
      $post = Post::find($this->data['entry']['id']);
      if($this->data['entry']['status'] == 'accepted')
      {
        $post->publish_at = now();
        $post->save();
        Mail::to(User::find($this->data['entry']['author_id'])->first()->email)->queue(new PostStatusUpdated($post, true));
      }
      // do something after save
      return $response;
    }

    public function update(Request $request)
    {
        
      $post = Post::find($request->id);
      $response = $this->traitUpdate();
      switch ($this->crud->entry['status']) {
        case 'accepted':
            if(!$post->publish_at)
            {
                Post::where('id', $this->data['entry']['id'])->update(['publish_at' => now()]);
                Mail::to(User::find($this->data['entry']['author_id'])->first()->email)->queue(new PostStatusUpdated($post, true));
            }
            break;
        case 'declined':
            Mail::to(User::find($this->data['entry']['author_id'])->first()->email)->queue(new PostStatusUpdated($post, false));
            break;
        case 'draft':
            Post::where('id', $this->data['entry']['id'])->update(['publish_at' => null]);
            break;
        default:
        //   
      }
      // do something after save
      return $response;
    }
}
