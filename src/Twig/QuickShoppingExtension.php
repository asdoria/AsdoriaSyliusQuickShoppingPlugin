<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Twig;

use Asdoria\SyliusQuickShoppingPlugin\Helper\Model\ProductVariantHelperInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class QuickShoppingExtension
 */
class QuickShoppingExtension extends AbstractExtension
{
    public function __construct(
        protected ProductVariantHelperInterface $productVariantHelper,
        protected ProductVariantRepositoryInterface $productVariantRepository,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('quick_shopping_product_variant_price', [$this, 'getPrice']),
            new TwigFunction('quick_shopping_product_variant_unit_price', [$this, 'getUnitPrice']),
            new TwigFunction('quick_shopping_product_variant_image', [$this, 'getImage']),
        ];
    }

    public function getUnitPrice(?string $price): string
    {
        preg_match('/[+-]?[0-9]+([.][0-9]+)?([eE][+-]?[0-9]+)?/', $price, $matches);

        return current($matches);
    }

    public function getPrice(?string $code, ?int $quantity): string
    {
        if (empty($code)) {
            return $this->productVariantHelper->getPriceFormat(0);
        }

        $productVariant = $this->productVariantRepository->findOneByCode($code);
        if (!$productVariant instanceof ProductVariantInterface) {
            return $this->productVariantHelper->getPriceFormat(0);
        }

        return $this->productVariantHelper->getPriceFormat($this->productVariantHelper->getAmount($productVariant) * $quantity);
    }

    public function getImage(?string $code): ?string
    {
        $productVariant = $this->productVariantRepository->findOneByCode($code);
        if (!$productVariant instanceof ProductVariantInterface) {
            return null;
        }

        return $this->productVariantHelper->getImage($productVariant);
    }
}
