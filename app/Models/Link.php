<?php

namespace App\Models;

use App\Mail\PostStatusUpdated;
use App\Models\Traits\CanBeFavorited;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

class Link extends Model
{
    use CrudTrait, HasFactory, SoftDeletes;
    use CanBeFavorited;

    protected $guarded = ['id'];

    protected $casts = [
        'publish_at' => 'datetime',
        'favorited' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
        $query->when($filters['search'] ?? false, fn($query, $search) => $query->where(fn($query) => $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('body', 'like', '%' . $search . '%')
        )
        );
        $query->when($filters['popular'] ?? false, fn($query) => $query->orderBy('popularity', 'desc')
        );

        $query->when($filters['favorite'] ?? false, fn($query) => $query
            ->whereHas('favorites', fn($query) => $query->where('user_id', auth()->id())
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

    public function scopeMonthlyPublished(Builder $query, string $searchYear, string $searchMonth): void
    {
        $query->whereYear('publish_at', $searchYear)->whereMonth('publish_at', $searchMonth);
    }

    public function setImageAttribute($image): void
    {
        $this->attributes['image'] = $image->store('uploads');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags(): BelongsToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
