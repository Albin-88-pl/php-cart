<?php

namespace Recruitment\Entity;

use Recruitment\Entity\Exception as E;

class Product
{
    private $id;

    private $unitPrice;

    private $minimumQuantity;

    private $name;

    public function __construct()
    {
        $this->minimumQuantity = 1;
        $this->id = -1;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    /**
     * @param int $minimumQuantity
     */
    public function setMinimumQuantity(int $minimumQuantity = 1): Product
    {
        if ($minimumQuantity <= 1) {
            throw new \InvalidArgumentException('quantity must be > '.$minimumQuantity);
        }
        $this->minimumQuantity = $minimumQuantity;
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return integer
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param int $unitPrice
     */
    public function setUnitPrice(int $unitPrice): Product
    {
        if ($unitPrice < 1) {
            throw new E\InvalidUnitPriceException('sweg');
        }
        $this->unitPrice = $unitPrice;
        return $this;
    }
}
