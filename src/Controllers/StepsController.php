<?php
namespace App\Controllers;

use App\Collections\StepsCollection;
use GuzzleHttp\Psr7\Response;
use Exception;
/**
 * Handles requests related to itinerary steps.
 *
 * @category Controller
 * @package  App\Controllers
 * @author   Display Name <username@example.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://example.com/docs/Step
 */
class StepsController
{
    /**
     * Get the itinerary data from the JSON file
     *
     * Create the itinerary collection
     *
     * @return Response
     */
    public function index()
    {
        try {

            $steps = $this->getData();
            $stepsCollection = new StepsCollection($steps);
            $itinerary = $stepsCollection->createItinerary();
            $body = json_encode(['content' => $itinerary ]);
            $response = new Response(
                200,
                ['Content-Type' => 'application/json'],
                $body
            );
            return $response;

        } catch (\Exception $e){
            // Modification ici pour renvoyer un objet Response en cas d'erreur
            $body = json_encode(['error' => $e->getMessage()]);
            $response = new Response(
                404,
                ['Content-Type' => 'application/json'],
                $body
            );
            return $response;
            }
    }


    /**
     *  Load datas fake
     * @throws Exception If the file cannot be found.
     * @return ?array
     */
    public function getData()
    {
        $pathDatas = __DIR__ . "/../data/itineraires.json";
        if (!$this->exists($pathDatas)) {
            throw new Exception('File not found: ' . $pathDatas);
        }
        $data = json_decode($this->getContents($pathDatas), true);
        if (is_null($data)) {
            throw new Exception('Failed to decode JSON from file: ' . $pathDatas);
        }
        return $data;
    }

    public function exists($path): bool {
        return file_exists($path);
    }

    public function getContents($path): string {
        return file_get_contents($path);
    }
}