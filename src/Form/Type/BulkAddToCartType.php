<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Form\Type;

use AppBundle\Form\Type\Cart\CartItemChildrenType;
use Asdoria\SyliusQuickShoppingPlugin\Factory\Model\BulkAddToCartCommandFactoryInterface;
use Sylius\Bundle\OrderBundle\Controller\AddToCartCommand;
use Sylius\Bundle\OrderBundle\Form\Type\CartItemType;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderItem;
use Sylius\Component\Order\Context\CartContextInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
/**
 * Class BulkAddToCartType
 * @package Asdoria\SyliusQuickShoppingPlugin\Form\Type
 *
 * @author  Philippe Vesin <pve.asdoria@gmail.com>
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
        array $validationGroups = [])
    {
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
                'entry_options' =>  [
                    'empty_data' => function (FormInterface $form) {
                        return $this->bulkAddToCartCommandFactory->createAddToCartCommand($this->cartContext->getCart());
                    }
                ]
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'asdoria_quick_shopping_bulk_add_to_cart';
    }
}
