<?php


namespace Faza13\Cart\Listeners;

use Faza13\Cart\Events\CartStoreChanged;

class CartStoreChangedListener
{
    public function handle(CartStoreChanged $event)
    {
        $event->newCartStore->makeCart()->addAll($event->oldCartStore->getItems())->save();
        $event->oldCartStore->forget();
    }
}