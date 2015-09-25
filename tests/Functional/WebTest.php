<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Functional;

use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the web test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class WebTest extends AbstractTestCase
{
    public function testCanLoadHomepage()
    {
        $this->get('/');

        $this->assertResponseOk();

        $this->see('The PHP Coding Style Continuous Integration Service');
        $this->see('Login with GitHub');
    }

    public function testCanLoadPrivacy()
    {
        $this->get('/privacy');

        $this->assertResponseOk();

        $this->see('Privacy Policy');
    }

    public function testCanLoadTerms()
    {
        $this->get('/terms');

        $this->assertResponseOk();

        $this->see('Terms of Service');
    }

    public function testCanLoadGenericNotFound()
    {
        $this->get('/foo');

        $this->assertResponseStatus(404);

        $this->see('Error 404');
        $this->see('Houston, We Have A Problem.');
    }

    public function testAuthLoginWithBadMethod()
    {
        $this->get('/auth/login');

        $this->assertResponseStatus(405);

        $this->see('Error 405');
        $this->see('Houston, We Have A Problem.');
    }

    public function testAuthLoginWithBadToken()
    {
        $this->post('/auth/login');

        $this->assertResponseStatus(400);

        $this->see('Error 400');
        $this->see('CSRF token validation failed.');
        $this->dontSee('Houston, We Have A Problem.');
    }

    public function testAccountPageWithoutAuth()
    {
        $this->get('/account');

        $this->assertResponseStatus(401);

        $this->see('Error 401');
        $this->see('Houston, We Have A Problem.');
    }
}
