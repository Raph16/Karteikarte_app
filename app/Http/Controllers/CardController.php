<?php

namespace App\Http\Controllers;

use App\Models\card;
use App\Models\Deck;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('pages.Cartes');
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $cardTypes = [
            ['key' => 'basique', 'value' => 'Basic'],
            ['key' => 'carte inversée', 'value' => 'Umgedrehte Karte'],
            ['key' => 'texte à trous', 'value' => 'Lücken Text'],
        ];
        $Decks = Deck::where('deleted', false)->get(['id', 'name']);
       
        if($id == null ){
            return redirect()->route('cartes')->with('Failled', "Oup ! Karte nicht erstellt.");
        }else{
            $foundCard = card::find($id);
            // dd($cibleCard);
            if($foundCard == null){
                return redirect()->route('cartes')->with('Failled', "Die angegebene Karte wurde nicht gefunden.");
            }else{
                return view('pages.Cartes',compact(['foundCard','cardTypes','Decks']));
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
