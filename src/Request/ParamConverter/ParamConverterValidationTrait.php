<?php
/*
 * This file is part of the ideneal/io-bundle library
 *
 * (c) Daniele Pedone <ideneal.ztl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ideneal\Bundle\IOBundle\Request\ParamConverter;


use Ideneal\Bundle\IOBundle\Exception\ConstraintViolationListException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Trait ParamConverterValidationTrait
 *
 * @package Ideneal\Bundle\IOBundle\Request\ParamConverter
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
        $errors           = $this->validator->validate($object, null, $validationGroups);

        if (count($errors) > 0) {
            throw new ConstraintViolationListException($errors);
        }
    }
}