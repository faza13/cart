<?php

namespace Faza13\Cart;


use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../config/cart.php' => config_path('cart.php'),
        ]);

        // Register commands
        $this->commands('command.cart.table');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/cart.php', 'cart');

        $this->app->singleton(CartStoreManager::class, function ($app) {
            return new CartStoreManager($app, 'default_store');
        });

        $this->app->alias(CartStoreManager::class, 'carts');

        $this->registerCommands();

        Event::listen(
            \Faza13\Cart\Events\CartStoreChanged::class,
            \Faza13\Cart\Listeners\CartStoreChangedListener::class
        );
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
//        $this->app->singleton('command.cart.table', function ($app) {
//            return new CartTableCommand($app['files'], $app['composer']);
//        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'carts'
        ];
    }
}