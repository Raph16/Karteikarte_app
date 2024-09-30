<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'user_id', 'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($deck) {
            $deck->slug = Str::slug($deck->name, '-');
        });

        static::updating(function ($deck) {
            $deck->slug = Str::slug($deck->name, '-');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function getUnreviewedCardsCountForUser($userId)
    {
        return $this->cards()
            ->where('deleted', false)
            ->whereDoesntHave('reviews', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->count();
    }

    public function getReviewedCardsCountForUser($userId)
    {
        return $this->cards()
            ->where('deleted', false)
            ->whereHas('reviews', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('deleted', false)
                    ->where('studied', true)
                    ->where('reviewed_at', '<=',Carbon::now())
                    ->whereIn('score', ['easy', 'medium', 'hard']);
            })
            ->distinct('id')
            ->count();
    }
    

    public function getToReviewCardsCountForUser($userId)
    {
        return $this->cards()
            ->where('deleted', false)
            ->whereHas('reviews', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                ->where('deleted', false)
                ->where('reviewed_at', '<=',Carbon::now())
                    ->where('score', 'toreview');
            })
            ->distinct('cards.id')
            ->count();
    }

}

