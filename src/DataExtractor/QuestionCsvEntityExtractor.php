<?php

namespace App\DataExtractor;

use App\Entity\Choice;
use App\Entity\Question;
use App\Exceptions\InvalidPrimaryKeyException;

class QuestionCsvEntityExtractor implements QuestionEntityDataExtractorInterface
{
    /**
     * Transforms question data from csv file where data array has the following structure:
     * 0 => text
     * 1 => createdAt
     * 2 and others => choice text
     *
     * @param array $data
     * @param $primaryKey
     * @return Question
     * @throws InvalidPrimaryKeyException
     */
    public function extract(array $data, $primaryKey): Question
    {
        if (!is_integer($primaryKey)) {
            throw new InvalidPrimaryKeyException('Private key should be an integer value');
        }
        $entity = new Question($primaryKey);
        $choiceId = 1;
        foreach ($data as $key => $value) {
            switch ($key) {
                case 0:
                    $entity->setText($value);
                    break;
                case 1:
                    $entity->setCreatedAt(new \DateTime($value));
                    break;
                default:
                    $choice = new Choice($choiceId++);
                    $choice->setText($value);
                    $entity->addChoice($choice);
            }
        }

        return $entity;
    }
}
