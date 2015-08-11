<?php
namespace Xenolope\Grizzwald\Entity;

class UnitOption
{

    /**
     * @var string
     */
    private $section;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * UnitOption constructor.
     * @param string $section
     * @param string $name
     * @param string $value
     */
    public function __construct($section, $name, $value)
    {
        $this->section = $section;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $section
     * @return UnitOption
     */
    public function setSection($section)
    {
        $this->section = $section;
        return $this;
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
     * @return UnitOption
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return UnitOption
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
