<?php
declare(strict_types=1);

namespace Elogic\Weather\Model;

use Exception;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Elogic\Weather\Api\WeatherRepositoryInterface;
use Elogic\Weather\Api\Data\WeatherInterface;
use Elogic\Weather\Model\ResourceModel\Weather\Collection;
use Elogic\Weather\Model\ResourceModel\Weather\CollectionFactory as WeatherCollectionFactory;
use Elogic\Weather\Model\ResourceModel\Weather as WeatherResource;

/**
 * Class WeatherRepository
 */
class WeatherRepository implements WeatherRepositoryInterface
{
    /**
     * @var WeatherModelFactory
     */
    private WeatherModelFactory $weatherModelFactory;

    /**
     * @var WeatherCollectionFactory
     */
    private WeatherCollectionFactory $weatherCollectionFactory;

    /**
     * @var WeatherResource
     */
    private WeatherResource $resource;

    /**
     * @type SearchResultsInterfaceFactory
     */
    private SearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @type CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @param WeatherModelFactory $weatherModelFactory
     * @param WeatherCollectionFactory $weatherCollectionFactory
     * @param WeatherResource $resource
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        WeatherModelFactory $weatherModelFactory,
        WeatherCollectionFactory $weatherCollectionFactory,
        WeatherResource $resource,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->weatherModelFactory = $weatherModelFactory;
        $this->weatherCollectionFactory = $weatherCollectionFactory;
        $this->resource = $resource;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     * @throws CouldNotSaveException
     */
    public function save(WeatherInterface $weather): WeatherInterface
    {
        try {
            /** @var  WeatherModel|WeatherInterface $weather */
            $this->resource->save($weather);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $weather;
    }

    /**
     * @inheritDoc
     * @throws NoSuchEntityException
     */
    public function getById(int $weatherId): WeatherInterface
    {
        /** @var  WeatherModel|WeatherInterface $weather */
        $weather = $this->weatherModelFactory->create();
        $this->resource->load($weather, $weatherId);
        if (!$weather->getId()) {
            throw new NoSuchEntityException(
                __('Weather entity with id `%1` does not exist.' . $weatherId, $weatherId)
            );
        }

        return $weather;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults
    {
        $collection = $this->weatherCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var SearchResults $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getData());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function getLatestRow(): DataObject
    {
        /** @var Collection $collection */
        return $this->weatherCollectionFactory->create()
            ->getLastItem();
    }

    /**
     * @inheritDoc
     * @throws CouldNotDeleteException
     */
    public function delete(WeatherInterface $weather): bool
    {
        try {
            /** @var WeatherModel $weather */
            $this->resource->delete($weather);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @inheritDoc
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $weatherId): bool
    {
        try {
            $delete = $this->delete($this->getById($weatherId));
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return $delete;
    }
}
