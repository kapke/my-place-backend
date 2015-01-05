<?php
namespace Kapke\Provider\Clients\Entity;

class Product
{
    private $id;
    private $vendor;
    private $name;

    public function __construct(Vendor $vendor, $name)
    {
        $this->vendor = $vendor;
        $this->name = $name;
    }

    /**
     * Set id
     *
     * @param  integer $id
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param  string  $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set vendor
     *
     * @param  \Kapke\Provider\Clients\Entity\Vendor $vendor
     * @return Product
     */
    public function setVendor(\Kapke\Provider\Clients\Entity\Vendor $vendor = null)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return \Kapke\Provider\Clients\Entity\Vendor
     */
    public function getVendor()
    {
        return $this->vendor;
    }
}
