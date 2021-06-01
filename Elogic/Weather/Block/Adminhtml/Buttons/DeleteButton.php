<?php
declare(strict_types=1);

namespace Elogic\Weather\Block\Adminhtml\Buttons;

use Elogic\Weather\Api\Data\WeatherInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 * @package Elogic\Weather\Block\Adminhtml\Buttons
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $data = [];
        $rowId = $this->getRowId();
        if ($rowId) {
            $data = [
                'label' => __('Delete row'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl($rowId) . '\')',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * @param int|string
     * @return string
     */
    public function getDeleteUrl($rowId): string
    {
        return $this->getUrl('*/*/delete', [WeatherInterface::ENTITY_ID => $rowId]);
    }
}
