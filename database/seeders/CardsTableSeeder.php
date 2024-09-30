<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $decks = [
            'sciences' => 1, 
            'sport' => 2,
            'nature' => 3,
            'histoire' => 4,
        ];

        $cards = [
            [
                'question' => 'Wie lautet die chemische Formel von Wasser?',
                'answer' => 'H2O',
                'type' => 'basique',
                'deck_id' => $decks['sciences'],
            ],
            [
                'question' => 'Welcher Planet ist der Sonne am nächsten?',
                'answer' => 'Mercure',
                'type' => 'basique',
                'deck_id' => $decks['sciences'],
            ],
            [
                'question' => 'Was ist die Grundeinheit des Lebens?',
                'answer' => 'La cellule',
                'type' => 'basique',
                'deck_id' => $decks['sciences'],
            ],
            [
                'question' => 'Was ist das am häufigsten vorkommende Element im Universum?',
                'answer' => 'L\'hydrogène',
                'type' => 'basique',
                'deck_id' => $decks['sciences'],
            ],
            [
                'question' => 'Wie groß ist die Lichtgeschwindigkeit?',
                'answer' => '299 792 458 m/s',
                'type' => 'basique',
                'deck_id' => $decks['sciences'],
            ],
            [
                'question' => 'Was ist Boltzmanns Konstante?',
                'answer' => '1.380649 × 10^-23 J/K',
                'type' => 'basique',
                'deck_id' => $decks['sciences'],
            ],
            [
                'question' => 'Was ist der Energieerhaltungssatz?',
                'answer' => 'Energie kann weder erzeugt noch zerstört werden, sondern nur ihre Form ändern.',
                'type' => 'basique',
                'deck_id' => $decks['sciences'],
            ],
            [
                'question' => 'Wie lautet Newtons Kraftformel?',
                'answer' => 'F = m × a',
                'type' => 'basique',
                'deck_id' => $decks['sciences'],
            ],
            [
                'question' => 'Was ist der größte Ozean der Erde?',
                'answer' => 'L\'océan Pacifique',
                'type' => 'basique',
                'deck_id' => $decks['nature'],
            ],
            [
                'question' => 'Was ist der höchste Baum der Welt?',
                'answer' => 'Le séquoia',
                'type' => 'basique',
                'deck_id' => $decks['nature'],
            ],
            [
                'question' => 'Was ist die Nationalblume Frankreichs?',
                'answer' => 'Le lys',
                'type' => 'basique',
                'deck_id' => $decks['nature'],
            ],
            [
                'question' => 'Was ist das schnellste Landtier?',
                'answer' => 'Le guépard',
                'type' => 'basique',
                'deck_id' => $decks['nature'],
            ],
            [
                'question' => 'Was ist die größte Wüste der Welt?',
                'answer' => 'Le Sahara',
                'type' => 'basique',
                'deck_id' => $decks['nature'],
            ],
            [
                'question' => 'Was ist die am häufigsten ausgeübte Sportart der Welt?',
                'answer' => 'Le football',
                'type' => 'basique',
                'deck_id' => $decks['sport'],
            ],
            [
                'question' => 'Wer hat die meisten Grand-Slam-Titel im Tennis gewonnen?',
                'answer' => 'Roger Federer',
                'type' => 'basique',
                'deck_id' => $decks['sport'],
            ],
            [
                'question' => 'Welches Team hat 2018 die FIFA-Weltmeisterschaft gewonnen?',
                'answer' => 'Das französische Team',
                'type' => 'basique',
                'deck_id' => $decks['sport'],
            ],
            [
                'question' => 'Was ist der Weltrekord über 100 Meter?',
                'answer' => '9,58 Sekunden',
                'type' => 'basique',
                'deck_id' => $decks['sport'],
            ],
            [
                'question' => 'Was ist das prestigeträchtigste Sandplatz-Tennisturnier?',
                'answer' => 'Roland-Garros',
                'type' => 'basique',
                'deck_id' => $decks['sport'],
            ],
            [
                'question' => 'Wer war der erste Präsident der Vereinigten Staaten?',
                'answer' => 'George Washington',
                'type' => 'basique',
                'deck_id' => $decks['histoire'],
            ],
            [
                'question' => 'In welchem ​​Jahr fand die Französische Revolution statt?',
                'answer' => '1789',
                'type' => 'basique',
                'deck_id' => $decks['histoire'],
            ],
            [
                'question' => 'Welches Reich baute das Kolosseum?',
                'answer' => 'Das Römische Reich',
                'type' => 'basique',
                'deck_id' => $decks['histoire'],
            ],
            [
                'question' => 'Wie heißt das Schiff, das die Pilger im Jahr 1620 nach Amerika brachte?',
                'answer' => 'Le Mayflower',
                'type' => 'basique',
                'deck_id' => $decks['histoire'],
            ],
            [
                'question' => 'Welches Ereignis löste den Ersten Weltkrieg aus?',
                'answer' => 'Die Ermordung von Erzherzog François-Ferdinand',
                'type' => 'basique',
                'deck_id' => $decks['histoire'],
            ],
        ];
        // Additional cards for the 'sport' deck
        $cards[] = [
            'question' => 'Was ist die längste Laufstrecke der Welt?',
            'answer' => 'Die 100 Kilometer',
            'type' => 'basique',
            'deck_id' => $decks['sport'],
        ];

        $cards[] = [
            'question' => 'Was ist der größte Rugby-Wettbewerb der Welt?',
            'answer' => 'Die Rugby-Weltmeisterschaft',
            'type' => 'basique',
            'deck_id' => $decks['sport'],
        ];

        $cards[] = [
            'question' => 'Was ist der höchste Berg der Welt?',
            'answer' => 'K2 (Mount Everest)',
            'type' => 'basique',
            'deck_id' => $decks['nature'],
        ];

        // Additional cards for the 'nature' deck
        $cards[] = [
            'question' => 'Was ist der größte Fluss der Welt?',
            'answer' => 'Der Nil',
            'type' => 'basique',
            'deck_id' => $decks['nature'],
        ];

        $cards[] = [
            'question' => 'Was ist der größte Wald der Welt?',
            'answer' => 'Der Amazonas',
            'type' => 'basique',
            'deck_id' => $decks['nature'],
        ];

        // Additional cards for the 'histoire' deck
        $cards[] = [
            'question' => 'Was ist die größte Zivilisation der Antike?',
            'answer' => 'Das Römische Reich',
            'type' => 'basique',
            'deck_id' => $decks['histoire'],
        ];

        $cards[] = [
            'question' => 'Was ist der größte Krieg der Geschichte?',
            'answer' => 'Der Große Krieg',
            'type' => 'basique',
            'deck_id' => $decks['histoire'],
        ];
    
        foreach ($cards as $card) {
            DB::table('cards')->insert([
                'question' => $card['question'],
                'answer' => $card['answer'],
                'type' => $card['type'],
                'deck_id' => $card['deck_id'],
                'deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            echo "Card inserted: " . $card['question'] . "\n";
        }
    }
}
