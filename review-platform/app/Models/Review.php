<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'sentiment',
        'score',
        'topics',
    ];

    protected $casts = [
        'topics' => 'array',
        'score' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePositive(Builder $query): Builder
    {
        return $query->where('sentiment', 'positive');
    }

    public function scopeNegative(Builder $query): Builder
    {
        return $query->where('sentiment', 'negative');
    }

    public function scopeNeutral(Builder $query): Builder
    {
        return $query->where('sentiment', 'neutral');
    }

    public function scopeBetweenDates(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeScoreRange(Builder $query, int $min, int $max): Builder
    {
        return $query->whereBetween('score', [$min, $max]);
    }
}
