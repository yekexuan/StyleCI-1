<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Exceptions\Transformers;

use AltThree\Validator\ValidationException;
use Exception;
use GrahamCampbell\Exceptions\Transformers\TransformerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * This is the validation transformer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ValidationTransformer implements TransformerInterface
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
        if ($exception instanceof ValidationException) {
            $message = $exception->getMessage();
            $exception = new BadRequestHttpException($message ?: 'Validation has failed.');
        }

        return $exception;
    }
}
