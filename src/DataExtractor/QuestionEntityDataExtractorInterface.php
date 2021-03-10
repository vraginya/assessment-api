<?php

namespace App\DataExtractor;

use App\Entity\Question;

interface QuestionEntityDataExtractorInterface extends DataExtractorInterface
{
    public function extract(array $data, $primaryKey): Question;
}
