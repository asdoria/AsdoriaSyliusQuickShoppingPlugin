<?php

declare(strict_types=1);


namespace Asdoria\SyliusQuickShoppingPlugin\Factory\Model;


use Asdoria\SyliusQuickShoppingPlugin\Controller\Shop\BulkAddToCartCommandInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Bundle\OrderBundle\Controller\AddToCartCommandInterface;


/**
 * Class BulkAddToCartCommandFactoryInterface
 *
 * @author Philippe Vesin <pve.asdoria@gmail.com>
 */
interface BulkAddToCartCommandFactoryInterface
{

    public function createWithAddToCartItems(int $nbr): BulkAddToCartCommandInterface;
    public function createAddToCartCommand($cart): AddToCartCommandInterface;
}
