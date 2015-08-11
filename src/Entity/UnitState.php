<?php
namespace Xenolope\Grizzwald\Entity;

class UnitState
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $machineId;

    /**
     * @var string
     */
    private $systemdLoadState;

    /**
     * @var string
     */
    private $systemdActiveState;

    /**
     * @var string
     */
    private $systemdSubState;

    /**
     * UnitState constructor.
     * @param string $name
     * @param string $hash
     * @param string $machineId
     * @param string $systemdLoadState
     * @param string $systemdActiveState
     * @param string $systemdSubState
     */
    public function __construct($name, $hash, $machineId, $systemdLoadState, $systemdActiveState, $systemdSubState)
    {
        $this->name = $name;
        $this->hash = $hash;
        $this->machineId = $machineId;
        $this->systemdLoadState = $systemdLoadState;
        $this->systemdActiveState = $systemdActiveState;
        $this->systemdSubState = $systemdSubState;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getMachineId()
    {
        return $this->machineId;
    }

    /**
     * @return string
     */
    public function getSystemdLoadState()
    {
        return $this->systemdLoadState;
    }

    /**
     * @return string
     */
    public function getSystemdActiveState()
    {
        return $this->systemdActiveState;
    }

    /**
     * @return string
     */
    public function getSystemdSubState()
    {
        return $this->systemdSubState;
    }
}
