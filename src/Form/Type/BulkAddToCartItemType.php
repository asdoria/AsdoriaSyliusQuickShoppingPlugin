<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class BulkAddToCartItemType
 */
class BulkAddToCartItemType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('cartItem', CartItemType::class, ['label' => false]);
    }

    /**
     * @inheritdoc
     */
    public function getBlockPrefix(): string
    {
        return 'asdoria_quick_shopping_bulk_add_to_cart_item';
    }
}
