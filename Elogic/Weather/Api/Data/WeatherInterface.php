<?php
declare(strict_types=1);

namespace Elogic\Weather\Api\Data;

/**
 * Interface WeatherInterface
 * @package Elogic\Weather\Api\Data
 */
interface WeatherInterface
{
    const ENTITY_ID = 'entity_id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const TEMP = 'temp';
    const TEMP_MIN = 'temp_min';
    const TEMP_MAX = 'temp_max';
    const HUMIDITY = 'humidity';
    const WIND_SPEED = 'wind_speed';
    const DATE = 'date';

    /**
     * @return float
     */
    public function getTemp(): ?float;

    /**
     * @param float $temp
     * @return WeatherInterface
     */
    public function setTemp(float $temp): WeatherInterface;

    /**
     * @return float
     */
    public function getTempMin(): ?float;

    /**
     * @param float $tempMin
     * @return WeatherInterface
     */
    public function setTempMin(float $tempMin): WeatherInterface;

    /**
     * @return float
     */
    public function getTempMax(): ?float;

    /**
     * @param float $tempMax
     * @return WeatherInterface
     */
    public function setTempMax(float $tempMax): WeatherInterface;

    /**
     * @return int
     */
    public function getHumidity(): ?int;

    /**
     * @param int $humidity
     * @return WeatherInterface
     */
    public function setHumidity(int $humidity): WeatherInterface;

    /**
     * @return float
     */
    public function getWindSpeed(): ?float;

    /**
     * @param float $windSpeed
     * @return WeatherInterface
     */
    public function setWindSpeed(float $windSpeed): WeatherInterface;

    /**
     * @return string
     */
    public function getTitle(): ?string;

    /**
     * @param string $title
     * @return WeatherInterface
     */
    public function setTitle(string $title): WeatherInterface;

    /**
     * @return string
     */
    public function getDescription(): ?string;

    /**
     * @param string $description
     * @return WeatherInterface
     */
    public function setDescription(string $description): WeatherInterface;

    /**
     * @return string
     */
    public function getDate(): ?string;

    /**
     * @param string $date
     * @return WeatherInterface
     */
    public function setDate(string $date): WeatherInterface;
}
