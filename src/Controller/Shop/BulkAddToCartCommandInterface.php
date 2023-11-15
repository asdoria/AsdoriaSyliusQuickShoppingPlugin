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
use Sylius\Bundle\OrderBundle\Controller\AddToCartCommandInterface;
use Sylius\Component\Core\Model\OrderInterface;

interface BulkAddToCartCommandInterface
{
    /**
     * @return ArrayCollection<array-key,AddToCartCommandInterface>
     */
    public function getAddToCartCommandItems(): ArrayCollection;

    public function getCart(): OrderInterface;
}
