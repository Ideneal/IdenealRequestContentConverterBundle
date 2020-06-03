<?php
/*
 * This file is part of the ideneal/request-content-converter-bundle library
 *
 * (c) Daniele Pedone <ideneal.ztl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ideneal\Bundle\RequestContentConverterBundle\Tests\Request\ParamConverter;


use Ideneal\Bundle\RequestContentConverterBundle\Request\ParamConverter\ContentParamConverter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class ContentParamConverterTest extends TestCase
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var RecursiveValidator
     */
    private $validator;

    /**
     * @var ContentParamConverter
     */
    private $converter;

    protected function setUp(): void
    {
        $this->serializer = $this->getMockBuilder('Symfony\Component\Serializer\Serializer')->getMock();
        $this->validator  = $this->getMockBuilder('Symfony\Component\Validator\Validator\RecursiveValidator')
                                 ->disableOriginalConstructor()
                                 ->getMock()
        ;
        $this->converter  = new ContentParamConverter($this->serializer, $this->validator);
    }

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

    public function testSupports()
    {
        $config      = $this->createConfiguration(null, ['format' => 'json']);
        $isSupported = $this->converter->supports($config);
        $this->assertTrue($isSupported, 'Should be supported');
    }

    public function testSupportWithoutFormat()
    {
        $configuration = $this->createConfiguration();
        $isSupported = $this->converter->supports($configuration);
        $this->assertFalse($isSupported, 'Should not be supported');
    }
}