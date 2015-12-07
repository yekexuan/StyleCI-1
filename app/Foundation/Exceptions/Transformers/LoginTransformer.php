<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Foundation\Exceptions\Transformers;

use Exception;
use GrahamCampbell\Exceptions\Transformers\TransformerInterface;
use StyleCI\Login\Exceptions\InvalidStateException;
use StyleCI\Login\Exceptions\NoAccessTokenException;
use StyleCI\Login\Exceptions\NoEmailException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * This is the login transformer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class LoginTransformer implements TransformerInterface
{
    /**
     * Transform the provided exception.
     *
     * @param \Exception $exception
     *
     * @return \Exception
     */
    public function transform(Exception $exception)
    {
        if ($exception instanceof InvalidStateException) {
            $exception = new BadRequestHttpException('We were unable to verify that the this request was genuine and actually came from GitHub.');
        }

        if ($exception instanceof NoAccessTokenException) {
            $exception = new HttpException(500, 'GitHub failed to provide us with an access token so we cannot continue.');
        }

        if ($exception instanceof NoEmailException) {
            $exception = new HttpException(500, 'You need to verify your email address on GitHub before using StyleCI.');
        }

        return $exception;
    }
}
