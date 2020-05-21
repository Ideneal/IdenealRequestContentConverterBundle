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
use Ideneal\Bundle\RequestContentConverterBundle\Tests\Configuration\ConfigurationTestCase;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class ContentParamConverterTest extends ConfigurationTestCase
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

    protected function setUp()
    {
        $this->serializer = $this->getMockBuilder('Symfony\Component\Serializer\Serializer')->getMock();
        $this->validator  = $this->getMockBuilder('Symfony\Component\Validator\Validator\RecursiveValidator')
                                 ->disableOriginalConstructor()
                                 ->getMock()
        ;
        $this->converter  = new ContentParamConverter($this->serializer, $this->validator);
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