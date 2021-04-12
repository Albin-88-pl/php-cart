<?php

namespace Recruitment\Entity;

use Recruitment\Cart\Cart;

class Order
{
    private $cart;
    private $cartId;

    public function __construct(int $cartId, Cart $cart)
    {
        $this->cart = $cart;
        $this->cartId = $cartId;
    }

    public function getDataForView(): array
    {
        $cartItems = $this->cart->getItems();
        $items = array();
        $totalPrice = 0;
        foreach ($cartItems as $itemId => $item) {
            $id = $item->getProduct()->getId();
            $unitPrice = $item->getProduct()->getUnitPrice();
            $quantity = $item->getQuantity();
            $itemTotalPrice = $quantity * $unitPrice;
            $totalPrice += $itemTotalPrice;
            $items[] = array('id' => $id,
                            'quantity' => $quantity,
                            'total_price' => $itemTotalPrice);
        }

        return ['id' => $this->cartId, 'items'=>$items, 'total_price' => $totalPrice];
    }
}
