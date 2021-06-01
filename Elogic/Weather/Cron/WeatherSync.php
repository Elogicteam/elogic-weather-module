<?php
declare(strict_types=1);

namespace Elogic\Weather\Cron;

use Elogic\Weather\Api\Data\WeatherInterface;
use Elogic\Weather\Api\WeatherRepositoryInterface;
use Elogic\Weather\Model\WeatherModelFactory;
use Elogic\Weather\Service\WeatherApiService;

/**
 * Class WeatherSync
 * @package Elogic\Weather\Cron
 */
class WeatherSync
{
    /**
     * @var WeatherApiService
     */
    private WeatherApiService $weatherApiService;

    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * @var WeatherModelFactory
     */
    private WeatherModelFactory $weatherModelFactory;

    /**
     * WeatherSync constructor.
     * @param WeatherApiService $weatherApiService
     * @param WeatherRepositoryInterface $weatherRepository
     * @param WeatherModelFactory $weatherModelFactory
     */
    public function __construct(
        WeatherApiService $weatherApiService,
        WeatherRepositoryInterface $weatherRepository,
        WeatherModelFactory $weatherModelFactory
    ) {
        $this->weatherRepository = $weatherRepository;
        $this->weatherApiService = $weatherApiService;
        $this->weatherModelFactory = $weatherModelFactory;
    }

    public function execute()
    {
        $currentWeather = $this->weatherApiService->execute();
        if (!$currentWeather) {
            return;
        }
        /**
         * @var WeatherInterface $weather
         */
        $weather =  $this->weatherModelFactory->create();
        $weatherVarchar = array_pop($currentWeather['weather']);
        $weather->setTitle($weatherVarchar['main']);
        $weather->setDescription($weatherVarchar['description']);
        $weather->setTemp($currentWeather['main']['temp']);
        $weather->setTempMax($currentWeather['main']['temp_max']);
        $weather->setTempMin($currentWeather['main']['temp_min']);
        $weather->setHumidity($currentWeather['main']['humidity']);
        $weather->setWindSpeed($currentWeather['wind']['speed']);

        $this->weatherRepository->save($weather);
    }
}
