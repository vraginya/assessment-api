<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\DataDestination\QuestionDataDestinationInterface;
use App\Entity\Question;

class QuestionFileDataPersister implements DataPersisterInterface
{
    /**
     * QuestionFileDataPersister constructor.
     * @param QuestionDataDestinationInterface $dataDestination
     */
    public function __construct(
        private QuestionDataDestinationInterface $dataDestination
    ) {
    }

    /**
     * @param $data
     * @return bool
     */
    public function supports($data): bool
    {
        return $data instanceof Question;
    }

    /**
     * @param $data
     * @return object|void
     */
    public function persist($data)
    {
        return $this->dataDestination->persist($data);
    }

    /**
     * @param $data
     */
    public function remove($data)
    {
        //TODO: Can be implemented as a part of CRUD
    }
}
