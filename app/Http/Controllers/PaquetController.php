<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;

class PaquetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {   
        $userId = auth()->id();

        // Wiederherstellung des Stapels mit allen Karten
        $foundDeck = Deck::where('deleted', false)->withCount('cards')
            ->where('slug', $slug)
            ->firstOrFail();
    
        //Verwenden der Methode getUnreviewedCardsCountForUser zum Zählen nicht überprüfter Karten
        $unreviewedCardsCount = $foundDeck->getUnreviewedCardsCountForUser($userId);
    
        // Zählen Sie überarbeitete Karten
        $reviewedCardsCount = $foundDeck->getReviewedCardsCountForUser($userId);
        
        // Counting cards to review
        $toReviewCardsCount = $foundDeck->getToReviewCardsCountForUser($userId);
    
        if ($foundDeck == null) {
            return redirect()->route('revision')->with('failure', "Oups !Wir konnten das Paket nicht abrufen !");
        } else {
            return view('pages.Revision', [
                'foundDeck' => $foundDeck,
                'unreviewedCardsCount' => $unreviewedCardsCount,
                'reviewedCardsCount' => $reviewedCardsCount,
                'toReviewCardsCount' => $toReviewCardsCount,
            ]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
