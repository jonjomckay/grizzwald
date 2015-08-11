<?php
namespace Xenolope\Grizzwald\Entity;

class Machine
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $primaryIp;

    /**
     * @var array
     */
    private $metadata;

    /**
     * Machine constructor.
     * @param string $id
     * @param string $primaryIp
     * @param array $metadata
     */
    public function __construct($id, $primaryIp, array $metadata)
    {
        $this->id = $id;
        $this->primaryIp = $primaryIp;
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Machine
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryIp()
    {
        return $this->primaryIp;
    }

    /**
     * @param string $primaryIp
     * @return Machine
     */
    public function setPrimaryIp($primaryIp)
    {
        $this->primaryIp = $primaryIp;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     * @return Machine
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
}
