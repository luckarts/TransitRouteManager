<?php
namespace App\Collections;

use Exception;
use App\Models\Step;

/**
 * Represents a collection of Steps.
 *
 * @category Controller
 * @package  App\Controllers
 * @author   Display Name <username@example.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://example.com/docs/Step
 */
class StepsCollection implements \ArrayAccess
{
    /**
     * @var array $steps
     */
    private $steps = array();

    /**
     * @var array $steps
     */
    private $arrivalsCities = array();

    /**
     * Constructor
     *
     * @param array $initSteps
     * @throws Exception
     */
    public function  __construct($initSteps)
    {
        if(count($initSteps) == 0)
            throw new Exception('An error has occurred, there are no steps datas');

        foreach($initSteps as $initStep) {
            $step = new Step();
            $step->setId($initStep['id']);

            if(!isset($initStep['departure'])) {
                throw new Exception('An error has occurred, missing departure city');
            };
            if(!isset($initStep['arrival'])) {
                throw new Exception('An error has occurred, missing arrival city');
            };

            $step->setDeparture($this->extractCity($initStep['departure']));
            $step->setArrival($this->extractCity($initStep['arrival']));

            if(isset($initStep['transport'])) {
                $step->setTransport($initStep['transport']);
            };

            if(isset($initStep['baggage'])) $step->setBaggage($initStep['baggage']);

            if(isset($initStep['seat'])) $step->setSeat($initStep['seat']);
            $this->arrivalsCities[] = $step->getArrival();
            $this->steps[] = $step;
        }

    }

     /**
     * extract city from the source
     *
     * @param string $city
     * @return string
     */
    public function extractCity(string $city): string
    {
        return preg_replace('/^Aéroport de /','',$city);
    }

    /**
     *  Use Case find first step of the collection
     *
     */
    public function findDeparture()
    {
        foreach ($this->steps as $step) {
            if (!in_array($step->getDeparture(), $this->arrivalsCities)) {
                return $step;
            }
        }

    return null;

    }

    /**
     * Trouve l'étape suivante dans l'itinéraire en se basant sur l'arrivée de l'étape actuelle.
     *
     * Cette méthode compare la ville d'arrivée de l'étape actuelle avec les villes de départ
     * des autres étapes pour trouver la correspondance suivante. La comparaison tient compte
     * de la normalisation des noms des villes pour assurer la cohérence, même en présence
     * de variations dans le formatage des noms.
     *
     * @param Step $stepDeparture L'étape actuelle à partir de laquelle trouver l'étape suivante.

     * @return Step|null L'étape suivante si trouvée, sinon null.
     */
    public function findNextStep( Step $stepDeparture): ?Step
    {
        foreach($this->steps as $step){
            if($step->getDeparture() === $stepDeparture->getArrival()) {
                return $step;
            }
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
     * @return array L'itinéraire complet, ordonné du départ à l'arrivée.
     */
    public function createItinerary()
    {
        $itinerary = array();
        $stepDeparture = $this->findDeparture();
        if($stepDeparture !== null) $itinerary[] = $stepDeparture;
        while($stepDeparture !== null)
        {
            $stepDeparture = $this->findNextStep($stepDeparture);
            if($stepDeparture !== null) $itinerary[] = $stepDeparture ;
        }
        return $itinerary;
    }

     /**
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset):bool
    {
        return isset($this->steps[$offset]);
    }
    /**
     *
     * @param int $offset
     *
     * @return Step
     */
    public function offsetGet($offset)
    {
        return $this->steps[$offset];
    }
    /**
     *
     * @param int $offset
     *
     * @param Step $value
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->steps[$offset] = $value;
    }
    /**
     *
     * @param int $offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->steps[$offset]);
    }
}