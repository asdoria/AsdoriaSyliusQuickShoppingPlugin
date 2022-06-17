<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Helper\Model;

use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Currency\Context\CurrencyContextInterface;

/**
 * Interface ProductVariantHelperInterface
 * @package Asdoria\SyliusQuickShoppingPlugin\Helper\Model
 *
 * @author  Philippe Vesin <pve.asdoria@gmail.com>
 */
interface ProductVariantHelperInterface
{
    /**
     * @param ProductVariantInterface $productVariant
     *
     * @return string|null
     */
    public function getImage(ProductVariantInterface $productVariant): ?string;

    /**
     * @param ProductVariantInterface $productVariant
     *
     * @return mixed
     */
    public function getSlug(ProductVariantInterface $productVariant): string;


    /**
     * @param ProductVariantInterface $productVariant
     *
     * @return mixed
     */
    public function getPrice(ProductVariantInterface $productVariant): string;
    /**
     * @return int
     */
    public function getAmount(ProductVariantInterface $productVariant): int;
    public function getPriceFormat(int $amount): string;

}
