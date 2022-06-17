<?php

namespace Asdoria\SyliusQuickShoppingPlugin\EventListener;

use App\Entity\Product\ProductVariant;
use Asdoria\SyliusQuickShoppingPlugin\Helper\Model\ProductVariantHelperInterface;
use JMS\Serializer\EventDispatcher\PostSerializeEvent;
use Sylius\Component\Core\Model\ProductVariantInterface;

/**
 * Class SerializerInjectionListener
 * @package Asdoria\SyliusQuickShoppingPlugin\EventListener
 *
 * @author  Philippe Vesin <pve.asdoria@gmail.com>
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

    /**
     * @param ProductVariantInterface $productVariant
     *
     * @return string|null
     */
    public function getImage(ProductVariantInterface $productVariant): ?string
    {
        return $this->productVariantHelper->getImage($productVariant);
    }

    /**
     * @param ProductVariantInterface $productVariant
     *
     * @return mixed
     */
    public function getSlug(ProductVariantInterface $productVariant): string
    {
        return $this->productVariantHelper->getSlug($productVariant);
    }


    /**
     * @param ProductVariantInterface $productVariant
     *
     * @return mixed
     */
    public function getPrice(ProductVariantInterface $productVariant): string
    {
        return $this->productVariantHelper->getPrice($productVariant);
    }
}
