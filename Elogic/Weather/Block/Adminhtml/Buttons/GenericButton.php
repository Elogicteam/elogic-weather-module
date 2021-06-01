<?php
declare(strict_types=1);

namespace Elogic\Weather\Block\Adminhtml\Buttons;

use Elogic\Weather\Api\Data\WeatherInterface;
use Elogic\Weather\Api\WeatherRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Logger\Handler\Exception;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    private Context $context;

    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * @param Context $context
     * @param WeatherRepositoryInterface $weatherRepository
     */
    public function __construct(
        Context $context,
        WeatherRepositoryInterface $weatherRepository
    ) {
        $this->context = $context;
        $this->weatherRepository = $weatherRepository;
    }

    /**
     * @return int|null
     */
    public function getRowId(): ?int
    {
        try {
            $request = $this->context->getRequest();
            $rowID = (int)$request->getParam(WeatherInterface::ENTITY_ID);
            return (int)$this->weatherRepository->getById($rowID)->getId();
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
