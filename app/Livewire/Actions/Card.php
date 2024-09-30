<?php

namespace App\Livewire\Actions;

use App\Models\Card as ModelsCard;
use Livewire\Component;
use Livewire\WithPagination;

class Card extends Component
{
    use WithPagination;

    public $perPage = 7;
    public $total;
    // public $Cards;

    protected $paginationTheme = 'tailwind'; //Verwenden Sie Tailwind CSS, um die Paginierung zu formatieren

    public function mount()
    {
        $this->freshCards();
        $cards = ModelsCard::select('cards.id as card_code', 'cards.question', 'cards.answer', 'decks.name as deck_name', 'decks.description as deck_describe', 'users.name as deck_author')
        ->join('decks', 'cards.deck_id', '=', 'decks.id')
        ->join('users', 'users.id', '=', 'decks.user_id')
        ->where('cards.deleted', false);
        $this->total = $cards->count();
    }

    public function freshCards()
    {
        $this->resetPage();
        $cards = ModelsCard::select('cards.id as card_code', 'cards.question', 'cards.answer', 'decks.name as deck_name', 'decks.description as deck_describe', 'users.name as deck_author')
        ->join('decks', 'cards.deck_id', '=', 'decks.id')
        ->join('users', 'users.id', '=', 'decks.user_id')
        ->where('cards.deleted', false);
        $this->total = $cards->count();
    }

    public function loadCardToEdit($id)
    {
        $foundCard = ModelsCard::find($id);
        if ($foundCard == null) {
            session()->flash('faillure', "Oups ! Wir haben die angegebene Karte nicht abrufen können.");
        } else {
            return redirect()->route('cartes', ['foundCard' => $foundCard])->with('success', "Karte abgerufen.");
        }
    }

    public function deleteCard($id)
    {
        $card = ModelsCard::find($id);
        if ($card == null) {
            session()->flash('faillure', "Oups ! Wir haben die angegebene Karte nicht abrufen können.");
        } else {
           $result = $card->delete();
            //$card->save();  
            if ($result) {
                $this->freshCards();
                session()->flash('success', "1 Karte erfolgreich gelöscht.");
            } else {
                session()->flash('failled', "Karte konnte nicht gelöscht werden.");
            }
        }
        $card = null;
    }

    public function render()
    {
        $cards = ModelsCard::select('cards.id as card_code', 'cards.question', 'cards.answer', 'decks.name as deck_name', 'decks.description as deck_describe', 'users.name as deck_author')
            ->join('decks', 'cards.deck_id', '=', 'decks.id')
            ->join('users', 'users.id', '=', 'decks.user_id')
            ->where('cards.deleted', false)
            ->paginate($this->perPage);

        return view('livewire.pages.cartes.table', ['Cards' => $cards]);
    }
}