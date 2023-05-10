<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';
    protected $guarded = ['id'];

    public function category(): HasOne
    {
        return  $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'pivot_post_and_tag', 'post_id', 'tags_id');
    }
}
