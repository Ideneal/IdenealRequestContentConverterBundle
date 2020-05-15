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


use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class FormatDoctrineParamConverter
 *
 * @package Ideneal\Bundle\IOBundle\Request\ParamConverter
 * @author  Daniele Pedone <ideneal.ztl@gmail.com>
 */
class FormatDoctrineParamConverter extends DoctrineParamConverter
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
     * FormatDoctrineParamConverter constructor.
     *
     * @param SerializerInterface     $serializer
     * @param ValidatorInterface      $validator
     * @param ManagerRegistry|null    $registry
     * @param ExpressionLanguage|null $expressionLanguage
     * @param array                   $options
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $registry = null, ExpressionLanguage $expressionLanguage = null, array $options = [])
    {
        parent::__construct($registry, $expressionLanguage, array_merge([
            'format'   => null,
            'validate' => true,
        ], $options));
        $this->serializer = $serializer;
        $this->validator  = $validator;
    }

    /**
     * @param Request        $request
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $isApplied = parent::apply($request, $configuration);

        if (!$isApplied) {
            return false;
        }

        $name    = $configuration->getName();
        $class   = $configuration->getClass();
        $options = $configuration->getOptions();
        $object  = $request->attributes->get($name);
        $format  = $options['format'];
        $groups  = isset($options['groups']) ? $options['groups'] : null;

        $object = $this->serializer->deserialize($request->getContent(), $class, $format, [
            'groups'                               => $groups,
            AbstractNormalizer::OBJECT_TO_POPULATE => $object,
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
        $isValidEntity = parent::supports($configuration);
        $options       = $configuration->getOptions();
        return $isValidEntity && isset($options['format']);
    }
}