<?php

namespace App\Serializer;

use App\Entity\Choice;
use App\Exceptions\InvalidJsonFileStructure;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class QuestionSerializer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    /**
     * QuestionSerializer constructor.
     * @param NormalizerInterface $decorated
     */
    public function __construct(
        private NormalizerInterface $decorated,
        private ParameterBagInterface $parameterBag,
    )
    {
        if (!$decorated instanceof DenormalizerInterface) {
            throw new \InvalidArgumentException(sprintf('The decorated normalizer must implement the %s.', DenormalizerInterface::class));
        }
    }

    /**
     * @inheritdoc
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $object = $this->decorated->denormalize($data, $class, $format, $context);
        foreach ((array) $data['choices'] as $choiceData) {
            if (empty($choiceData['text'])) {
                throw new InvalidJsonFileStructure();
            }

            $choice = new Choice();
            $choice->setText($choiceData['text']);
            $object->addChoice($choice);
        }

        return $object;
    }

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $this->decorated->supportsDenormalization($data, $type, $format);
    }

    /**
     * @inheritdoc
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->decorated->normalize($object, $format, $context);
        if (is_array($data)) {
            $data['createdAt'] = $object->getCreatedAt()->format($this->parameterBag->get('format.date_time'));
        }
        unset ($data['id']);

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    /**
     * @inheritdoc
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        if($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }
}
