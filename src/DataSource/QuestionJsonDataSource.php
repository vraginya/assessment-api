<?php

namespace App\DataSource;

use App\DataExtractor\QuestionEntityDataExtractorInterface;
use App\Entity\Question;
use JsonMachine\Exception\PathNotFoundException;
use JsonMachine\JsonMachine;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class QuestionJsonDataSource implements QuestionsDataSourceInterface
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var JsonMachine
     */
    private $jsonMachine;

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * QuestionCsvDataSource constructor.
     * @param ParameterBagInterface $parameterBag
     * @param QuestionEntityDataExtractorInterface $dataExtractor
     */
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private QuestionEntityDataExtractorInterface $dataExtractor,
    ) {
        $this->filePath = $this->parameterBag->get('file_data_source.json.questions');
        $this->jsonMachine = JsonMachine::fromFile($this->filePath);
    }

    /**
     * @return \Generator
     * @throws PathNotFoundException
     */
    private function getIterator()
    {
        if ($this->iterator) {
            return $this->iterator;
        }

        $this->iterator = $this->jsonMachine?->getIterator()?->getIterator();

        return $this->iterator;
    }

    /**
     * @return Question|mixed
     * @throws PathNotFoundException
     */
    public function current()
    {
        return $this->dataExtractor->extract((array) $this->getIterator()->current(), $this->key());
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->getIterator()->next();
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->getIterator()->key() + 1;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return  $this->getIterator()->valid();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->getIterator()->rewind();
    }
}
