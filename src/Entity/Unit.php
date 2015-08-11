<?php
namespace Xenolope\Grizzwald\Entity;

class Unit
{

    const STATE_INACTIVE = 'inactive';
    const STATE_LOADED = 'loaded';
    const STATE_LAUNCHED = 'launched';

    /**
     * @var string
     */
    private $name;

    /**
     * @var UnitOption[]|array
     */
    private $options;

    /**
     * @var string
     */
    private $desiredState;

    /**
     * @var string
     */
    private $currentState;

    /**
     * @var string
     */
    private $machineId;

    /**
     * Unit constructor.
     * @param string $name
     * @param string $desiredState
     * @param array|UnitOption[] $options
     * @param string $currentState
     * @param string $machineId
     */
    public function __construct($name, $desiredState, $options = null, $currentState = null, $machineId = null)
    {
        $this->name = $name;
        $this->desiredState = $desiredState;
        $this->options = $options;
        $this->currentState = $currentState;
        $this->machineId = $machineId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Unit
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array|UnitOption[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array|UnitOption[] $options
     * @return Unit
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return string
     */
    public function getDesiredState()
    {
        return $this->desiredState;
    }

    /**
     * @param string $desiredState
     * @return Unit
     */
    public function setDesiredState($desiredState)
    {
        $this->desiredState = $desiredState;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * @param string $currentState
     * @return Unit
     */
    public function setCurrentState($currentState)
    {
        $this->currentState = $currentState;
        return $this;
    }

    /**
     * @return string
     */
    public function getMachineId()
    {
        return $this->machineId;
    }

    /**
     * @param string $machineId
     * @return Unit
     */
    public function setMachineId($machineId)
    {
        $this->machineId = $machineId;
        return $this;
    }
}
