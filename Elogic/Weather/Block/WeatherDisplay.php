<?php
declare(strict_types=1);

namespace Elogic\Weather\Block;

use Elogic\Weather\Api\WeatherRepositoryInterface;
use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class WeatherDisplay
 * @package Elogic\Weather\Block
 */
class WeatherDisplay extends Template
{
    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * WeatherDisplay constructor.
     * @param Context $context
     * @param WeatherRepositoryInterface $weatherRepository
     */
    public function __construct(
        Context $context,
        WeatherRepositoryInterface $weatherRepository
    ) {
        $this->weatherRepository = $weatherRepository;
        parent::__construct($context);
    }

    /**
     * @return DataObject
     */
    public function getWeather(): DataObject
    {
        return $this->weatherRepository->getLatestRow();
    }
}
