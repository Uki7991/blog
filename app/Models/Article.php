<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Article extends Model
{
    use HasFactory;

    public static $themes = [
        'Bitcoin',
        'Litecoin',
        'Ripple',
        'Dash',
        'Ethereum',
    ];

    protected $fillable = [
        'title',
        'author',
        'description',
        'published_at',
        'content',
        'source_id',
        'url',
        'url_to_image',
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        return $query->when($request->q, function (Builder $query, $value) {
            return $query->where('title', 'like', '%'.$value.'%')
                ->orWhere('description', 'like', '%'.$value.'%');
        });
    }
}
