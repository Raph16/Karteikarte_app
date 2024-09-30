<div x-data="{
    startQuizz: @entangle('startQuizz'),
    score: @entangle('score'),
    loose: @entangle('loose'),
    choose: @entangle('choose'),
    totalQuestions: @entangle('totalQuestions'),
    looseQuizz: @entangle('loose'),
    answerSelected: @entangle('answerSelected'),
    selectedAnswer: null,
    quizFinished: @entangle('quizFinished'),
    nextQuestionActive: @entangle('nextQuestionBtn'),
    disabledBtn: false,
    currentIndex: 0,
    slides: @js($Decks->count()),
    countQuestions: @js(count($questions)),
    timer: null,
    countdown: @entangle('countdownTime'),
    countdownRunning: @entangle('countdownRunning'),

    next() {
        if (this.currentIndex < this.slides - 1) {
            this.currentIndex++;
        } else {
            this.currentIndex = 0;
        }
    },
    
    prev() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
        } else {
            this.currentIndex = this.slides - 1;
        }
    },

    startTimer() {
        this.resetTimer();
        this.countdownRunning = true;
        this.timer = setInterval(() => {
            if (this.countdown > 0) {
                this.countdown--;
            } else {
                clearInterval(this.timer);
                this.$wire.answer('Incorrect');
            }
        }, 1000);
    },
    
    resetTimer() {
        clearInterval(this.timer);
    },
    
    watchCountdown() {
        $watch('countdownRunning', value => {
            if (value) {
                this.startTimer();
            } else {
                this.resetTimer();
            }
        });
    }
    }" 
    x-init="() => {
        watchCountdown();
        window.addEventListener('countdownStarted', () => {
            console.log('Ereignis empfangen, Countdown beginnt');
            startTimer();
        });
    }"
    class="relative">
    @if (session()->has('success'))
        <div class="my-2 p-2 ">
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        </div>
    @endif
    @if (session()->has('ready'))
        <div class="my-2 p-2 ">
            <x-alert type="success">
                {{ session('ready') }}
            </x-alert>
        </div>
    @endif
    <div class="p-2" x-show="startQuizzShow && choose">
        <!--  Swiper -->
        <div class="container mx-auto w-2/3">
            <p class="my-2">
                <h2 class="text-white/85 font-semibold text-lg">Wählen sie eine Kategorie aus</h2>
            </p>
            <div class="mx-auto flex items-center space-x-4 p-4">
                <!-- Linke Navigationstaste -->
                <button @click="prev" class="text-blue-500 hover:text-blue-700 transition">
                    <i class="ri-arrow-left-s-line"></i>
                </button>

                <!-- Behälter für Objektträger -->
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
                        <!-- Slides -->
                        @foreach ($Decks as $Deck)
                            <div class="min-w-full flex justify-center items-center">
                                <x-action methods="startQuizz=true; choose=false; countdownRunning=true;" wMsg=false time=1000 methodeWire="loadQuestions({{ $Deck->id }});" class="px-2 py-1 border border-indigo-500 text-indigo-500 rounded-lg hover:bg-indigo-500 hover:text-white/85">
                                    {{ $Deck->name }}
                                </x-action>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button @click="next" class="text-blue-500 hover:text-blue-700 transition">
                    <i class="ri-arrow-right-s-line"></i>
                </button>
            </div>
        </div>
    </div>
    <template x-if="startQuizz && !choose && !quizFinished">
        <div x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="w-full flex items-start gap-2 mx-4 px-4 py-2 relative  border-red-600">
            <div class="p-2 w-4/5 text-white border-4 border-red-500 shadow-lg">
                <div x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                    <div class="mb-4 text-start">
                        @if($currentQuestion)
                        <div class="w-full mb-4 text-start">
                            <h4 class="text-lg font-medium text-center">{{ $currentQuestion->question }}</h4>
                            <div class="mt-4 grid grid-cols-2 gap-3 p-10" x-show="!quizFinished">
                                @foreach($multipleChoiceAnswers as $answer)
                                <button @click="nextQuestionActive=true; answerSelected=true;" 
                                    wire:click='answer("{{ $answer }}")'
                                    :disabled="answerSelected"
                                    :class="{'bg-indigo-600 text-white/90 cursor-not-allowed': answerSelected}"
                                    {{-- :class="selectedAnswer ? (selectedAnswer === "{{ $answer }}" ? 'bg-indigo-500 text-white' : '') : '' " --}}
                                    class="w-full  p-1 border border-indigo-500 text-indigo-500 rounded-lg hover:bg-indigo-500 hover:text-white/85">
                                    {{ $answer }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <p>Im Moment sind keine Fragen verfügbar.</p>
                        @endif
                    </div>
                    <div class="flex justify-between items-center" :class="{ 'flex-row-reverse': nextQuestionActive }">
                        <template x-if="!nextQuestionActive">
                            <button @click="$wire.skipQuestion()" class="capitalize my-2 px-2 py-1 border border-indigo-500 text-indigo-500 rounded-lg hover:bg-indigo-500 hover:text-white/85">
                                Überspringen
                            </button>
                        </template>
                        <template x-if="nextQuestionActive">
                            <button @click="$wire.nextQuestion()" class="capitalize my-2 px-2 py-1 border border-indigo-500 text-indigo-500 rounded-lg hover:bg-indigo-500 hover:text-white/85">
                                Next
                            </button>
                        </template>
                    </div>
                </div>
            </div>
            <div class="w-1/5 p-2 flex flex-col gap-2 border">
                <!-- Frageberichte -->
                <div>
                    <h2 class="p-1 text-md text-orange-200">Gesamt : <span x-text="totalQuestions"></span></h2>
                    <h2 class="p-1 text-md text-orange-200">Passed : <span x-text="score"></span></h2>
                    <h2 class="p-1 text-md text-orange-200">Rest : <span x-text="(totalQuestions - score) - loose"></span></h2>
                </div>
                <!-- Timer für Frage -->
               <div class="p-3 border border-dashed border-red-300 text-red-500 font-bold">
                   <i class="ri-hourglass-2-fill me-2 text-xl"></i> <span class="ml-1 text-lg" x-text="countdown + '  S'"></span>
               </div>
              
                <x-action methods="startQuizz=!startQuizz;" wMsg=false time=500 methodeWire="finishQuizz" class="px-2 py-1 border border-indigo-500 text-indigo-500 rounded-lg hover:bg-indigo-500 hover:text-white/85">
                    Abbrechen
                </x-action>
            </div>
        </div>
    </template>
    <template x-if="quizFinished">
        <div class="my-2 p-2">
            <h2 class="text-lg font-medium text-white/85 my-1 ">Quiz beendet!</h2>
            <p class="text-white/85 my-1 first-letter:capitalize">Fragen : <span class="text-indigo-500" x-text="totalQuestions"></span></p>
            <p class="text-white/85 my-1 first-letter:capitalize">richtige Antworten : <span class="text-indigo-500" x-text="score"></span></p>
            <p class="text-white/85 my-1 first-letter:capitalize">falsche Antworten : <span class="text-indigo-500" x-text="loose"></span></p>
            <p class="text-white/85 my-1 first-letter:capitalize">Erfolgsquote : <span class="text-indigo-500" x-text="(score / totalQuestions) * 100  + ' %'"></span></p>
            <p class="my-1 py-2">
                <span class="text-indigo-500 block font-semibold first-letter:font-bold" >Beobachtung</span>
                <h2 class= "text-white/85 my-1 first-letter:capitalize first-letter:text-2xl" x-text="((score / totalQuestions) * 100) < 70 ? 'du musst dich noch verbessern' : 'Glückwunsch! Du hast das Quiz bestanden' "></h2>
            </p>

            
        </div>
    </template>
</div>
