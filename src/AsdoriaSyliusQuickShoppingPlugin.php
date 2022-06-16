<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AsdoriaSyliusQuickShoppingPlugin
 * @package Asdoria\SyliusQuickShoppingPlugin
 *
 * @author  Philippe Vesin <pve.asdoria@gmail.com>
 */
final class AsdoriaSyliusQuickShoppingPlugin extends Bundle
{
    use SyliusPluginTrait;
}
