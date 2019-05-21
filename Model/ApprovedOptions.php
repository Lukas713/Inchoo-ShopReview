<?php

namespace Inchoo\StoreReview\Model;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Magento\Framework\Data\OptionSourceInterface;

class ApprovedOptions implements OptionSourceInterface
{
    public function toOptionArray()
    {
        $options = [];
        $options[] = [
            'label' => 'Yes',
            'value' => StoreReviewInterface::TRUE
        ];
        $options[] = [
            'label' => 'No',
            'value' => StoreReviewInterface::FALSE
        ];

        return $options;
    }
}