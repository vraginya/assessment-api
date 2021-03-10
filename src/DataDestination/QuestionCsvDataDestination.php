<?php

namespace App\DataDestination;

use App\DataExtractor\QuestionEntityDataExtractorInterface;
use App\Entity\Question;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class QuestionCsvDataDestination implements QuestionDataDestinationInterface
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var \SplFileObject
     */
    private $file;

    public function __construct(
        private ParameterBagInterface $parameterBag,
        private QuestionEntityDataExtractorInterface $dataExtractor,
    ) {
        $this->filePath = $this->parameterBag->get('file_data_source.csv.questions');
        $this->file = new \SplFileObject($this->filePath, 'a');
    }

    /**
     * @param $data
     */
    public function persist($data)
    {
        /**
         * @var Question $data
         */

        if (!$data instanceof Question) {
            throw new BadRequestException();
        }

        $persistanceData = [
            $data->getText(),
            $data->getCreatedAt()->format($this->parameterBag->get('format.date_time')),
        ];

        foreach ($data->getChoices() as $choice) {
            $persistanceData[] = $choice->getText();
        }

        if ($a = $this->file->fputcsv($persistanceData)) {
            $data->setId(1);
        }
    }
}
