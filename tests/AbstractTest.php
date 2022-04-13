<?php declare(strict_types = 1);

namespace OtherSolution\Klix\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractTest extends TestCase
{
    protected ValidatorInterface $validator;
    protected SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $this->serializer = new Serializer([new GetSetMethodNormalizer()], ['json' => new JsonEncoder()]);
    }
}
