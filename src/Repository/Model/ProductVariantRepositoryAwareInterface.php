<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Repository\Model;

use Sylius\Component\Channel\Model\ChannelInterface;

/**
 * Class ProductVariantRepositoryAwareInterface
 *
 * @author Philippe Vesin <pve.asdoria@gmail.com>
 */
interface ProductVariantRepositoryAwareInterface
{
    /**
     * @param string           $phrase
     * @param string           $locale
     * @param ChannelInterface $channel
     * @param int|null         $limit
     *
     * @return array
     */
    public function findByPhraseAndChannel(
        string $phrase,
        string $locale,
        ChannelInterface $channel,
        ?int $limit = null
    ): array;
}
