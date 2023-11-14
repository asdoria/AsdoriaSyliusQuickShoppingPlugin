<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Form\Type;

use Asdoria\SyliusQuickShoppingPlugin\Factory\Model\BulkAddToCartCommandFactoryInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class BulkAddToCartType
 */
class BulkAddToCartType extends AbstractResourceType
{
    /**
     * @param string $dataClass FQCN
     * @param string[] $validationGroups
     */
    public function __construct(
        protected CartContextInterface $cartContext,
        protected BulkAddToCartCommandFactoryInterface $bulkAddToCartCommandFactory,
        string $dataClass,
        array $validationGroups = [],
    ) {
        parent::__construct($dataClass, $validationGroups);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cartItems', CollectionType::class, [
                'entry_type' => BulkAddToCartItemType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => [
                    'empty_data' => function (FormInterface $form) {
                        /** @var OrderInterface $cart */
                        $cart = $this->cartContext->getCart();

                        return $this->bulkAddToCartCommandFactory->createAddToCartCommand($cart);
                    },
                ],
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'asdoria_quick_shopping_bulk_add_to_cart';
    }
}
