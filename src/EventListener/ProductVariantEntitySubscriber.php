<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\EventListener;

use App\Entity\Product\ProductVariant;
use Asdoria\SyliusQuickShoppingPlugin\Helper\Model\ProductVariantHelperInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

/**
 * Class SerializerInjectionListener
 */
class ProductVariantEntitySubscriber extends AbstractEntitySubscriber
{
    public function __construct(
        protected ProductVariantHelperInterface $productVariantHelper,
    ) {
    }

    protected static function getClassName(): string
    {
        return ProductVariant::class;
    }

    protected function getMethodNames(): array
    {
        return ['getImage', 'getSlug', 'getPrice'];
    }

    public function getImage(ProductVariantInterface $productVariant): ?string
    {
        return $this->productVariantHelper->getImage($productVariant);
    }

    /**
     * @return mixed
     */
    public function getSlug(ProductVariantInterface $productVariant): string
    {
        return $this->productVariantHelper->getSlug($productVariant);
    }

    /**
     * @return mixed
     */
    public function getPrice(ProductVariantInterface $productVariant): string
    {
        return $this->productVariantHelper->getPrice($productVariant);
    }
}
