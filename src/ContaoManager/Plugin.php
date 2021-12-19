<?php

declare(strict_types=1);

/*
 * This file is part of migration of calendar_feature for Contao Open Source CMS.
 *
 * (c) bwein.net
 *
 * @license MIT
 */

namespace Bwein\MigrateCalendarFeature\ContaoManager;

use Bwein\MigrateCalendarFeature\BweinMigrateCalendarFeatureBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(BweinMigrateCalendarFeatureBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, 'calendar_feature']),
        ];
    }
}
