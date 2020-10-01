<?php


namespace Faza13\Cart;


use Faza13\Cart\Contracts\CartStore;
use Faza13\Cart\Exceptions\ClientIdException;

abstract class AbstractCartStore implements CartStore
{
    private $clientId;

    /**
     * @return string
     * @throws ClientIdException
     */
    public function getClientId()
    {
        if (empty($this->clientId))
        {
            if(auth()->check())
            {
                $this->clientId =  auth()->id();
            }
            else {
                try{
                    $this->clientId = decrypt(request()->get('client_id'));
                }
                catch (\Exception $e) {}
            }

            if(!$this->clientId || empty($this->clientId) || is_null($this->clientId))
                Throw new ClientIdException('Invalid Token ID');

            $this->clientId = 'cart::' . $this->clientId;
        }


        return $this->clientId;
    }


    public function makeCart()
    {
        return Cart::create($this);
    }
}