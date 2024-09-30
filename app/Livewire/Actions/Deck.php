<?php

namespace App\Livewire\Actions;


use App\Models\Deck as ModelsDeck;
use Livewire\Component;

class Deck extends Component
{
    public $Decks;
    public $unreviewedCardsCount;
    public function mount() {
    $userId = auth()->id();
    $this->Decks = ModelsDeck::where('deleted', false)->withCount(['cards' => function ($query) {
        $query->where('deleted', false);
    }])->get();

    // Count total unreviewed cards for each deck and sum them up
    $this->unreviewedCardsCount = $this->Decks->sum(function ($deck) use ($userId) {
        return $deck->getUnreviewedCardsCountForUser($userId);
    });
}
    public function freshDecks() {
        $this->Decks = ModelsDeck::where('deleted',false)->withCount(['cards' => function ($query) {
            $query->where('deleted', false);
        }])->get();
    }
    public function loadCardsUnreview() {
        $this->freshDecks();
        $userId = auth()->id();
        return $this->unreviewedCardsCount = $this->Decks->sum(function($deck) use ($userId) {
            return $deck->getUnreviewedCardsCountForUser($userId);
        });
    }

    public function deleteDeck($id){
        $deck = ModelsDeck::where('user_id',auth()->id())->find($id);
        if($deck == null){
            session()->flash('Failled', "Oups ! Wir haben das Paket für diesen Vorgang nicht wiederherstellrn können. ");
        }else{
            // dd($deck);
            $deck->deleted= true;
            $result = $deck->save();
            if($result){
                $this->freshDecks();
                session()->flash('success',"Stapel `$deck->name` erfolgreich gelöscht.");
                // $this->dispatchBrowserEvent ('deckDeleted', $deck->name);
            }else{
                session()->flash('Failled', "Paket konnte nicht entfernt werden `$deck->name`.");
            }
        }
    }
    public function render()
    {
        return view('livewire.pages.paquets.table');
    }
}