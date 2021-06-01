<?php
declare(strict_types=1);

namespace Elogic\Weather\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Elogic\Weather\Helper
 */
class Data extends AbstractHelper
{
    const XML_PATH_ELOGIC = 'weather_section/';

    /**
     * @param $field
     * @param null $storeId
     * @return string|null
     */
    public function getConfigValue($field, $storeId = null): ?string
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param $code
     * @param null $storeId
     * @return string|null
     */
    public function getGeneralConfig($code, $storeId = null): ?string
    {
        return $this->getConfigValue(self::XML_PATH_ELOGIC .'general/'. $code, $storeId);
    }
}
