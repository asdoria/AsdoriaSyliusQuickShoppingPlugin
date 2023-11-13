<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Factory\Model;

use Asdoria\SyliusQuickShoppingPlugin\Controller\Shop\BulkAddToCartCommandInterface;
use Sylius\Bundle\OrderBundle\Controller\AddToCartCommandInterface;

/**
 * Class BulkAddToCartCommandFactoryInterface
 */
interface BulkAddToCartCommandFactoryInterface
{
    public function createWithAddToCartItems(int $nbr): BulkAddToCartCommandInterface;

    public function createAddToCartCommand($cart): AddToCartCommandInterface;
}
