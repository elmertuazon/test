<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use CrudTrait, HasFactory, SoftDeletes;

    protected $table = 'tags';
    protected $guarded = ['id'];

    public function posts(): BelongsToMany
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function links(): MorphToMany
    {
        return $this->morphedByMany(Link::class, 'taggable');
    }
}
