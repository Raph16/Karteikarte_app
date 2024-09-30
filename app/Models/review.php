<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'card_id', 'score', 'reviewed_at', 'studied',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    // Update the next review date based on the score
    public static function updateNextReview(Card $card, $score)
    {
        $now = Carbon::now();
        $nextReviewAt = $now;

        switch ($score) {
            case 'easy':
                $nextReviewAt->addDays(7); // Example: 7 days for easy
                break;
            case 'medium':
                $nextReviewAt->addDays(3); // Example: 3 days for medium
                break;
            case 'hard':
                $nextReviewAt->addDay(); // Example: 1 day for hard
                break;
        }

        // Create or update the review record
        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'card_id' => $card->id],
            ['score' => $score, 'reviewed_at' => $nextReviewAt, 'studied' => true]
        );

        // Update the next review date on the card
        $card->next_review_at = $nextReviewAt;
        $card->save();
    }
}

