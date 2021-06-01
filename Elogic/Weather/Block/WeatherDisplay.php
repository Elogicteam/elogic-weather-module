<?php

namespace Elogic\Weather\Block;

use Elogic\Weather\Service\WeatherApiService;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class WeatherDisplay extends Template
{
    /**
     * @var WeatherApiService
     */
    protected WeatherApiService $weatherApiService;

    /**
     * WeatherDisplay constructor.
     * @param Context $context
     * @param WeatherApiService $weatherApiService
     */
    public function __construct(
        Context $context,
        WeatherApiService $weatherApiService
    ) {
        $this->weatherApiService = $weatherApiService;
        parent::__construct($context);
    }

    /**
     * @return mixed|null
     */
    public function getWeather()
    {
        return $this->weatherApiService->execute();
    }
}
