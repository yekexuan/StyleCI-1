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
use StyleCI\StyleCI\Models\Repo;
use StyleCI\StyleCI\Presenters\RepoPresenter;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the repo model test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoTest extends AbstractTestCase
{
    use DatabaseMigrations;

    /**
     * @expectedException \AltThree\Validator\ValidationException
     */
    public function testSaveWithNothing()
    {
        $expected = [
            'The id field is required.',
            'The user id field is required.',
            'The name field is required.',
            'The default branch field is required.',
            'The token field is required.',
        ];

        try {
            Repo::create();
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
            'The default branch field is required.',
            'The token must be 20 characters.',
        ];

        try {
            Repo::create(['id' => 'foo', 'user_id' => 123, 'name' => '123', 'name' => 'Foo/Bar', 'token' => 'qwertyuiop']);
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
            'id'             => 12345,
            'user_id'        => 4242,
            'name'           => 'Foo/Baz',
            'default_branch' => 'lol',
            'updated_at'     => (string) $c,
            'created_at'     => (string) $c
        ];

        $repo = Repo::create(['id' => '12345', 'user_id' => '4242', 'name' => 'Foo/Baz', 'default_branch' => 'lol', 'token' => str_repeat('a', 20)]);

        $this->assertInstanceOf(Repo::class, $repo);
        $this->assertSame($expected, $repo->toArray());
    }

    public function testPresentation()
    {
        $repo = Repo::create(['id' => '12345', 'user_id' => '4242', 'name' => 'Foo/Baz', 'default_branch' => 'lol', 'token' => str_repeat('a', 20)]);

        $presented = AutoPresenter::decorate($repo);

        $this->assertInstanceOf(RepoPresenter::class, $presented);
        $this->assertSame(12345, $presented->id);

        $this->assertSame(['id' => 12345, 'last_analysis' => null, 'name' => 'Foo/Baz', 'default_branch' => 'lol', 'link' => 'https://styleci.io/repos/12345'], $presented->toArray());
    }
}
