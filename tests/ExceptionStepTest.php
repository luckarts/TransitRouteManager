<?php
// tests/EmailTest.php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Collections\StepsCollection;
use Exception;
/**
 * test Exception of CollectionSteps
 *
 * Class ExceptionStepTest
 * @package App\Tests
 * @covers \App\Collections\StepsCollection

 */
class ExceptionStepTest extends TestCase {

    /**
    * provide to test wrong steps

    * @return array
    */
    public static function wrongDataProvider(): array
    {
        return [
            [
                'steps' => [
                    [
                        'id'=> 2,
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
    * Exception no departure of dataset

    * @dataProvider wrongDataProvider
    * @throws Exception

    * @param array $steps
     */
    public function testItinerary(array $steps)
    {
       $this->expectException(Exception::class);
       $this->expectExceptionMessage('An error has occurred, missing departure city');
       new StepsCollection($steps);
    }

     /**
    * Exception no departure of dataset

    * @dataProvider wrongDataProvider
    * @throws Exception
     */
    public function testEmptyDataToStepsCollection()
    {
       $this->expectException(Exception::class);
       $this->expectExceptionMessage('An error has occurred, there are no steps datas');
       new StepsCollection([]);

    }


}

