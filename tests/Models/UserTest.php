<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Models;

use AltThree\Validator\ValidationException;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Models\User;
use StyleCI\StyleCI\Presenters\UserPresenter;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the user model test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class UserTest extends AbstractTestCase
{
    use DatabaseMigrations;

    /**
     * @expectedException \AltThree\Validator\ValidationException
     */
    public function testSaveWithNothing()
    {
        $expected = [
            'The id field is required.',
            'The name field is required.',
            'The username field is required.',
            'The email field is required.',
            'The token field is required.',
        ];

        try {
            User::create();
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    /**
     * @expectedException \AltThree\Validator\ValidationException
     */
    public function testSaveWithBadData()
    {
        $expected = [
            'The id must be an integer.',
            'The username field is required.',
            'The email must be a valid email address.',
            'The token must be 40 characters.',
        ];

        try {
            User::create(['id' => 'foo', 'name' => '123', 'username' => '', 'email' => 'lol', 'token' => 'qwertyuiop']);
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    public function testSaveWithGoodData()
    {
        // prevent tests breaking due to rolling into the next second
        Carbon::setTestNow($c = Carbon::now());

        $expected = [
            'id'         => 12345,
            'name'       => 'Foo Baz',
            'username'   => 'baz',
            'email'      => 'baz@foo.com',
            'updated_at' => (string) $c,
            'created_at' => (string) $c,
        ];

        $user = User::create(['id' => '12345', 'name' => 'Foo Baz', 'username' => 'baz', 'email' => 'baz@foo.com', 'token' => str_repeat('a', 40)]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($expected, $user->toArray());
    }

    public function testPresentation()
    {
        $user = User::create(['id' => '12345', 'name' => 'Foo Baz', 'username' => 'baz', 'email' => 'baz@foo.com', 'token' => str_repeat('a', 40)]);

        $presented = AutoPresenter::decorate($user);

        $this->assertInstanceOf(UserPresenter::class, $presented);
        $this->assertSame(12345, $presented->id);
        $this->assertSame('Foo', $presented->first_name);
        $this->assertSame('https://www.gravatar.com/avatar/1f58cc55c53a9a863f6f2c1fb73d1334?size=200', $presented->gravatar);
    }
}
