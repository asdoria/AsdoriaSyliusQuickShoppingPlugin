<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Repository\Model;

use Sylius\Component\Channel\Model\ChannelInterface;

/**
 * Class ProductVariantRepositoryAwareInterface
 */
interface ProductVariantRepositoryAwareInterface
{
    public function findByPhraseAndChannel(
        string $phrase,
        string $locale,
        ChannelInterface $channel,
        ?int $limit = null,
    ): array;
}
