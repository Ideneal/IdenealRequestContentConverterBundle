<?php
/*
 * This file is part of the ideneal/io-bundle library
 *
 * (c) Daniele Pedone <ideneal.ztl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ideneal\Bundle\IOBundle\Configuration;


/**
 * Class EntityFormatParamConverter
 *
 * @package Ideneal\Bundle\IOBundle\Configuration
 * @author  Daniele Pedone <ideneal.ztl@gmail.com>
 * @Annotation
 */
class EntityFormatParamConverter extends FormatParamConverter
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