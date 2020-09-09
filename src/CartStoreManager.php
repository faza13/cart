<?php


namespace Faza13\Cart;



use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Support\Manager;

class CartStoreManager extends Manager
{
    /**
     * @var Collection
     */
    private $stores;

    /**
     * @var string
     */
    private $currentStoreName;

    /**
     * CartStoreManager constructor.
     * @param $container
     * @param  string  $storeName
     */
    public function __construct(Container $container, $storeName)
    {
        parent::__construct($container);
        $this->currentStoreName = $storeName;
        $this->stores = new Collection();
    }

    /**
     * Get cart store.
     *
     * @param null $key
     * @return Faza13\Cart\Contracts\CartStore
     */
    public function getStore($key = null)
    {
        if ($key == null) {
            $key = $this->currentStoreName;
        }
        if (!$this->stores->has($key)) {
            $this->stores->put($key, $this->driver($this->container['config']["{$this->currentStoreName}.driver"]));
        }

        return $this->stores->get($key);
    }

//    public function createDatabaseDriver()
//    {
//        return new DatabaseCartStore($this->app['config']['cart.store_drivers.database.model']);
//    }
//
//    public function createCookieDriver()
//    {
//        return new CookieCartStore();
//    }

    public function createRedisDriver()
    {
        return new RedisCartStore($this->container['config']['cart.store_drivers.redis.conn']);
    }

    public function changeCurrentStore($name)
    {
        if ($name != $this->currentStoreName && !empty($this->currentStoreName)) {
            $this->container['events']->dispatch(new CartStoreChanged($this->getStore($this->currentStoreName), $this->getStore($name)));
            $this->currentStoreName = $name;
        }

        return $this;
    }

    /**
     * Get the default cache driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->container['config']['cart.default_store.driver'];
    }

    /**
     * Set the default cache driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->container['config']['cart.default_store.driver'] = $name;
    }
}