<?php

namespace App\DataSource;

use App\DataExtractor\QuestionEntityDataExtractorInterface;
use App\Entity\Question;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class QuestionCsvDataSource implements QuestionsDataSourceInterface
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var \SplFileObject
     */
    private $file;

    /**
     * @var bool
     */
    private $dataStartsFrom = -1;

    /**
     * QuestionCsvDataSource constructor.
     * @param ParameterBagInterface $parameterBag
     * @param QuestionEntityDataExtractorInterface $dataExtractor
     */
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private QuestionEntityDataExtractorInterface $dataExtractor,
    ) {
        $this->filePath = $this->parameterBag->get('file_data_source.csv.questions');
        $this->file = new \SplFileObject($this->filePath, 'r');
        $this->file->setFlags(\SplFileObject::READ_CSV);
        while (!$this->isData($this->file->current())) {
            $this->next();
            $this->dataStartsFrom++;
        }
    }

    /**
     * @return Question|mixed
     */
    public function current()
    {
        return $this->dataExtractor->extract($this->file->current(), $this->key());
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->file->next();
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->file->key() - $this->dataStartsFrom;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return
            $this->file->valid()
            && !$this->file->eof()
            && $this->isData($this->file->current());
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->file->rewind();
        while (!$this->isData($this->file->current())) {
            $this->next();
        }
    }

    /**
     * Checks is the given data is a questions record
     * @param array|null $data
     * @return bool
     */
    private function isData(?array $data)
    {
        return
            is_array($data)
            && !empty($data[0])
            && !$this->isHeader($data);
    }

    /**
     * Checks if given array is header
     *
     * @return bool
     */
    private function isHeader(?array $data)
    {
        return in_array(
            'Question text', $this->file->current())
            || in_array('Created At', $this->file->current()
        );
    }
}
