<?php
declare(strict_types=1);

namespace Elogic\Weather\Model\ResourceModel;

use Elogic\Weather\Model\WeatherModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Weather
 * @package Elogic\Weather\Model\ResourceModel
 */
class Weather extends AbstractDb
{
    const WEATHER_TABLE = 'weather';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(
            self::WEATHER_TABLE,
            WeatherModel::ENTITY_ID
        );
    }
}
