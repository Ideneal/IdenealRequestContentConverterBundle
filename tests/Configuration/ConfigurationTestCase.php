<?php
/*
 * This file is part of the ideneal/request-content-converter-bundle library
 *
 * (c) Daniele Pedone <ideneal.ztl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ideneal\Bundle\RequestContentConverterBundle\Tests\Configuration;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class ConfigurationTestCase extends TestCase
{
    /**
     * @param null       $class
     * @param array|null $options
     * @param string     $name
     * @param bool       $isOptional
     *
     * @return MockObject
     */
    public function createConfiguration($class = null, array $options = null, $name = 'arg', $isOptional = false)
    {
        $methods = ['getClass', 'getAliasName', 'getOptions', 'getName', 'allowArray'];
        if (null !== $isOptional) {
            $methods[] = 'isOptional';
        }
        $config = $this
            ->getMockBuilder('Ideneal\Bundle\RequestContentConverterBundle\Configuration\ContentParamConverter')
            ->setMethods($methods)
            ->disableOriginalConstructor()
            ->getMock();
        if (null !== $options) {
            $config->expects($this->once())
                   ->method('getOptions')
                   ->willReturn($options);
        }
        if (null !== $class) {
            $config->expects($this->any())
                   ->method('getClass')
                   ->willReturn($class);
        }
        $config->expects($this->any())
               ->method('getName')
               ->willReturn($name);
        if (null !== $isOptional) {
            $config->expects($this->any())
                   ->method('isOptional')
                   ->willReturn($isOptional);
        }

        return $config;
    }
}