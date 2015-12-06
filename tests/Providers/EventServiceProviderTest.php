<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Providers;

use AltThree\TestBench\EventServiceProviderTrait;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the event service provider test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EventServiceProviderTest extends AbstractTestCase
{
    use EventServiceProviderTrait;
}
