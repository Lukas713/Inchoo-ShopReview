<?php

namespace Inchoo\StoreReview\Model;

use Magento\Framework\Data\OptionSourceInterface;
use Inchoo\StoreReview\Api\Data\StoreReviewInterface;

class SelectedOptions implements OptionSourceInterface
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
