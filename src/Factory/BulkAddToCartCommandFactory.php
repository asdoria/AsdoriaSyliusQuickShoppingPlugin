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

namespace Asdoria\SyliusQuickShoppingPlugin\Factory;

use Asdoria\SyliusQuickShoppingPlugin\Controller\Shop\BulkAddToCartCommand;
use Asdoria\SyliusQuickShoppingPlugin\Controller\Shop\BulkAddToCartCommandInterface;
use Asdoria\SyliusQuickShoppingPlugin\Factory\Model\BulkAddToCartCommandFactoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Bundle\OrderBundle\Controller\AddToCartCommandInterface;
use Sylius\Bundle\OrderBundle\Factory\AddToCartCommandFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * Class BulkAddToCartCommandFactory
 */
final class BulkAddToCartCommandFactory implements BulkAddToCartCommandFactoryInterface
{
    /**
     * @param FactoryInterface<OrderItemInterface> $orderItemFactory
     */
    public function __construct(
        protected CartContextInterface $cartContext,
        protected FactoryInterface $orderItemFactory,
        protected AddToCartCommandFactoryInterface $addToCartCommandFactory,
        protected OrderItemQuantityModifierInterface $orderItemQuantityModifier,
    ) {
    }

    public function createWithAddToCartItems(int $nbr): BulkAddToCartCommandInterface
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartContext->getCart();
        /** @var ArrayCollection<array-key,AddToCartCommandInterface> $cartItems */
        $cartItems = new ArrayCollection();
        for ($i = 0; $i < $nbr; ++$i) {
            $cartItems->add($this->createAddToCartCommand($cart));
        }

        return new BulkAddToCartCommand($cart, $cartItems);
    }

    public function createAddToCartCommand(OrderInterface $cart): AddToCartCommandInterface
    {
        $orderItem = $this->orderItemFactory->createNew();
        $this->orderItemQuantityModifier->modify($orderItem, 1);

        return $this->addToCartCommandFactory->createWithCartAndCartItem($cart, $orderItem);
    }
}
