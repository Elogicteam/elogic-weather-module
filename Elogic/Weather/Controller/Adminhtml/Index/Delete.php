<?php
declare(strict_types=1);

namespace Elogic\Weather\Controller\Adminhtml\Index;

use Exception;
use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Elogic\Weather\Api\Data\WeatherInterface;
use Elogic\Weather\Api\WeatherRepositoryInterface;

/**
 * Class Delete
 * @package Elogic\Weather\Controller\Adminhtml\Index
 */
class Delete extends BackendAction implements HttpGetActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Elogic_Weather::weather_delete';

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersist;

    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * @param Context $context
     * @param WeatherRepositoryInterface $weatherRepository
     * @param DataPersistorInterface $dataPersist
     */
    public function __construct(
        Context $context,
        WeatherRepositoryInterface $weatherRepository,
        DataPersistorInterface $dataPersist
    ) {
        $this->dataPersist = $dataPersist;
        $this->weatherRepository = $weatherRepository;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam(WeatherInterface::ENTITY_ID);

        try {
            $this->weatherRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('You deleted the row'));
            $this->dataPersist->clear('row');
            return $resultRedirect->setPath('*/*/');
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting the row.'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
