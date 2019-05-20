<?php

namespace Inchoo\StoreReview\Model;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Model\StoreManager;

class StoreViewOptions implements OptionSourceInterface
{
    /**
     * @var StoreManager
     */
    private $storeManager;

    public function __construct
    (
        StoreManager $storeManager
    )
    {
        $this->storeManager = $storeManager;
    }

    public function toOptionArray()
    {
        $options = [];
        $stores = $this->storeManager->getStores();
        foreach($stores as $store){
            $options[] = [
                'label' => $store->getName(),
                'value' => $store->getId()
            ];
        }
        return $options;
    }
}