<?php

namespace App\Models\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanBeFavorited
{
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function scopeWithFavorited(Builder $query, int $userId): void
    {
        $query->withCount($this->favoritedQuery($userId));
    }

    public function loadFavorited(int $userId): void
    {
        $this->loadCount($this->favoritedQuery($userId));
    }

    protected function favoritedQuery(int $userId): array
    {
        return ['favorites as favorited' => function ($query) use ($userId){
            $query->where('user_id', $userId);
        }];
    }
}
