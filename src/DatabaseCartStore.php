<?php


namespace Faza13\Cart;


use Illuminate\Support\Facades\Log;

class DatabaseCartStore extends AbstractCartStore
{
    private $model;

    public function __construct($model)
    {
        if (is_string($model)) {
            $class = '\\'.ltrim($model, '\\');
            $model = new $class;
        }
        $this->model = $model;
    }

    /**
     * @param  array  $items
     * @param $ttl
     * @return void
     * @throws Exceptions\ClientIdException
     */
    public function setItems(array $items, $ttl)
    {
        $cart = $this->getModel()->newQuery()->where(['client_id' => $this->getClientId()])
            ->get();
        if(isset($cart[0]))
        {
            $newCart = $cart[0];
            $newCart->items = serialize($items);
            $newCart->save();
        }

        if(!isset($cart[0]))
        {
            $this->getModel()->newQuery()->updateOrCreate(['client_id' => $this->getClientId()], ['items' => serialize($items)]);
        }
//        $this->getModel()->newQuery()->updateOrCreate(['client_id' => $this->getClientId()], ['items' => serialize($items)]);
    }

    /**
     * @return array
     * @throws Exceptions\ClientIdException
     */
    public function getItems()
    {
        $model = $this->getModel()->newQuery()->where(['client_id' => $this->getClientId()])
            ->get();

        return !isset($model[0]) ? [] : unserialize($model[0]->items);
    }

    /**
     * @return void
     */
    public function forget()
    {
        $this->getModel()->newQuery()->where(['client_id' => $this->getClientId()])->delete();
    }

    /**
     * @param  string  $clientId
     * @param  array  $items
     * @param $ttl
     */
    public function changeClientId($clientId, array $items, $ttl)
    {
        $clientId = "cart::" . $clientId;
        $this->getModel()->newQuery()->where(['client_id' => $this->getClientId()])->update(['client_id' => $clientId]);
    }

    private function getModel()
    {
        return $this->model;
    }
}
