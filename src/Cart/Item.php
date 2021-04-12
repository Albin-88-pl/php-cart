<?php

namespace Recruitment\Cart;

use Recruitment\Entity\Product;
use Recruitment\Cart\Exception as E;

class Item
{
    private $product;

    private $quantity;

    private $totalPrice;

    public function __construct(Product $product, int $quantity)
    {
        $this->setProduct($product);
        if ($product->getMinimumQuantity() > $quantity) {
            throw new E\QuantityTooLowException('too low quality');
        }
        $this->quantity = $quantity;

        $totalPrice = $quantity * $product->getUnitPrice();
        $this->setTotalPrice($totalPrice);
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return Item
     */
    public function setProduct(Product $product): Item
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int  $quantity
     * @return Item
     */
    public function setQuantity(int $quantity): Item
    {
        if ($quantity < $this->product->getMinimumQuantity()) {
            throw new E\QuantityTooLowException('too low quality');
        }
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    /**
     * @param int $totalPrice
     * @return Item
     */
    public function setTotalPrice(int $totalPrice): Item
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }
}
