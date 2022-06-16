<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Controller\Shop;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\OrderInterface;

final class BulkAddToCartCommand implements BulkAddToCartCommandInterface
{
    public function __construct(public OrderInterface $cart, public ArrayCollection $cartItems)
    {
    }

    public function getAddToCartCommandItems(): ArrayCollection
    {
        return $this->cartItems;
    }

    /**
     * @return OrderInterface
     */
    public function getCart(): OrderInterface
    {
        return $this->cart;
    }
}
