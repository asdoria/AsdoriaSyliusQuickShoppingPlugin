<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Helper;

use Asdoria\SyliusQuickShoppingPlugin\Helper\Model\ProductVariantHelperInterface;
use Sylius\Bundle\MoneyBundle\Formatter\MoneyFormatterInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Currency\Context\CurrencyContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ProductVariantHelper
 */
class ProductVariantHelper implements ProductVariantHelperInterface
{
    public function __construct(
        protected RouterInterface $router,
        protected ChannelContextInterface $channelContext,
        protected LocaleContextInterface $localeContext,
        protected CurrencyContextInterface $currencyContext,
        protected MoneyFormatterInterface $moneyFormatter,
    ) {
    }

    public function getImage(ProductVariantInterface $productVariant): ?string
    {
        /** @var ProductInterface $product */
        $product = $productVariant->getProduct();
        $images = !$productVariant->getImages()->isEmpty() ?
            $productVariant->getImages() : $product->getImages();

        $image = $images->first();

        if (!$image instanceof ImageInterface) {
            return null;
        }

        return $this->router->generate(
            'liip_imagine_filter',
            ['path' => $image->getPath(), 'filter' => 'sylius_shop_product_thumbnail'],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );
    }

    public function getSlug(ProductVariantInterface $productVariant): string
    {
        /** @var ProductInterface $product */
        $product = $productVariant->getProduct();

        return $this->router->generate(
            'sylius_shop_product_show',
            ['slug' => $product->getSlug(),
             '_locale' => $this->localeContext->getLocaleCode()],
            UrlGeneratorInterface::ABSOLUTE_PATH,
        );
    }

    public function getPrice(ProductVariantInterface $productVariant): string
    {
        $amount = $this->getAmount($productVariant);

        return $this->getPriceFormat($amount);
    }

    public function getAmount(ProductVariantInterface $productVariant): int
    {
        $channel = $this->channelContext->getChannel();
        $amount = 0;

        if ($channel instanceof ChannelInterface) {
            $channelPricing = $productVariant->getChannelPricingForChannel($channel);
            $amount = $channelPricing instanceof ChannelPricingInterface ?
                $channelPricing->getPrice() ?? 0 : 0;
        }

        return $amount;
    }

    public function getPriceFormat(int $amount): string
    {
        return $this->moneyFormatter->format(
            $amount,
            $this->currencyContext->getCurrencyCode(),
            $this->localeContext->getLocaleCode(),
        );
    }
}
