<?php

namespace App\Service;

use App\Entity\Truck;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiService
{
    private ValidatorInterface $validator;
    private EntityManagerInterface $em;

    public function __construct(ValidatorInterface $validator, EntityManagerInterface $em)
    {
        $this->validator = $validator;
        $this->em = $em;
    }

    public function validateEntity($entity): ?JsonResponse
    {
        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            $errMessages = [];
            /** @var ConstraintViolationInterface $error */
            foreach ($errors as $error) {
                $errMessages[] = $error->getMessage();
            }

            return new JsonResponse([
                'success' => true,
                'errorMsgs' => $errMessages,
            ], 400);
        }

        return null;
    }

    public function setProperties($data, $entity)
    {
        foreach ($data as $property => $value) {
            $metaData = $this->em->getClassMetadata(Truck::class)->fieldMappings;

            if (isset($metaData[$property])) {
                $methodName = 'set' . ucfirst($property);

                if (!method_exists(Truck::class, $methodName)) {
                    continue;
                }

                switch ($metaData[$property]['type']) {
                    case 'string':
                        $entity->$methodName((string)$value);
                        break;
                    case 'integer':
                        $entity->$methodName((int)$value);
                        break;
                    case 'decimal':
                        $entity->$methodName((float)$value);
                        break;
                    case 'bool':
                        $entity->$methodName((bool)$value);
                        break;
                }
            }
        }

        return $entity;
    }
}