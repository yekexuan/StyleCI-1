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
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\StyleCI\Presenters\AnalysisPresenter;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the analysis model test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisTest extends AbstractTestCase
{
    use DatabaseMigrations;

    /**
     * @expectedException \AltThree\Validator\ValidationException
     */
    public function testSaveWithNothing()
    {
        $expected = [
            'The repo id field is required.',
            'The commit field is required.',
            'The message field is required.',
            'The status field is required.',
            'The hidden field is required.',
        ];

        try {
            Analysis::create();
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
            'The repo id field is required.',
            'The commit must be 40 characters.',
            'The status must be between 0 and 9.',
            'The hidden field must be true or false.',
        ];

        try {
            Analysis::create(['branch' => 'test', 'commit' => 'trololol', 'message' => 'lol', 'status' => -100, 'hidden' => 12]);
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    /**
     * @expectedException \AltThree\Validator\ValidationException
     */
    public function testSaveWithBadDataAgain()
    {
        $expected = [
            'You must provide either a branch or a pr.',
        ];

        try {
            Analysis::create(['repo_id' => 12345, 'branch' => 'test', 'pr' => 7, 'commit' => str_repeat('a', 40), 'message' => 'Test 123!', 'status' => 2, 'hidden' => 0]);
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    /**
     * @expectedException \AltThree\Validator\ValidationException
     */
    public function testSaveWithBadDataAnotherTime()
    {
        $expected = [
            'Errors are only allowed for some status codes.',
        ];

        try {
            Analysis::create(['repo_id' => 12345, 'branch' => 'test', 'commit' => str_repeat('a', 40), 'message' => 'Test 123!', 'status' => 2, 'error' => 'Foo', 'hidden' => 0]);
        } catch (ValidationException $e) {
            $this->assertSame($expected, $e->getMessageBag()->all());

            throw $e;
        }
    }

    /**
     * @expectedException \AltThree\Validator\ValidationException
     */
    public function testSaveWithBadDataYetAgain()
    {
        $expected = [
            'You must provide either a branch or a pr.',
            'Errors are only allowed for some status codes.',
        ];

        try {
            Analysis::create(['repo_id' => 12345, 'commit' => str_repeat('a', 40), 'message' => 'Test 123!', 'status' => 2, 'errors' => 'Bar', 'hidden' => 0]);
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
            'repo_id'    => 12345,
            'branch'     => 'test',
            'commit'     => str_repeat('a', 40),
            'message'    => 'Test 123!',
            'status'     => 2,
            'hidden'     => false,
            'updated_at' => (string) $c,
            'created_at' => (string) $c,
            'id'         => 1,
        ];

        $analysis = Analysis::create(['repo_id' => 12345, 'branch' => 'test', 'commit' => str_repeat('a', 40), 'message' => 'Test 123!', 'status' => 2, 'hidden' => 0]);

        $this->assertInstanceOf(Analysis::class, $analysis);
        $this->assertSame($expected, $analysis->toArray());
    }

    public function testPresentation()
    {
        $analysis = Analysis::create(['repo_id' => 12345, 'branch' => 'test', 'commit' => str_repeat('a', 40), 'message' => 'Test 123!', 'status' => 2, 'hidden' => 1]);

        $presented = AutoPresenter::decorate($analysis);

        $this->assertInstanceOf(AnalysisPresenter::class, $presented);
        $this->assertSame('xkXG8Z', $presented->id);
        $this->assertSame('PASSED', $presented->summary);
        $this->assertSame('The StyleCI analysis has passed', $presented->description);
        $this->assertSame('fa fa-check-circle', $presented->icon);
        $this->assertSame('green', $presented->color);
        $this->assertFalse($presented->has_diff);
    }
}
