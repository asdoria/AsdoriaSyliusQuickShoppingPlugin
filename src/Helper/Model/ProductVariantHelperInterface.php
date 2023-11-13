<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Helper\Model;

use Sylius\Component\Core\Model\ProductVariantInterface;

/**
 * Interface ProductVariantHelperInterface
 */
interface ProductVariantHelperInterface
{
    public function getImage(ProductVariantInterface $productVariant): ?string;

    /**
     * @return mixed
     */
    public function getSlug(ProductVariantInterface $productVariant): string;

    /**
     * @return mixed
     */
    public function getPrice(ProductVariantInterface $productVariant): string;

    public function getAmount(ProductVariantInterface $productVariant): int;

    public function getPriceFormat(int $amount): string;
}
