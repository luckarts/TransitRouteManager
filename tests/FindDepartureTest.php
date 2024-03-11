<?php
// tests/EmailTest.php
namespace App\Tests;

use PHPUnit\Framework\TestCase;

/**
 *  test find Collection
 */
class FindDepartureTest extends TestCase {

    /**
    * provide to test Valid datas
    * @return array
    */
    public static function validStepsProvider(): array
    {
        return [
            [
                'datas' => [
                    [
                        'id'=> 1,
                        'departure' => 'Barcelone',
                        'arrival' => 'Aéroport de Gérone',
                        'transport' => 'Bus',
                        'seat' => 'N/A'
                    ],
                    [
                        'id'=> 2,
                        'departure' => 'Madrid',
                        'arrival' => 'Barcelone',
                        'transport' => 'Train 78A',
                        'seat' => '45B'
                    ],
                    [
                        'id'=> 3,
                        'departure' => 'Aéroport de Gérone',
                        'arrival' => 'Stockholm',
                        'transport' => 'Vol SK455',
                        'seat' => '3A',
                        'baggages'=> 'Guichet 344'
                    ]

                ]
            ]

        ];
    }

    /**
    * @test
    * Use Case find first step of the collection
    * @dataProvider validStepsProvider
    * @param array steps
     */
    public function testFindDeparture(array $datas)
    {
       $stepDeparture = $this->findDeparture($datas);
       $this->assertEquals('Madrid', $stepDeparture['departure']);
    }
    /**
     * @test
     * Use Case find Next step
     * @dataProvider validStepsProvider
     */
    public function testFindNextStep(array $datas)
    {
        $stepDeparture = $this->findDeparture($datas);
        $nextStep = $this->findNextStep($datas, $stepDeparture);
        $this->assertEquals('Barcelone', $nextStep['departure']);
    }
    /**
     * @test
     * UseCase create itinary
     * @dataProvider validStepsProvider
     */
    public function testcreateItinerary(array $data)
    {
         $itinary = $this->createItinerary($data);
         $this->assertEquals('Aéroport de Gérone', $itinary[2]["departure"]);

    }
    /**
     * extract city from the source
     */
    public function extractCity(string $city): string
    {
        return preg_replace('/^Aéroport de /','',$city);
    }
    /**
     * find first step of the collection
     * @param array steps
     * @return array step
     */
    public function findDeparture(array $steps): array
    {
        // Crée un tableau des villes d'arrivée normalisées
        $arrivalsCities = array_map(function($step) {
            return $this->extractCity($step['arrival']);
        }, $steps);

        // Parcourt chaque étape une seule fois
        foreach ($steps as $step) {
            // Vérifie si la ville de départ n'est pas dans le tableau des arrivées
            if (!in_array($this->extractCity($step['departure']), $arrivalsCities)) {
                return $step; // Retourne immédiatement l'étape de départ trouvée
            }
        }

    return []; // Retourne un tableau vide si aucun départ n'est trouvé

    }

    /**
     * Trouve l'étape suivante dans l'itinéraire en se basant sur l'arrivée de l'étape actuelle.
     *
     * Cette méthode compare la ville d'arrivée de l'étape actuelle avec les villes de départ
     * des autres étapes pour trouver la correspondance suivante. La comparaison tient compte
     * de la normalisation des noms des villes pour assurer la cohérence, même en présence
     * de variations dans le formatage des noms.
     *
     * @param array $steps Les étapes de l'itinéraire sous forme d'un tableau d'associations.
     * @param array $stepDeparture L'étape actuelle à partir de laquelle trouver l'étape suivante.
     * @return array|null L'étape suivante si trouvée, sinon null.
     */
    public function findNextStep(array $steps, array $stepDeparture): ?array
    {
        foreach($steps as $step){
            if($this->extractCity($step['departure']) === $this->extractCity($stepDeparture['arrival'])) return $step;
        }
    return null;
    }

    /**
     * Crée un itinéraire complet à partir d'un ensemble désordonné d'étapes.
     *
     * Cette méthode commence par trouver l'étape de départ en utilisant `findDeparture`.
     * Ensuite, elle construit l'itinéraire en trouvant successivement chaque étape suivante
     * jusqu'à ce qu'il n'y ait plus d'étapes suivantes à ajouter. L'itinéraire est construit
     * de manière à suivre l'ordre logique de déplacement d'une étape à l'autre.
     *
     * @param array $steps Les étapes de l'itinéraire sous forme d'un tableau d'associations.
     * @return array L'itinéraire complet, ordonné du départ à l'arrivée.
     */
    public function createItinerary($steps): array
    {
        $stepDeparture = $this->findDeparture($steps);
        $itinary[] = $stepDeparture;
        while($stepDeparture !== null)
        {
            $stepDeparture = $this->findNextStep($steps, $stepDeparture);
            if($stepDeparture !== null) $itinary[] = $stepDeparture ;
        }
        return $itinary;
    }

}