<?php

namespace Asdoria\SyliusQuickShoppingPlugin\EventListener;

use JMS\Serializer\EventDispatcher\PreSerializeEvent;
use JMS\Serializer\EventDispatcher\PostSerializeEvent;
use App\Entity\Product\ProductVariant;
use Sylius\Bundle\MoneyBundle\Formatter\MoneyFormatterInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Currency\Context\CurrencyContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class SerializerInjectionListener
 * @package Asdoria\SyliusQuickShoppingPlugin\EventListener
 *
 * @author  Philippe Vesin <pve.asdoria@gmail.com>
 */
class ProductVariantEntitySubscriber extends AbstractEntitySubscriber
{
    public function __construct(
        protected RouterInterface $router,
        protected ChannelContextInterface $channelContext,
        protected LocaleContextInterface $localeContext,
        protected CurrencyContextInterface $currencyContext,
        protected MoneyFormatterInterface $moneyFormatter
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
    protected function getImage(ProductVariantInterface $productVariant): ?string
    {
        $images = !$productVariant->getImages()->isEmpty() ?
            $productVariant->getImages() : $productVariant->getProduct()->getImages();

        $image  = $images->first();

        if (!$image instanceof ImageInterface) return null;

        return $this->router->generate(
            'liip_imagine_filter',
            ['path' => $image->getPath(), 'filter' => 'sylius_shop_product_thumbnail'],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    /**
     * @param ProductVariantInterface $productVariant
     *
     * @return mixed
     */
    protected function getSlug(ProductVariantInterface $productVariant): string
    {
        return $this->router->generate(
            'sylius_shop_product_show',
            ['slug' => $productVariant->getProduct()->getSlug(),
             '_locale' => $this->localeContext->getLocaleCode()],
            UrlGeneratorInterface::ABSOLUTE_PATH
        );
    }


    /**
     * @param ProductVariantInterface $productVariant
     *
     * @return mixed
     */
    protected function getPrice(ProductVariantInterface $productVariant): string
    {
        $channel = $this->channelContext->getChannel();
        $amount  = 0;

        if ($channel instanceof ChannelInterface) {
            $channelPricing = $productVariant->getChannelPricingForChannel($channel);
            $amount         = $channelPricing instanceof ChannelPricingInterface ?
                $channelPricing->getPrice() : 0;
        }

        return $this->moneyFormatter->format(
            $amount,
            $this->currencyContext->getCurrencyCode(),
            $this->localeContext->getLocaleCode()
        );
    }
}
