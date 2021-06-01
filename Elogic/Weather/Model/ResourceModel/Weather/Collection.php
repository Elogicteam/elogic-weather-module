<?php
declare(strict_types=1);

namespace Elogic\Weather\Model\ResourceModel\Weather;

use Elogic\Weather\Model\ResourceModel\Weather;
use Elogic\Weather\Model\WeatherModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Elogic\Weather\Model\ResourceModel\Weather
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected $_idFieldName = WeatherModel::ENTITY_ID;

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(
            WeatherModel::class,
            Weather::class
        );
    }
}
