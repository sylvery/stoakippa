<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    private $factory;
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Home', ['route' => 'home']);
        $menu->addChild('sales', ['route' => 'sale_index']);
        $menu->addChild('transactions', ['route' => 'transaction_index']);
        $menu->addChild('stocks', ['route' => 'stock_index']);
        $menu->addChild('items', ['route' => 'item_index']);
        $menu->addChild('manufacturers', ['route' => 'item_manufacturer_index']);
        return $menu;
    }
}