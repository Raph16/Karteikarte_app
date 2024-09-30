<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;

class QuizzController extends Controller
{
    //
    public function index()
    {
        $decks = Deck::all();
        return view('pages.Quizz', compact('decks'));
    }
}
