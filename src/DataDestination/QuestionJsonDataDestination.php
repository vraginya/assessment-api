<?php

namespace App\DataDestination;

use App\DataExtractor\QuestionEntityDataExtractorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class QuestionJsonDataDestination implements QuestionDataDestinationInterface
{
    /**
     * @param $data
     */
    public function persist($data)
    {
        //TODO: Implement the functionality of saving data to the json file
    }
}
