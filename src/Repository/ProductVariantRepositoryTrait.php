<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Repository;

use Sylius\Component\Channel\Model\ChannelInterface;

/**
 * Class ProductVariantRepositoryTrait
 */
trait ProductVariantRepositoryTrait
{
    public function findByPhraseAndChannel(
        string $phrase,
        string $locale,
        ChannelInterface $channel,
        ?int $limit = null,
    ): array {
        $expr = $this->getEntityManager()->getExpressionBuilder();

        return $this->createQueryBuilder('o')
            ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->innerJoin('o.product', 'product')
            ->andWhere($expr->orX(
                'translation.name LIKE :phrase',
                'o.code LIKE :phrase',
            ))
            ->andWhere(':channel MEMBER OF product.channels')
            ->andWhere('product.enabled = :enabled')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('phrase', '%' . $phrase . '%')
            ->setParameter('locale', $locale)
            ->setParameter('channel', $channel)
            ->setParameter('enabled', true)
            ->orderBy('o.product', 'ASC')
            ->addOrderBy('o.position', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
}
