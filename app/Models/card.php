<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class card extends Model
{
    use HasFactory;

    protected $fillable = [
        'question', 'answer', 'deck_id', 'next_review_at',
    ];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Scope for new cards (never studied)
    public function scopeNew($query)
    {
        return $query->whereDoesntHave('reviews', function ($query) {
            $query->where('studied', true);
        });
    }

    // Scope for cards to review (studied)
    public function scopeToReview($query)
    {
        return $query->whereHas('reviews', function ($query) {
            $query->where('studied', true)
                ->whereIn('score', ['easy', 'medium', 'hard']);
        });
    }
}

