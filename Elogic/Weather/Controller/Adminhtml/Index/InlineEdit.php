<?php
declare(strict_types=1);

namespace Elogic\Weather\Controller\Adminhtml\Index;

use Elogic\Weather\Api\Data\WeatherInterface;
use Elogic\Weather\Api\WeatherRepositoryInterface;
use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class InlineEdit
 * @package Elogic\Weather\Controller\Adminhtml\Index
 */
class InlineEdit extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Elogic_Weather::weather_inline_edit';

    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonFactory;

    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * @param Context $context
     * @param WeatherRepositoryInterface $weatherRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        WeatherRepositoryInterface $weatherRepository,
        JsonFactory $jsonFactory
    ) {
        $this->weatherRepository = $weatherRepository;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (empty($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $id) {
                    try {
                        /** @var WeatherInterface $model */
                        $model = $this->weatherRepository->getById((int)$id);
                        $model->setData(array_merge($model->getData(), $postItems[$id]));
                        $this->weatherRepository->save($model);
                    } catch (\Exception $e) {
                        $messages[] = $e->getMessage();
                        $error = true;
                    }
                }
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
