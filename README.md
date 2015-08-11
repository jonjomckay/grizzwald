Grizzwald
=========

*"Grizz was in the Navy"* - **Tracy Jordan, 30 Rock (S01E01: The Aftermath)**

Grizzwald is a simple PHP library that interacts with the [CoreOS fleet API](https://coreos.com/fleet/docs/latest/api-v1.html), for easy management of your cluster's unit files.

## Installation

The library can be installed with Composer, by including the following in your `composer.json`:

```json
{
    "require": {
        "xenolope/grizzwald": "~1.0"
    }
}
```

## Usage

```php
// Create a new instance of the client, passing in the base URL to your fleet instance
$client = new \Xenolope\Grizzwald\FleetClient('http://172.16.1.100:49153');

// Get a list of all the machines in the cluster
$machines = $client->listMachines(); // Returns an array of \Xenolope\Grizzwald\Entity\Machine objects

// Get a list of all the unit states in the cluster
$states = $client->listUnitStates(); // Returns an array of \Xenolope\Grizzwald\Entity\UnitState objects

// Get a list of all the units in the cluster
$units = $client->listUnits(); // Returns an array of \Xenolope\Grizzwald\Entity\Unit objects

// Get a single unit from the cluster
$unit = $client->getUnit('nginx.service'); // Returns a \Xenolope\Grizzwald\Entity\Unit object

// Create a new unit on the cluster
$unit = new Unit('nginx.service', [
    new UnitOption('Service', 'ExecStart', '/usr/sbin/nginx') // One or more UnitOptions are required 
], Unit::STATE_LAUNCHED);

$client->createUnit($unit);

// Modify an existing unit on the cluster
$unit = new Unit('nginx.service', Unit::STATE_LOADED);

$client->modifyUnit($unit);

// Destroy a unit on the cluster
$client->destroyUnit('nginx.service');
```

## License

Grizzwald is released under the MIT License; please see [LICENSE](LICENSE) for more information.