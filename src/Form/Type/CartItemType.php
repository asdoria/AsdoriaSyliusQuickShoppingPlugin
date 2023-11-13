<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Form\Type;

use Sylius\Bundle\OrderBundle\Form\Type\CartItemType as BaseCartItemType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class CartItemType
 */
class CartItemType extends BaseCartItemType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('quantity')
            ->add('quantity', IntegerType::class, [
                'attr' => ['min' => 1],
                'label' => 'sylius.ui.quantity',
                'constraints' => [
                    new NotBlank(['groups' => 'sylius']),
                    new GreaterThanOrEqual(['groups' => 'sylius', 'value' => 1]),
                ],
            ])
            ->add('variant', ResourceAutocompleteChoiceType::class, [
                    'label' => 'sylius.ui.variant',
                    'multiple' => false,
                    'required' => true,
                    'choice_name' => 'descriptor',
                    'choice_value' => 'code',
                    'resource' => 'sylius.product_variant',
                    'constraints' => [
                        new NotBlank(['groups' => 'sylius']),
                    ],
            ]);
    }

    public function getBlockPrefix(): string
    {
        return 'asdoria_quick_shopping_cart_item';
    }
}
