<?php

namespace App\DataExtractor;

use App\Entity\Choice;
use App\Entity\Question;
use App\Exceptions\InvalidJsonFileStructure;
use App\Exceptions\InvalidPrimaryKeyException;

class QuestionJsonEntityExtractor implements QuestionEntityDataExtractorInterface
{
    /**
     * Transforms question data from json file
     *
     * @param array $data
     * @param $primaryKey
     * @return Question
     * @throws InvalidJsonFileStructure
     * @throws InvalidPrimaryKeyException
     */
    public function extract(array $data, $primaryKey): Question
    {
        if (!is_integer($primaryKey)) {
            throw new InvalidPrimaryKeyException('Private key should be an integer value');
        }
        $entity = new Question($primaryKey);
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'text':
                    $entity->setText($value);
                    break;
                case 'createdAt':
                    $entity->setCreatedAt(new \DateTime($value));
                    break;
                case 'choices':
                    $this->setChoices($entity, $value);
                    break;
                default:
                    throw new InvalidJsonFileStructure();
            }
        }

        return $entity;
    }

    /**
     * @param Question $entity
     * @param array $data Data should has the following structure
     * [
     *      ['text' => 'choice 1'],
     *      ['text' => 'choice 2'],
     *      ['text' => 'choice 3'],
     * ]
     * @return Question
     * @throws InvalidJsonFileStructure
     */
    private function setChoices(Question $entity, array $data): Question
    {
        foreach ($data as $key => $value) {
            if (!isset($value['text'])) {
                throw new InvalidJsonFileStructure();
            }
            $choice = new Choice();
            $choice->setText($value['text']);
            $entity->addChoice($choice);
        }

        return $entity;
    }
}
