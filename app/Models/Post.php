<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Post extends Model
{
    use CrudTrait, HasFactory;

    protected $guarded = ['id'];

    public function category(): BelongsTo
    {
        return  $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function findByTagId(Tag $tag): LengthAwarePaginator
    {
        return self::select('posts.*')
        ->join('post_tag', 'post_tag.post_id', '=', 'posts.id')
        ->where('post_tag.tag_id', $tag->id)
        ->paginate(config('blog.posts_per_page'));
    }
}
