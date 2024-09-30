<?php

namespace App\Livewire\Forms;

use App\Models\Deck as ModelsDeck;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Deck extends Component
{
    
    public $targetDeck;
    public $targetDeckId;
    public $Deck = [
        "name"=> "",
        "description"=> "",
        "proprietaire"=> null
    ];
    public function mount()
    {
        $this->Deck['proprietaire'] = auth()->user()->id;
        if ($this->targetDeckId) {
            $deck = ModelsDeck::find($this->targetDeckId);
            if ($deck) {
                $this->Deck['name'] = $deck->name;
                $this->Deck['description'] = $deck->description;
                $this->Deck['proprietaire'] = $deck->user_id;
            }
        }
    }

    protected  $rules = [
        'Deck.name' => 'required|min:2|string|unique:decks,name',
        'Deck.description' => 'max:255',
        'Deck.proprietaire' => 'required|exists:users,id'
    ];
    protected  $rules1 = [
        'Deck.name' => 'required|min:2|string',
        'Deck.description' => 'max:255',
        'Deck.proprietaire' => 'required|exists:users,id'
    ];

    protected $messages = [
        'Deck.name.required' => 'Bitte geben Sie den Paketnamen ein',
        'Deck.name.min' => 'Der Paketname muss mehr als 2 Zeichen enthalten',
        'Deck.name.string' => 'Der Name darf nur aus Text bestehen',
        'Deck.name.unique' => 'Ein Paket mit diesem Namen existiert bereits',
        'Deck.proprietaire.required' => 'Besitzer nicht gefunden',
        'Deck.proprietaire.exists' => 'Der angegebene Besitzer existiert nicht'
    ];

    public function loadDeck(){
        return redirect()->route('cartes');
    }
    public function clearForm(){
        $this->Deck['name'] = "";
        $this->Deck['description'] = "";

    }
    

    public function saveDeck(){
        if ($this->targetDeckId) {
            $validatedData = $this->validate($this->rules1,$this->messages);
            $deck = ModelsDeck::find($this->targetDeckId);
            $deck->name = $validatedData['Deck']['name'];
            $deck->description = $validatedData['Deck']['description'];
            $deck->user_id = $validatedData['Deck']['proprietaire'];
            $deck->save();

            session()->flash('success', "Stapel `{$this->Deck['name']}` erfolgreich aktualisiert.");
            $this->resetForm();
            // $this->dispatchBrowserEvent('deckUpdated',$this->Deck['name']);
        } else {
            $validatedData = $this->validate();
            $deck = ModelsDeck::updateOrCreate([
                'name' => $validatedData['Deck']['name'],
                'description' => $validatedData['Deck']['description'],
                'user_id' => $validatedData['Deck']['proprietaire']
            ]);

            if ($deck->wasRecentlyCreated) {
                session()->flash('success', "Stapel `{$this->Deck['name']}` erfolgreich erstellt.");
                $this->resetForm();
                // $this->dispatchBrowserEvent('deckCreated', $deck);
            } else {
                session()->flash('error', "Wir konnten das Paket nicht aktualisieren.");
            }
        }
    }

    private function resetForm()
    {
        $this->Deck['name'] = '';
        $this->Deck['description'] = '';
    }


    public function render()
    {
        return view('livewire.pages.paquets.add');
    }
}