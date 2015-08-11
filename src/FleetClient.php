<?php
namespace Xenolope\Grizzwald;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Xenolope\Grizzwald\Entity\Machine;
use Xenolope\Grizzwald\Entity\Unit;
use Xenolope\Grizzwald\Entity\UnitOption;
use Xenolope\Grizzwald\Entity\UnitState;
use Xenolope\Grizzwald\Iterator\ResultIterator;

class FleetClient
{

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client = null, $baseUrl)
    {
        if ($client == null) {
            $this->client = new Client([
                'base_uri' => $baseUrl
            ]);
        } else {
            $this->client = $client;
        }
    }

    /**
     * @param Unit $unit
     * @throws \Exception
     */
    public function createUnit(Unit $unit)
    {
        if (!$unit->getName()) {
            throw new \InvalidArgumentException('A name must be given when creating a Unit');
        }

        if (!$unit->getDesiredState()) {
            throw new \InvalidArgumentException('A desired state must be given when creating a Unit');
        }

        if (!$unit->getOptions()) {
            throw new \InvalidArgumentException('At least one option must be given when creating a Unit');
        }

        $this->sendRequest('PUT', sprintf('units/%s', $unit->getName()), [
            'desiredState' => $unit->getDesiredState(),
            'name' => $unit->getName(),
            'options' => $unit->getOptions()
        ]);
    }

    /**
     * @param string $name
     * @throws \Exception
     */
    public function destroyUnit($name)
    {
        $this->sendRequest('DELETE', sprintf('units/%s', $name));
    }

    /**
     * @param string $name
     * @return Unit
     * @throws \Exception
     */
    public function getUnit($name)
    {
        $response = $this->sendRequest('GET', sprintf('units/%s', $name));

        return $this->buildUnit($response);
    }

    /**
     * @return Machine[]|array
     */
    public function listMachines()
    {
        $machines = [];
        foreach ($this->fetchIterator('machines', 'machines') as $machine) {
            $metadata = array_key_exists('metadata', $machine) ? $machine['metadata'] : [];

            $machines[] = new Machine($machine['id'], $machine['primaryIP'], $metadata);
        }

        return $machines;
    }

    /**
     * @param string|null $machineId
     * @param string|null $unitName
     * @return UnitState[]|array
     * @throws \Exception
     */
    public function listStates($machineId = null, $unitName = null)
    {
        $parameters = [];

        if ($machineId) {
            $parameters['machineID'] = $machineId;
        }

        if ($unitName) {
            $parameters['unitName'] = $unitName;
        }

        $states = [];
        foreach ($this->fetchIterator('state', 'states') as $state) {
            $states[] = new UnitState($state['name'], $state['hash'], $state['machineID'],
                $state['systemdLoadState'], $state['systemdActiveState'], $state['systemdSubState']);
        }

        return $states;
    }

    /**
     * @return Unit[]|array
     */
    public function listUnits()
    {
        $units = [];
        foreach ($this->fetchIterator('units', 'units') as $unit) {
            $units[] = $this->buildUnit($unit);
        }

        return $units;
    }

    /**
     * @param Unit $unit
     * @throws \Exception
     */
    public function modifyUnit(Unit $unit)
    {
        if (!$unit->getName()) {
            throw new \InvalidArgumentException('A name must be given when modifying a Unit');
        }

        if (!$unit->getDesiredState()) {
            throw new \InvalidArgumentException('A desired state must be given when modifying a Unit');
        }

        $this->sendRequest('PUT', sprintf('units/%s', $unit->getName()), [
            'desiredState' => $unit->getDesiredState()
        ]);
    }

    private function buildUnit($unit)
    {
        $options = [];
        if (array_key_exists('options', $unit)) {
            foreach ($unit['options'] as $option) {
                if (!empty($option)) {
                    $options[] = new UnitOption($option['section'], $option['name'], $option['value']);
                }
            }
        }

        $machineID = null;
        if (array_key_exists('machineID', $unit)) {
            $machineID = $unit['machineID'];
        }

        return new Unit($unit['name'], $options, $unit['desiredState'], $unit['currentState'], $machineID);
    }

    private function fetchIterator($url, $type)
    {
        return new ResultIterator($type, function($nextPageToken) use ($url) {
            return $this->sendRequest('GET', $url, null, ['nextPageToken' => $nextPageToken]);
        });
    }

    private function handleError(ResponseInterface $response)
    {
        if ($response->getBody()->getSize()) {
            $body = json_decode($response->getBody()->getContents(), true);

            if (array_key_exists('error', $body)) {
                throw new \Exception('An error occurred while sending the request to Fleet: ' . $body['error']['message'], $body['error']['code']);
            }
        }

        throw new \Exception('An unknown error occurred while sending the request to Fleet');
    }

    private function sendRequest($method, $url, $requestBody = null, $queryParameters = null)
    {
        // Remove null valued parameters
        $queryParameters = array_filter($queryParameters);

        if ($requestBody) {
            $response = $this->client->request($method, $url, [
                'json' => $requestBody,
                'query' => $queryParameters
            ]);
        } else {
            $response = $this->client->request($method, $url, [
                'query' => $queryParameters
            ]);
        }

        switch ($response->getStatusCode()) {
            case 200:
                return json_decode($response->getBody()->getContents(), true);
            case 201:
            case 202:
            case 203:
            case 204:
            case 205:
            case 206:
                return null;
            default:
                $this->handleError($response);
                return null;
        }
    }
}
