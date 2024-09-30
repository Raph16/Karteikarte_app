<?php

namespace App\Livewire\Actions;

use Livewire\Component;
use App\Models\Deck;
use App\Models\card as ModelCard;
use App\Models\Review;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CardReview extends Component
{
    public $deckSlug;
    public $filter = 'unreviewed';
    public $Deck;
    public $FoundCards = [];
    public $unReviewedCard= 0;
    public $unreviewedCount= 0;
    public $reviewedCard= 0;
    public $toReviewCount= 0;
    public $toReviewedCard= 0;
    public $reviewedCount= 0;
    public $currentCardIndex = 0;
    protected $msg;
    public $totalCardDisponible;
    

    public function mount($deckSlug, $filter)
    {
        $this->deckSlug = $deckSlug;
        $this->filter = $filter;
        $this->loadDeck();
        // dd($this->Deck);
        $this->loadCards();
        $this->loadCardsCount();
    }
    public function loadDeck()
    {
        $this->Deck = Deck::where('deleted', false)->where('slug', $this->deckSlug)->firstOrFail();
    }

    public function loadCards()
    {
        $userId = Auth::id();
        $now = Carbon::now();
        // dd($now);

        $query = ModelCard::where('deleted', false)->where('deck_id', $this->Deck->id);

        switch ($this->filter) {
            case 'reviewed':
                $query->where('deleted', false)
                ->whereHas('reviews', function ($subQuery) use ($userId) {
                    $subQuery->where('user_id', $userId)
                    ->where('deleted', false)
                    ->where('studied', true)
                    ->where('reviewed_at', '<=', Carbon::now())
                    ->whereIn('score', ['easy', 'medium', 'hard']);
                })->distinct('id');
                break;

            case 'unreviewed':
                $query->whereDoesntHave('reviews', function ($subQuery) use ($userId) {
                    $subQuery->where('user_id', $userId);
                });
                break;

            case 'toreview':
                $query->where('deleted', false)
                ->whereHas('reviews', function ($subQuery) use ($userId) {
                    $subQuery->where('user_id', $userId)
                    ->where('score', 'toreview')
                    ->where('reviewed_at', '<=',Carbon::now());
                })->distinct('cards.id');
                break;
        }

        $this->FoundCards = $query->get()->toArray();
        $this->loadCardsCount();
    }

    public function loadCardsCount(){
        $this->unReviewedCard =$this->Deck->getUnreviewedCardsCountForUser(auth()->id());
        $this->reviewedCard =$this->Deck->getReviewedCardsCountForUser(auth()->id());
        $this->toReviewedCard =$this->Deck->getToReviewCardsCountForUser(auth()->id());
        $this->totalCardDisponible = $this->unReviewedCard + $this->reviewedCard + $this->toReviewedCard;
    }


    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->refresh();
        // dd($this->filter);
        $this->currentCardIndex = 0;
        $this->loadDeck();
        $this->loadCards();
        $this->loadCardsCount();
    }
    public function refresh(){
        $this->loadCards();
        $this->loadCardsCount();
        $this->currentCardIndex = 0;
    }
    public function markCardAsReviewed($score)
    {
        $userId = Auth::id();
        $cardData = $this->FoundCards[$this->currentCardIndex];
        $card = ModelCard::where('deleted', false)->find($cardData['id']);
    
        if ($card) {
            Review::updateNextReview($card, $score);
            $this->currentCardIndex++;
            $this->refresh();
            $this->loadCards();
            $this->loadCardsCount();
            session()->flash('success', "Diese Karte wurde bewertet << $score >> .");
        } else {
            $this->msg= "Karte nicht gefunden !";
        }
        session()->flash('Failled', "Wir konnten diese Karte nicht bewerten.  $this->msg ?? : '!' ");
    }

    
    public function render()
    {
        $this->refresh();
        $this->loadCardsCount();
        return view('livewire.pages.cartes.card-review');
    }
}
