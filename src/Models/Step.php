<?PHP
namespace App\Models;

/**
 * Represents the model Step of ititnary.
 *
 * Cette classe sert à modéliser une étape d'un itinéraire dans une application.

 * @category Modele
 * @package  YourPackage
 * @author Your Name
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link       http://example.com/docs/Step
 */

class Step
{
    /**
     * Attribute to determine identifier of carriage.
     * @var int
     */
    public $id ;

     /**
      * Attribute to city name of departure .
      * @var string
     */
    public $departure ;

    /**
     * Attribute to city name of arrival.
     * @var string
     */
    public $arrival ;

     /**
      * Attribute to name of transport .
      * @var string
     */
    public $transport ;

     /**
      * attribute to name of seat .
      * @var string $seat
     */
    public $seat ;

    /**
     * attribute to name of baggages .
     * @var string $baggages
     */
    public $baggages ;

    /**
     * getter for attribute id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Setter attribute id
     *
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
         $this->id = $id;
    }

    /**
     * Setter for attribute departure
     *
     * @return string
     */
    public function getDeparture(): string
    {
        return $this->departure;
    }

    /**
     * Setter for attribute departure
     *
     * @param string $departure
     *
     * @return void
     */
    public function setDeparture(string $departure): void
    {
        $this->departure = $departure;
    }

    /**
     * Getter for attribute arrival
     *     *
     * @return string
     */
    public function getArrival(): string
    {
       return $this->arrival;
    }

    /**
     * Setter for attribute arrival
     *
     * @param string $arrival
     *
     * @return void
     */
    public function setArrival(string $arrival): void
    {
        $this->arrival = $arrival;
    }

    /**
     * Getter for attribute transport
     *     *
     * @return void
     */
    public function getTransport(): string
    {
        return $this->transport;

    }
    /**
     * Setter for attribute transport
     *
     * @param string $transport
     *
     * @return void
     */
    public function setTransport(string $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Getter for attribute seat
     *
     * @return string
     */
    public function getSeat(): string
    {
        return $this->seat;
    }

    /**
     * Setter for attribute seat
     *
     * @param string $seat
     *
     * @return void
     */
    public function setSeat(string $seat)
    {
        $this->seat = $seat;
    }
    /**
     * Getter for attribute baggage
     *     *
     * @return string
     */
    public function getBaggage(): string
    {
        return $this->baggage;
    }
    /**
     * Getter for attribute baggage
     *
     * @param string $baggage
     *
     * @return void
     */
    public function setBaggage(string $baggage): void
    {
        $this->baggage = $baggage;
    }

}