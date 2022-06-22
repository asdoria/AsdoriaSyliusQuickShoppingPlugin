<p align="center">
</p>


<h1 align="center">Asdoria QuickShopping Bundle</h1>

<p align="center">Simply QuickShopping's Managment into Sylius Shop</p>

## Features

+ Add multiple variants to your shopping cart by name or sku

<div style="max-width: 75%; height: auto; margin: auto">
 
![Add to Cart](doc/addtocart.gif)

![Your shopping](doc/yourshopping.png)

</div>

<div style="max-width: 75%; height: auto; margin: auto">

</div>

 

## Installation

---
1. run `composer require asdoria/sylius-quick-shopping-plugin`


2. Add the bundle in `config/bundles.php`.

```PHP
Asdoria\SyliusQuickShoppingPlugin\AsdoriaSyliusQuickShoppingPlugin::class => ['all' => true],
```

3. Import routes in `config/routes.yaml`

```yaml
asdoria_quick_shopping:
    resource: "@AsdoriaSyliusQuickShoppingPlugin/Resources/config/routing.yaml"
```

4. Import config in `config/packages/_sylius.yaml`
```yaml
imports:
    - { resource: "@AsdoriaSyliusQuickShoppingPlugin/Resources/config/config.yaml"}
```

## Demo

You can try the QuickShopping plugin online by following this link: [here!](https://demo-sylius.asdoria.fr/en_US/quick-shopping) .

## Usage

1. In the shop office, go to /en_US/quick-shopping route.

