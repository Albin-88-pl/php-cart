<?php

namespace Recruitment\Cart;

use Recruitment\Entity\Order;
use Recruitment\Entity\Product;
use Recruitment\Cart\Item;

class Cart
{

    public static $id = 0;

    public function __construct()
    {
        self::$id++;
    }
    /**
     * @var Item[]
     */
    private $items;

    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->getProduct()->getUnitPrice() * $item->getQuantity();
        }
        return $sum;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return Cart
     */
    public function addProduct(Product $product, int $quantity = 1): Cart
    {
        $productId = $product->getId();
        $itemId = $this->findProductInCartIndex($productId);
        if ($itemId === -1) {
            $item = new Item($product, $quantity);
            $this->items[] = $item;
        } else {
            $oldQuantity =  $this->items[$itemId]->getQuantity();
            $this->items[$itemId]->setQuantity($oldQuantity+$quantity);
        }
        return $this;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return Cart
     */
    public function setQuantity(Product $product, int $quantity): Cart
    {
        $productId = $product->getId();
        $itemId = $this->findProductInCartIndex($productId);
        if ($itemId < 0) {
            $item = new Item($product, $quantity);
            $this->items[] = $item;
            return $this;
        }
        $this->items[$itemId]->setQuantity($quantity);
        return $this;
    }

    /**
     * @param int $id
     * @return Item
     */
    public function getItem(int $id): Item
    {
        if (isset($this->items[$id])) {
            return $this->items[$id];
        }
        throw new \OutOfBoundsException('index doesnt exist');
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product): void
    {
        $itemId = $this->findProductInCartIndex($product->getId());
        if ($itemId >= 0) {
            unset($this->items[$itemId]);
            $this->items = array_values($this->items);
        }
    }

    private function findProductInCartIndex(int $productId): int
    {
        if (isset($this->items) && count($this->items) > 0) {
            foreach ($this->items as $itemId => $item) {
                if ($item->getProduct()->getId() === $productId) {
                    return $itemId;
                }
            }
        }
        return -1;
    }

    /**
     * @param int $cartId
     * @return Order
     */
    public function checkout(int $cartId): Order
    {
        $that = clone($this);
        $this->reset();
        return (new Order($cartId, $that));
    }

    public function reset(): void
    {
        $this->items = array();
    }
}
