<?php

namespace designerei\ContaoLayoutBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use designerei\ContaoLayoutBundle\ContaoLayoutBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoLayoutBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}