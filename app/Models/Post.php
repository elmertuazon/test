<?php

namespace App\Models;

use App\Mail\PostStatusUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;

class Post extends Model
{
    use CrudTrait, HasFactory, SoftDeletes;

    protected $guarded = ['id'];


    protected $casts = [
        'publish_at' => 'datetime',
    ];


    public static function booted()
    {
        static::updated(function(Post $post) {
            if($post->status !== 'draft' && array_key_exists('status', $post->getDirty())) {
                Mail::to($post->author)->queue(new PostStatusUpdated($post));
            }
        });
    }

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

    // Methods
    public function tagsAsLinks()
    {
        return $this->tags->map(function ($tag) {
            return '<a href="' . route('tag.show', $tag) . '">#' . $tag->name . '</a>';
        })->implode(', ');
    }

    public function scopePublished($query)
    {
        return $query->where('publish_at', '<=', now());
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function setImageAttribute($image): void
    {
        $this->attributes['image'] = $image->store('uploads');
    }
}
