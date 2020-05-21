<?php
/*
 * This file is part of the ideneal/request-content-converter-bundle library
 *
 * (c) Daniele Pedone <ideneal.ztl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ideneal\Bundle\RequestContentConverterBundle\Exception;


use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ConstraintViolationListException
 *
 * @package Ideneal\Bundle\RequestContentConverterBundle\Exception
 * @author  Daniele Pedone <ideneal.ztl@gmail.com>
 */
class ConstraintViolationListException extends HttpException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $constraintViolationList;

    /**
     * ConstraintViolationListException constructor.
     *
     * @param ConstraintViolationListInterface $constraintViolationList
     * @param string|null                      $message
     * @param int                              $statusCode
     * @param \Throwable|null                  $previous
     * @param array                            $headers
     * @param int|null                         $code
     */
    public function __construct(ConstraintViolationListInterface $constraintViolationList, string $message = 'Validation failed.', int $statusCode = 400, \Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
        $this->constraintViolationList = $constraintViolationList;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}