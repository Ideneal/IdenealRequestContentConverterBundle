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


/**
 * Class EntityContentParamConverter
 *
 * @package Ideneal\Bundle\RequestContentConverterBundle\Configuration
 * @author  Daniele Pedone <ideneal.ztl@gmail.com>
 * @Annotation
 */
class EntityContentParamConverter extends ContentParamConverter
{
    /**
     * @param string $expr
     */
    public function setExpr(string $expr): void
    {
        $options = $this->getOptions();
        $options['expr'] = $expr;

        $this->setOptions($options);
    }
}