<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Exceptions\Displayers;

use Exception;
use GrahamCampbell\Exceptions\Displayers\JsonDisplayer;
use GrahamCampbell\Exceptions\ExceptionInfo;
use Illuminate\Http\Request;

/**
 * This is the github displayer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubDisplayer extends JsonDisplayer
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new github displayer instance.
     *
     * @param \GrahamCampbell\Exceptions\ExceptionInfo $info
     * @param \Illuminate\Http\Request                 $request
     *
     * @return void
     */
    public function __construct(ExceptionInfo $info, Request $request)
    {
        parent::__construct($info);
        $this->request = $request;
    }

    /**
     * Can we display the exception?
     *
     * @param \Exception $exception
     *
     * @return bool
     */
    public function canDisplay(Exception $exception)
    {
        return $this->request->is('github-callback');
    }
}
