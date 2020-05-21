<?php
/*
 * This file is part of the ideneal/request-content-converter-bundle library
 *
 * (c) Daniele Pedone <ideneal.ztl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ideneal\Bundle\RequestContentConverterBundle\Request\ParamConverter;


use Ideneal\Bundle\RequestContentConverterBundle\Exception\ConstraintViolationListException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Trait ParamConverterValidationTrait
 *
 * @package Ideneal\Bundle\RequestContentConverterBundle\Request\ParamConverter
 * @author  Daniele Pedone <ideneal.ztl@gmail.com>
 */
trait ParamConverterValidationTrait
{
    /**
     * @param array $options
     *
     * @return bool
     */
    public function shouldValidate(array $options): bool
    {
        return isset($options['validate']) ? boolval($options['validate']) : false;
    }

    /**
     * @param mixed $object
     * @param array $options
     */
    public function validate($object, array $options): void
    {
        if (!property_exists($this, 'validator') || !$this->validator instanceof ValidatorInterface) {
            return;
        }

        $validationGroups = isset($options['validation_groups']) ? $options['validation_groups'] : null;
        $violationList    = $this->validator->validate($object, null, $validationGroups);

        if (count($violationList) > 0) {
            throw new ConstraintViolationListException($violationList);
        }
    }
}