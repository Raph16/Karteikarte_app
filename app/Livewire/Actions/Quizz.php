<?php

namespace App\Livewire\Actions;

use App\Models\card;
use App\Models\Deck;
use Livewire\Component;

class Quizz extends Component
{
    public $selectedDecks;
    public $questions = [];
    public $totalQuestions;
    public $Decks;
    public $currentQuestionIndex = 0;
    public $multipleChoiceAnswers = [];
    public $score = 0;
    public $loose = 0;
    public $currentQuestion = null;
    public $startQuizz = false;
    public $choose = true;
    public $answerSelected = false;
    public $selectedQuizPackId;
    public $quizFinished = false;
    public $nextQuestionBtn = false;
    public $consecutiveWins = 0;
    public $countdownTime = 25; 
    public $countdownRunning = false;
    public $skippedQuestions = [];


    public function mount()
    {
        $this->loadDecks();
        // $this->startCountdown();
    }

    public function loadDecks()
    {
        $this->Decks = Deck::where('deleted', false)
            ->whereHas('cards', function ($query) {
                $query->where('deleted', false);
            })->get();
    }

    public function loadQuestions($deckId)
    {
        $this->questions = card::where('deleted', false)
            ->where('deck_id', $deckId)
            ->get()
            ->shuffle()
            ->take(15);

        if ($this->questions->isEmpty()) {
            session()->flash('error', 'Für dieses Paket sind keine Fragen verfügbar.');
            return;
        }

        $this->currentQuestionIndex = 0;
        $this->quizFinished = false;
        $this->startQuizz = true;
        $this->choose = false;
        $this->score = 0; 
        $this->loose = 0;
        $this->totalQuestions = count($this->questions);
        $this->loadCurrentQuestion();
    }

    public function loadCurrentQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questions)) {
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
            $this->loadMultipleChoiceAnswers();
        } else {
            $this->finishQuizz();
        }
    }

    public function loadMultipleChoiceAnswers()
    {
        if (empty($this->currentQuestion)) {
            return;
        }

        $question = $this->currentQuestion;
        $deckId = $question->deck_id;
        $this->answerSelected = false;

        // Fetch other answers from the same deck
        $otherAnswers = card::where('deleted', false)
            ->where('deck_id', $deckId)
            ->where('id', '!=', $question->id)
            ->inRandomOrder()
            ->take(3)
            ->pluck('answer')
            ->toArray();

        // Add the correct answer
        $choices = array_merge([$question->answer], $otherAnswers);

        // Shuffle the answers
        shuffle($choices);

        $this->multipleChoiceAnswers = $choices;
    }

    // Add a new method to handle the countdown
    public function startCountdown($rebour)
    {
        $this->countdownTime = $rebour;
        $this->countdownRunning = true;
    }

    public function skipQuestion()
    {
        $this->nextQuestionBtn = false;
        $this->countdownRunning = false; // Stop the countdown
        $this->skippedQuestions[] = $this->questions[$this->currentQuestionIndex];
        // $questions = $this->questions->toArray();
        $this->questions->splice($this->currentQuestionIndex, 1);
        // dump($this->questions);
        $this->questions[] = end($this->skippedQuestions);

        // Charger la question suivante
        if ($this->currentQuestionIndex < count($this->questions)) {
            $this->loadCurrentQuestion();
            $this->startCountdown(10);
        } else {
            $this->finishQuizz();
        }
    }

    public function answer($selectedAnswer)
    {
        $this->countdownRunning = false; // Stop the countdown
        $correctAnswer = $this->currentQuestion->answer;

        if ($this->quizFinished) {
            return;
        }


        if ($selectedAnswer == $correctAnswer) {
            $this->score++;
        } else {
            $this->loose++;
        }
        if(!$this->nextQuestionBtn){
            $this->nextQuestion();
        }
    }

    public function nextQuestion()
    {
        $this->currentQuestionIndex++;

        if ($this->currentQuestionIndex < count($this->questions)) {
            $this->loadCurrentQuestion();
              $this->startCountdown(25);
              $this->dispatch('countdownStarted');
              $this->nextQuestionBtn = false;
              $this->answerSelected = false;
        } else {
            $this->finishQuizz();
        }
    }
    public function finishQuizz()
    {
        $this->quizFinished = true;
        $this->startQuizz = false;
        $this->choose = true;
        $this->totalQuestions = count($this->questions);
        if ($this->totalQuestions > 0) {
            $percentage = ($this->score / $this->totalQuestions) * 100;

            // Überprüfen Sie, ob der Benutzer bestanden hat oder nicht
            if ($percentage >= 70) {
                session()->flash('success', 'Glückwunsch ! Sie haben das Quiz bestanden mit einer Punktzahl von : ' . $this->score . '/' . $this->totalQuestions . ' (' . round($percentage, 2) . '%)');
                $this->consecutiveWins++;
                // Überprüfen Sie, ob der Benutzer zwei aufeinanderfolgende Tests bestanden hat
                if ($this->consecutiveWins == 2) {
                    $this->consecutiveWins=0;
                    session()->flash('ready', "Sie sind bereit für die Prüfung !");
                }
            } else {
                session()->flash('error', 'Entschuldigung, Sie haben das Quiz nicht bestanden mit einer Punktzahl von : ' . $this->score . '/' . $this->totalQuestions . ' (' . round($percentage, 2) . '%)');
            }
        } else {
            session()->flash('error', 'Keine Fragen gestellt.');
        }
    }

    public function render()
    {
        return view('livewire.actions.quizz');
    }
}
