<?php


namespace Faza13\Cart;


use Faza13\Cart\Contracts\CartStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

abstract class AbstractCartStore implements CartStore
{
    private $clientId;

    /**
     * @return string
     */
    public function getClientId()
    {
        if (empty($this->clientId))
        {
            $this->clientId =  Auth::id();
            $this->clientId = 'cart::' . $this->clientId;
        }

        return $this->clientId;
    }


    public function makeCart()
    {
        return Cart::create($this);
    }
}