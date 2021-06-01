<?php
declare(strict_types=1);

namespace Elogic\Weather\Controller\Adminhtml\Index;

use Elogic\Weather\Api\Data\WeatherInterface;
use Elogic\Weather\Api\WeatherRepositoryInterface;
use Elogic\Weather\Model\WeatherModelFactory;
use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Save
 * @package Elogic\Weather\Controller\Adminhtml\Index
 */
class Save extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Elogic_weather::weather_save';

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersist;

    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * @var WeatherInterface
     */
    private $weatherFactory;

    /**
     * @param Context $context
     * @param WeatherRepositoryInterface $weatherRepository
     * @param WeatherModelFactory $weatherFactory
     * @param DataPersistorInterface $dataPersist
     */
    public function __construct(
        Context $context,
        WeatherRepositoryInterface $weatherRepository,
        WeatherModelFactory $weatherFactory,
        DataPersistorInterface $dataPersist
    ) {
        $this->dataPersist = $dataPersist;
        $this->weatherRepository = $weatherRepository;
        $this->weatherFactory = $weatherFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        /** @var HttpRequest $request */
        $request = $this->getRequest();
        $data = $request->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam(WeatherInterface::ENTITY_ID);
            if (empty($data[WeatherInterface::ENTITY_ID])) {
                $data[WeatherInterface::ENTITY_ID] = null;
            }

            if ($id) {
                /** @var WeatherInterface $model */
                $model = $this->weatherRepository->getById((int)$id);
            } else {
                /** @var WeatherInterface $model */
                $model = $this->weatherFactory->create();
            }
            $model->setData($data);

            try {
                $this->weatherRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the row.'));
                $this->dataPersist->clear('row');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [WeatherInterface::ENTITY_ID => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the row.'));
            }

            $this->dataPersist->set('vendor', $data);
            return $resultRedirect->setPath('*/*/edit', [WeatherInterface::ENTITY_ID => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
