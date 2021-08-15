<?php

declare(strict_types=1);

/*
 * This file is part of fe-openid-provider.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\FeOpenidProvider\Service;

use ErikWegner\FeOpenidProvider\Repositories\AccessTokenRepository;
use ErikWegner\FeOpenidProvider\Repositories\AuthCodeRepository;
use ErikWegner\FeOpenidProvider\Repositories\RefreshTokenRepository;

class Cron
{
    function onHourly(): void {
        AccessTokenRepository::purgeExpiredTokens();
        AuthCodeRepository::purgeExpiredTokens();
        RefreshTokenRepository::purgeExpiredTokens();
    }
}