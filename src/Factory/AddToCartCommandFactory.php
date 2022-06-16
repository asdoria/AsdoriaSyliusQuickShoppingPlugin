<?php

declare(strict_types=1);


namespace Asdoria\SyliusQuickShoppingPlugin\Factory;


use Asdoria\SyliusQuickShoppingPlugin\Controller\Shop\AddToCartCommand;
use Sylius\Bundle\OrderBundle\Controller\AddToCartCommandInterface;
use Sylius\Bundle\OrderBundle\Factory\AddToCartCommandFactoryInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Model\OrderItemInterface;

/**
 * Class AddToCartCommandFactory
 * @package Asdoria\SyliusQuickShoppingPlugin\Factory
 *
 * @author  Philippe Vesin <pve.asdoria@gmail.com>
 */
class AddToCartCommandFactory implements AddToCartCommandFactoryInterface
{
    public function createWithCartAndCartItem(OrderInterface $cart, OrderItemInterface $cartItem): AddToCartCommandInterface
    {
        return new AddToCartCommand($cart, $cartItem);
    }
}
