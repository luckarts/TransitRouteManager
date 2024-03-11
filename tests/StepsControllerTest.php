<?php
// tests/EmailTest.php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Collections\StepsCollection;
use App\Controllers\StepsController;
use GuzzleHttp\Psr7\Response;
use Exception;

/**
 * test all function of Controller Steps
 *
 * Class StepsControllerTest
 * @package App\Tests
 * @covers \App\Controllers\StepsController
 *
 */
class StepsControllerTest extends TestCase
{

    private $stepController;
    /**
     * Setup
     */
    public function initController()
    {
        $this->stepController = new StepsController();
    }

    /**
    * provide to test Valid steps
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
                        'seat' => '45B'
                    ],

                ]
            ]

        ];
    }

    /**
    * Use Case load Steps

    * @dataProvider validStepsProvider
    * @covers \App\Controllers\StepsController::GetData
    * @param array data
     */
    public function testController($steps)
    {
        $this->initController();
        $this->assertEquals($steps, $this->stepController->getData());

    }

/**
    * Use Case find first step of the collection

    * @dataProvider validStepsProvider
    * @covers \App\Controllers\StepsController::index
    * @param array steps
     */
    public function testStepControllerReturnsCorrectItinerary($steps)
    {
        $this->initController();
        $stepsCollection = new StepsCollection($steps);
        $itinerary = $stepsCollection->createItinerary();

        $body = json_encode(['content' => $itinerary]);

        $response = new Response(
            200,
            ['Content-Type' => 'application/json'],
            $body
        );
        $expectedResponse = json_decode($response->getBody(), true);
        $actualResponse = json_decode($this->stepController->index()->getBody(), true);

        $this->assertEquals($expectedResponse,$actualResponse);
    }

    /**
     * Use Case load Steps Datas
     * @covers \App\Controllers\StepsController::index
     */
    public function testIndexWithInvalidDataPath()
    {
        // Simuler une DataPathException en mockant la méthode `getData`
        $this->stepController = $this->getMockBuilder(StepsController::class)
                                 ->onlyMethods(['getData'])
                                 ->getMock();

        $this->stepController->method('getData')->will($this->throwException(new Exception("Le chemin des données est incorrect ou le fichier n'existe pas.")));

        $response = $this->stepController->index();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(404,$response->getStatusCode());
    }

    /**
     * Use Case load Steps Datas
     *
     * @throws Exception
     *
     */
    public function testGetDataFileNotFound()
    {
        $stepController = $this->createPartialMock(StepsController::class, ['exists']);

        $stepController->method('exists')->willReturn(false);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('File not found: ');

        $stepController->getData();

    }

    /**
     * Fetches data from a specific JSON file containing routes.
     *
     * Reads and decodes JSON content from a file located in a predefined directory into an associative array.
     * It's intended for use in retrieving route configurations for a navigation app or similar.
     *
     * @throws Exception If the file cannot be found, throws an exception with a message including the missing file's path for easier debugging. If the file is found but its content cannot be decoded from JSON, throws a different exception indicating an issue with JSON decoding.
     *
     * @return ?array Returns an associative array of decoded data from the JSON file if found and successfully decoded. Null may be returned in the event of an unhandled exception within the function, though exceptions should ideally be caught by the calling code to prevent unexpected null returns.
     *
     */
    public function testGetDataNullFound()
    {
        $stepController = $this->createPartialMock(StepsController::class, ['getContents']);

        $stepController->method('getContents')->willReturn('');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Failed to decode JSON from file:');

        $stepController->getData();

    }
}