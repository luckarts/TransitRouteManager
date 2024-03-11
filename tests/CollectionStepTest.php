<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Collections\StepsCollection;
use App\Models\Step;

/**
 * test all function of CollectionSteps
 *
 * Class CollectionStepTest
 *
 * @package App\Tests
 * @covers \App\Models\Step
 * @covers \App\Collections\StepsCollection
 *
 */
class CollectionStepTest extends TestCase {

    /**
    * provide to test Valid datas Steps

    * @return array
    */
    public static function validStepsProvider(): array
    {
        return [
            [
                'steps' => [
                    [
                        'id'=> 1,
                        'departure' => 'Aéroport de Barcelone',
                        'arrival' => 'Aéroport de Gérone',
                        'transport' => 'Bus',
                        'seat' => 'N/A'
                    ],
                    [
                        'id' => 4,
                        'departure' => "Stockholm",
                        'arrival' => 'New York JFK',
                        'transport' => 'Vol SK22',
                        'seat'=> '7B',
                        'baggage' => 'Transférés automatiquement'
                    ],
                    [
                        'id'=> 3,
                        'departure' => 'Aéroport de Gérone',
                        'arrival' => 'Stockholm',
                        'transport' => 'Vol SK455',
                        'seat' => '3A',
                        'baggage'=> 'Guichet 344'
                    ],
                    [
                        'id'=> 2,
                        'departure' => 'Madrid',
                        'arrival' => 'Barcelone',
                        'transport' => 'Train 78A',
                        'seat' => '45B',

                    ],

                ]
            ]

        ];
    }

    /**
    * Use Case create itinerary
    *
    * @dataProvider validStepsProvider
    * @covers \App\Collections\StepsCollection::createItinerary
    * @param array $steps

     */
    public function testCreateItinerary(array $steps)
    {
       $steps = new StepsCollection($steps);

       $itinerary = $steps->createItinerary();
       $this->assertEquals('Madrid', $itinerary[0]->getDeparture());
    }

    /**
     * Use Case find first step of the collection check valid data
     *
     * @dataProvider validStepsProvider
     * @covers \App\Collections\StepsCollection::findDeparture
     * @covers \App\Models\Step::getArrival
     * @covers \App\Models\Step::getTransport
     * @covers \App\Models\Step::getSeat
     * @covers \App\Models\Step::getId
     * @covers \App\Models\Step::getBaggage
     * @param array $steps

     */
    public function testStepModel(array $steps)
    {
       $steps = new StepsCollection($steps);

       $step = $steps->findDeparture();
       $this->assertEquals('Barcelone', $step->getArrival());
       $this->assertEquals('Train 78A', $step->getTransport());
       $this->assertEquals('45B', $step->getSeat());
       $this->assertEquals('2', $step->getId());

       $itinerary = $steps->createItinerary();

       $this->assertEquals('Guichet 344', $itinerary[2]->getBaggage());
    }

    /**
     * Provider with wrong datas to test exeception
     */
    public static function wrongDataProvider(): array
    {
        return [
            [
                'steps' => [
                    [
                        'id'=> 2,
                        'departure' => 'Aéroport de Gérone',
                        'arrival' => 'Barcelone',
                        'transport' => 'Train 78A',
                        'seat' => '45B'
                    ],
                    [
                        'id'=> 3,
                        'departure' => 'Barcelone',
                        'arrival' => 'Aéroport de Gérone',
                        'transport' => 'Vol SK455',
                        'seat' => '3A',
                        'baggages'=> 'Guichet 344'
                    ]

                ]
            ]

        ];
    }

   /**
    * Use Case don't find departure

    * @dataProvider wrongDataProvider
    * @covers \App\Collections\StepsCollection::findDeparture

    * @param array $steps
    */
    public function testFindDepartureReturnsNull($steps)
    {
           $steps = new StepsCollection($steps);
           $itinerary = $steps->createItinerary();
           $this->assertEquals([], $itinerary);
    }

    /**
     * Use Case offsetSet add new step in Collection

     * @dataProvider validStepsProvider
     * @covers \App\Collections\StepsCollection::offsetSet
     *
     * @param array $steps
     *
     */
    public function testOffsetSet($steps)
    {
        $steps = new StepsCollection($steps);
        $step = new Step();
        $steps->offsetSet(0, $step);

        $this->assertSame($step, $steps->offsetGet(0));
    }

    /**
     * Use Case OffsetUnset remove one step in Collection
     *
     * @dataProvider validStepsProvider
     * @covers \App\Collections\StepsCollection::offsetUnset
     * @param array $steps
     */
    public function testOffsetUnset($steps)
    {
        $steps = new StepsCollection($steps);
        $step = new Step();
        $steps->offsetSet(0, $step);
        $steps->offsetUnset(0);
        $this->assertNull($steps[0] ?? null);
    }

}