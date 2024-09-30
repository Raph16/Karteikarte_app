<?php

namespace App\Livewire\Forms;

use App\Models\card as ModelsCard;
use App\Models\Deck;
use Livewire\Component;

class Card extends Component
{
    public $targetCardId;
    public $Decks;
    public $Card = [
        "question" => "",
        "answer" => "",
        "paquet" => "",
        "type" => ""
    ];
    public $cardTypes = [
        ['type' => 'basique'],
        ['type' => 'carte inversée'],
        ['type' => 'texte à trous'],
    ];
    
    public function mount()
    {
        // $this->cardTypes = ModelsCard::get(['type']);
        $this->loadDecks();
        if ($this->targetCardId) {
            $card = ModelsCard::where('deleted',false)->find($this->targetCardId);
            if ($card) {
                $this->Card['question'] = $card->question;
                $this->Card['answer'] = $card->answer;
                $this->Card['paquet'] = $card->deck_id;
                $this->Card['type'] = $card->type;
            }
        }
    }

    public function loadDecks()
    {
        $this->Decks = Deck::where('deleted', false)->get(['id', 'name']);
    }

    public function clearForm(){
        $this->Card = [
            "question" => "",
            "answer" => "",
            "paquet" => "",
            "type" => "",
        ];
        $this->targetCardId = null;
    }
    public function loadCard($id)
    {
        $card = ModelsCard::findOrFail($id);
        $this->Card = $card->toArray();
        $this->targetCardId = $card->id;
    }

    protected $rules = [
        'Card.question' => 'required',
        'Card.answer' => 'required|string',
        'Card.paquet' => 'required|exists:decks,id',
        'Card.type' => 'required|in:basique,carte inversée,texte à trous',
    ];
    protected $rules1 = [
        'Card.question' => 'required',
        'Card.answer' => 'required|string',
        'Card.paquet' => 'required|exists:decks,id',
        'Card.type' => 'required|in:basique,carte inversée,texte à trous',
    ];
    protected $messages = [
        'Card.question.required'=> "Bitte geben Sie eine Frage ein",
        'Card.answer.required'=> "Bitte geben Sie die Kartenantwort ein",
        'Card.answer.string'=> "Die Kartenantwort darf nur aus Text bestehen",
        'Card.paquet.required'=> "Bitte wählen Sie das Kartenpaket aus",
        'Card.paquet.exists'=> "Das ausgewählte Paket existiert nicht",
        'Card.type.required'=> "Bitte wählen Sie den Kartentyp aus",
        'Card.type.in'=> "Der Kartentyp kann nur diese Werte annehmen (Basic, Reverse Card, Lücken Text)",
    ];
    public function saveCard()
    {
        
        if ($this->targetCardId) {
            $validatedData = $this->validate($this->rules1,$this->messages);
            $card = ModelsCard::findOrFail($this->targetCardId);
            $editedCard = $card->update($validatedData['Card']);
            if($editedCard){
                session()->flash('success', "Karte erfolgreich aktualisiert.");
                $this->resetForm();
                $this->loadDecks();
            }else{
                session()->flash('error', "Diese Karte konnte nicht aktualisiert werden.");
            }
        } else {
            $validatedData = $this->validate();
            $createdCard = ModelsCard::updateOrCreate([
                'question' => $validatedData['Card']['question'],
                'answer' => $validatedData['Card']['answer'],
                'type' => $validatedData['Card']['type'],
                'deck_id' => $validatedData['Card']['paquet']
            ]);

            if($createdCard->wasRecentlyCreated){
                session()->flash('success', "Karte erfolgreich erstellt");
                $this->resetForm();
                $this->loadDecks();

            }else{
                session()->flash('error', "Diese Karte kann nicht erstellt werden.");
            }
        }
    }

    private function resetForm(){
        $this->Card = [
            "question" => "",
            "answer" => "",
            "paquet" => "",
            "type" => "",
        ];
        $this->targetCardId = null;
    }

    public function deckCreated($deckId)
    {
        $this->loadDecks();
        $this->Card['paquet'] = $deckId;
    }

    public function render()
    {
        return view('livewire.pages.cartes.add');
    }
}

