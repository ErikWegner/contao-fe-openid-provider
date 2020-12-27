<?php

declare(strict_types=1);

/*
 * This file is part of [package name].
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\FeOpenidProvider\Tests;

use ErikWegner\FeOpenidProvider\FeOpenidProviderBundle;
use PHPUnit\Framework\TestCase;

class FeOpenidProviderBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new FeOpenidProviderBundle();

        $this->assertInstanceOf('ErikWegner\FeOpenidProvider\FeOpenidProviderBundle', $bundle);
    }
}
