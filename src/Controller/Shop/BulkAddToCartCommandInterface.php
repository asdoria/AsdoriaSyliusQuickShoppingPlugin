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
use Sylius\Component\Core\Model\OrderItemInterface;

interface BulkAddToCartCommandInterface
{
    /**
     * @return ArrayCollection<array-key,OrderItemInterface>
     */
    public function getAddToCartCommandItems(): ArrayCollection;

    public function getCart(): OrderInterface;
}
