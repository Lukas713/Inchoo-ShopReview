<?php

namespace Inchoo\StoreReview\Model\ResourceModel\StoreReview;

use Inchoo\StoreReview\Model\ResourceModel\StoreReview;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            \Inchoo\StoreReview\Model\StoreReview::class,
            StoreReview::class
        );
    }
}
