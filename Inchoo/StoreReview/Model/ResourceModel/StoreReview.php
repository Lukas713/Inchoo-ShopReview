<?php

namespace Inchoo\StoreReview\Model\ResourceModel;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class StoreReview extends AbstractDb
{
    public function _construct()
    {
        $this->_init(
            StoreReviewInterface::STORE_REVIEW_TABLE_NAME,
            StoreReviewInterface::STORE_REVIEW_ID
        );
    }
}
