<?php


namespace Faza13\Cart;


use Illuminate\Support\Facades\Redis;

class RedisCartStore extends AbstractCartStore
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param  array  $items
     * @param $ttl
     * @return void
     * @throws Exceptions\ClientIdException
     */
    public function setItems(array $items, $ttl)
    {
        $this->getDefaultRedisConnection()->setex(
            $this->getClientId(), $ttl, serialize($items)
        );
    }

    /**
     * @return array
     * @throws Exceptions\ClientIdException
     */
    public function getItems()
    {
        $items = @unserialize($this->getDefaultRedisConnection()->get($this->getClientId()));

        return empty($items) ? [] : $items;
    }

    /**
     * @return void
     * @throws Exceptions\ClientIdException
     */
    public function forget()
    {
        $this->getDefaultRedisConnection()->del($this->getClientId());
    }

    /**
     * @param  string  $clientId
     * @param  array  $items
     * @param $ttl
     */
    public function changeClientId($clientId, array $items, $ttl)
    {
        $clientId = "cart::" . $clientId;
        $this->getDefaultRedisConnection()->setex(
            $clientId, $ttl, serialize($items)
        );
    }

    private function getDefaultRedisConnection()
    {
        return Redis::connection($this->connection);
    }
}