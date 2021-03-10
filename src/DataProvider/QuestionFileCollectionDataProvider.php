<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\DataSource\QuestionsDataSourceInterface;
use App\Entity\Question;

final class QuestionFileCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * QuestionFileCollectionDataProvider constructor.
     * @param QuestionsDataSourceInterface $dataSource
     */
    public function __construct(private QuestionsDataSourceInterface $dataSource)
    {
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Question::class === $resourceClass;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     * @return iterable
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        foreach ($this->dataSource as $question) {
            yield $question;
        }
    }
}
