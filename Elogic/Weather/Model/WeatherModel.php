<?php
declare(strict_types=1);

namespace Elogic\Weather\Model;

use Elogic\Weather\Api\Data\WeatherInterface;
use Elogic\Weather\Model\ResourceModel\Weather as WeatherResource;
use Magento\Framework\Model\AbstractModel;

/**
 * Class WeatherModel
 * @package Elogic\Weather\Model
 */
class WeatherModel extends AbstractModel implements WeatherInterface
{

    public function _construct()
    {
        $this->_init(WeatherResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getTemp(): ?float
    {
        return (float)$this->getData(self::TEMP);
    }

    /**
     * @inheritDoc
     */
    public function setTemp($temp): WeatherInterface
    {
        return $this->setData(self::TEMP, $temp);
    }

    /**
     * @inheritDoc
     */
    public function getTempMin(): ?float
    {
        return (float)$this->getData(self::TEMP_MIN);
    }

    /**
     * @inheritDoc
     */
    public function setTempMin($tempMin): WeatherInterface
    {
        return $this->setData(self::TEMP_MIN, $tempMin);
    }

    /**
     * @inheritDoc
     */
    public function getTempMax(): ?float
    {
        return (float)$this->getData(self::TEMP_MAX);
    }

    /**
     * @inheritDoc
     */
    public function setTempMax($tempMax): WeatherInterface
    {
        return $this->setData(self::TEMP_MAX, $tempMax);
    }

    /**
     * @inheritDoc
     */
    public function getHumidity(): ?int
    {
        return (int)$this->getData(self::HUMIDITY);
    }

    /**
     * @inheritDoc
     */
    public function setHumidity($humidity): WeatherInterface
    {
        return $this->setData(self::HUMIDITY, $humidity);
    }

    /**
     * @inheritDoc
     */
    public function getWindSpeed(): ?float
    {
        return (float)$this->getData(self::WIND_SPEED);
    }

    /**
     * @inheritDoc
     */
    public function setWindSpeed($windSpeed): WeatherInterface
    {
        return $this->setData(self::WIND_SPEED, $windSpeed);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle($title): WeatherInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription($description): WeatherInterface
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getDate(): ?string
    {
        return $this->getData(self::DATE);
    }


    /**
     * @inheritDoc
     */
    public function setDate($date): WeatherInterface
    {
        return $this->setData(self::DATE, $date);
    }
}
