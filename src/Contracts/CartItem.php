<?php


namespace Faza13\Cart\Contracts;



interface CartItem
{
    public function getUuid();

    /**
     * @return String
     */
    public function getName();

    /**
     * @return Integer
     */
    public function getPrice();

    /**
     * @return float
     */
    public function getWeight();

    /**
     * @return float
     */
    public function getDiscount();

    /**
     * @return array
     */
    public function getOptions();
}