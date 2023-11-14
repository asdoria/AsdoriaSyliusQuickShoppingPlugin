<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\Controller\Shop;

use Asdoria\SyliusQuickShoppingPlugin\Factory\Model\BulkAddToCartCommandFactoryInterface;
use Asdoria\SyliusQuickShoppingPlugin\Form\Type\BulkAddToCartType;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\CoreBundle\Checkout\CheckoutStateUrlGeneratorInterface;
use Sylius\Component\Order\Model\OrderItemInterface;
use Sylius\Component\Order\Modifier\OrderModifierInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class QuickShoppingController
{
    public function __construct(
        protected Environment $twig,
        protected FormFactoryInterface $formFactory,
        protected BulkAddToCartCommandFactoryInterface $bulkAddToCartCommandFactory,
        protected ValidatorInterface $validator,
        protected CheckoutStateUrlGeneratorInterface $urlGenerator,
        protected OrderModifierInterface $orderModifier,
        protected EntityManagerInterface $cartManager,
        protected array $validationGroups,
    ) {
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request): Response
    {
        $bulkAddToCartCommand = $this->bulkAddToCartCommandFactory->createWithAddToCartItems(1);
        $form = $this->formFactory->create(
            BulkAddToCartType::class,
            $bulkAddToCartCommand,
        );

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            /** @var BulkAddToCartCommandInterface $bulkAddToCartCommand */
            $bulkAddToCartCommand = $form->getData();
            $cart = $bulkAddToCartCommand->getCart();
            foreach ($form->get('cartItems') as $childForm) {
                /** @var AddToCartCommand $addToCartCommand */
                $addToCartCommand = $childForm->getData();
                $errors = $this->getCartItemErrors($addToCartCommand->getCartItem());
                if (0 < count($errors)) {
                    $this->getAddToCartFormWithErrors($errors, $childForm);
                }
                $this->orderModifier->addToOrder($addToCartCommand->getCart(), $addToCartCommand->getCartItem());
            }

            if ($form->getErrors(true, true)->count() == 0) {
                $this->cartManager->persist($cart);
                $this->cartManager->flush();

                return new RedirectResponse($this->urlGenerator->generateForCart());
            }
        }

        return new Response(
            $this->twig->render(
                '@AsdoriaSyliusQuickShoppingPlugin/Shop/QuickShopping/index.html.twig',
                [
                    'form' => $form->createView(),
                    'errors' => $form->getErrors(true, true),
                ],
            ),
        );
    }

    protected function getCartItemErrors(OrderItemInterface $orderItem): ConstraintViolationListInterface
    {
        return $this->validator
            ->validate($orderItem, null, $this->validationGroups)
        ;
    }

    protected function getAddToCartFormWithErrors(ConstraintViolationListInterface $errors, FormInterface $form): FormInterface
    {
        foreach ($errors as $error) {
            $formSelected = empty($error->getPropertyPath())
                ? $form->get('cartItem')
                : $form->get('cartItem')->get($error->getPropertyPath());

            $formSelected->addError(new FormError((string) $error->getMessage()));
        }

        return $form;
    }
}
