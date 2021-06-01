<?php
declare(strict_types=1);

namespace Elogic\Weather\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Elogic\Weather\Api\Data\WeatherInterface;
use Magento\Framework\DataObject;

/**
 * Interface WeatherRepositoryInterface
 * @package Elogic\Weather\Api
 */
interface WeatherRepositoryInterface
{
    /**
     * @param WeatherInterface $weather
     * @return WeatherInterface
     */
    public function save(WeatherInterface $weather): WeatherInterface;

    /**
     * @param int $weatherId
     * @return WeatherInterface
     */
    public function getById(int $weatherId): WeatherInterface;

    /**
     * @param SearchCriteriaInterface $searchSearchCriteria
     * @return SearchResults
     */
    public function getList(SearchCriteriaInterface $searchSearchCriteria): SearchResults;

    /**
     * @return DataObject
     */
    public function getLatestRow(): DataObject;

    /**
     * @param WeatherInterface $weather
     * @return bool
     */
    public function delete(WeatherInterface $weather): bool;

    /**
     * @param int $weatherId
     * @return bool
     */
    public function deleteById(int $weatherId): bool;
}
