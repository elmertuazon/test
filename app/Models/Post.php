<?php

namespace App\Models;

use App\Mail\PostStatusUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
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

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
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

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn ($query, $search) => 
            $query->where(fn($query) => 
                $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%')
                )
            );

        $query->when($filters['popular'] ?? false, fn ($query) => 
            $query->where(fn($query) => 
                $query->orderBy('popularity')
            )
        );

        $query->when($filters['favorite'] ?? false, fn ($query) => $query
            ->whereHas('favorites', fn ($query) =>
                $query->where('is_favorite', true)
            )
        );
    }

    public function scopePublished($query)
    {
        return $query->where('publish_at', '<=', now());
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeMonthlyPublished($query, $request)
    {
        return $query->when($request->has('month'), function($posts) use($request){
            [$searchYear, $searchMonth] = explode('-', $request->input('month'));

            $posts->whereYear('publish_at', (int) $searchYear)->whereMonth('publish_at', (int) $searchMonth);
        });
    }

    public function setImageAttribute($image): void
    {
        $this->attributes['image'] = $image->store('uploads');
    }

    public function setPasswordAttribute($password): void
    {
        $this->attributes['passowrd'] = Hash::make($password);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
