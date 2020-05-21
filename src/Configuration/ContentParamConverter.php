<?php
/*
 * This file is part of the ideneal/request-content-converter-bundle library
 *
 * (c) Daniele Pedone <ideneal.ztl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ideneal\Bundle\RequestContentConverterBundle\Configuration;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ContentParamConverter
 *
 * @package Ideneal\Bundle\RequestContentConverterBundle\Configuration
 * @author  Daniele Pedone <ideneal.ztl@gmail.com>
 * @Annotation
 */
class ContentParamConverter extends ParamConverter
{
    /**
     * FormatParamConverter constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        parent::__construct($values);

        $options = $this->getOptions();
        if (!isset($options['validate'])) {
            $this->setValidate(true);
        }
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $options = $this->getOptions();
        $options['format'] = $format;

        $this->setOptions($options);
    }

    /**
     * @param string[] $groups
     */
    public function setGroups(array $groups): void
    {
        $options = $this->getOptions();
        $options['groups'] = $groups;

        $this->setOptions($options);
    }

    /**
     * @param array $validationGroups
     */
    public function setValidation_Groups(array $validationGroups): void
    {
        $options = $this->getOptions();
        $options['validation_groups'] = $validationGroups;

        $this->setOptions($options);
    }

    /**
     * @param bool $validate
     */
    public function setValidate(bool $validate): void
    {
        $options = $this->getOptions();
        $options['validate'] = $validate;

        $this->setOptions($options);
    }
}