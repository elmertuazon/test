<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use CrudTrait, HasFactory, SoftDeletes;

    protected $guarded = ['id'];


    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function path()
    {
        return "/categories/{$this->slug}";
    }
}
