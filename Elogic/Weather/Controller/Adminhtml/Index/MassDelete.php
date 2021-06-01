<?php
declare(strict_types=1);

namespace Elogic\Weather\Controller\Adminhtml\Index;

use Elogic\Weather\Api\Data\WeatherInterface;
use Elogic\Weather\Api\WeatherRepositoryInterface;
use Elogic\Weather\Model\ResourceModel\Weather\Collection as WeatherCollection;
use Elogic\Weather\Model\ResourceModel\Weather\CollectionFactory as WeatherResourceCollectionFactory;
use Exception;
use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 * @package Elogic\Weather\Controller\Adminhtml\Index
 */
class MassDelete extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Elogic_Weather::weather_mass_delete';

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersistor;

    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * @var Filter
     */
    private Filter $filter;

    /**
     * @var WeatherResourceCollectionFactory
     */
    private WeatherResourceCollectionFactory $collectionFactory;

    /**
     * @param Context $context
     * @param WeatherRepositoryInterface $weatherRepository
     * @param WeatherResourceCollectionFactory $collectionFactory
     * @param Filter $filter
     * @param DataPersistorInterface $dataPersist
     */
    public function __construct(
        Context $context,
        WeatherRepositoryInterface $weatherRepository,
        WeatherResourceCollectionFactory $collectionFactory,
        Filter $filter,
        DataPersistorInterface $dataPersist
    ) {
        $this->dataPersistor = $dataPersist;
        $this->filter = $filter;
        $this->weatherRepository = $weatherRepository;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            /** @var WeatherCollection $collection */
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $count = 0;
            foreach ($collection as $weather) {
                /** @var WeatherInterface $weather */
                if ($this->weatherRepository->delete($weather)) {
                    $count++;
                }
            }
            $message = __('A total of %1 record(s) have been deleted.', $count);
            $this->messageManager->addSuccessMessage($message);
            $this->dataPersistor->clear('row');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException | LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting rows.'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
