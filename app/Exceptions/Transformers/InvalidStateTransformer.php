<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Exceptions\Transformers;

use Exception;
use GrahamCampbell\Exceptions\Transformers\TransformerInterface;
use StyleCI\Login\Exceptions\InvalidStateException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * This is the invalid state transformer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class InvalidStateTransformer implements TransformerInterface
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

        return $exception;
    }
}
