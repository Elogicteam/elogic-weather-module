<?php
declare(strict_types=1);

namespace Elogic\Weather\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Measurement
 * @package Elogic\Weather\Model\Config\Source
 */
class Measurement implements OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'standard', 'label' => __('Standard')],
            ['value' => 'metric', 'label' => __('Metric')],
            ['value' => 'imperial', 'label' => __('Imperial')]
        ];
    }
}
