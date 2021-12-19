<?php

declare(strict_types=1);

/*
 * This file is part of migration of calendar_feature for Contao Open Source CMS.
 *
 * (c) bwein.net
 *
 * @license MIT
 */

namespace Bwein\MigrateCalendarFeature;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BweinMigrateCalendarFeatureBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
