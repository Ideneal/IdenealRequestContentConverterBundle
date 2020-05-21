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


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class ContentParamConverter
 *
 * @package Ideneal\Bundle\RequestContentConverterBundle\Request\ParamConverter
 * @author  Daniele Pedone <ideneal.ztl@gmail.com>
 */
class ContentParamConverter implements ParamConverterInterface
{
    use ParamConverterValidationTrait;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * FormatParamConverter constructor.
     *
     * @param SerializerInterface $serializer
     * @param ValidatorInterface  $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator  = $validator;
    }

    /**
     * @param Request        $request
     * @param ParamConverter $configuration
     *
     * @return bool|void
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $name     = $configuration->getName();
        $class    = $configuration->getClass() ?: \stdClass::class;
        $options  = $configuration->getOptions();
        $format   = $options['format'];
        $groups   = isset($options['groups']) ? $options['groups'] : null;

        $object = $this->serializer->deserialize($request->getContent(), $class, $format, [
            'groups' => $groups,
        ]);

        if ($this->shouldValidate($options)) {
            $this->validate($object, $options);
        }

        $request->attributes->set($name, $object);

        return true;
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        $options = $configuration->getOptions();
        return isset($options['format']);
    }
}