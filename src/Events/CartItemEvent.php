<?php


namespace Faza13\Cart\Events;


class CartItemEvent
{
    /**
     * @var Object
     */
    public $cart;

    public $item;

    /**
     * CartEvent constructor.
     * @param Cart $cart
     * @param Item $item
     */
    public function __construct($cart, $item)
    {
        $this->cart = $cart;
        $this->item = $item;
    }
}