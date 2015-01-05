<?php
namespace Kapke\Module\ClientConversions\Entity;

use Kapke\Provider\Clients\Entity\Product;
use Kapke\Provider\Clients\Entity\Client;

class Conversion
{
    private $id;
    private $product;
    private $client;
    private $timestamp;
    private $note;

    public function __construct()
    {
        $this->timestamp = new \DateTime();
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
     * Set timestamp
     *
     * @param  \DateTime  $timestamp
     * @return Conversion
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set note
     *
     * @param  string     $note
     * @return Conversion
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set product
     *
     * @param  \Kapke\Provider\Clients\Entity\Product $product
     * @return Conversion
     */
    public function setProduct(\Kapke\Provider\Clients\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Kapke\Provider\Clients\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set client
     *
     * @param  \Kapke\Provider\Clients\Entity\Client $client
     * @return Conversion
     */
    public function setClient(\Kapke\Provider\Clients\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Kapke\Provider\Clients\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
