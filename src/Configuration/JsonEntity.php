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
 * Class JsonEntity
 *
 * @package Ideneal\Bundle\IOBundle\Configuration
 * @author  Daniele Pedone <ideneal.ztl@gmail.com>
 * @Annotation
 */
class JsonEntity extends EntityFormatParamConverter
{
    /**
     * JsonEntity constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        parent::__construct($values);
        $this->setFormat('json');
    }
}