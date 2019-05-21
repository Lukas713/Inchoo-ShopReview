<?php

namespace Inchoo\StoreReview\Model;

use Magento\Framework\Data\OptionSourceInterface;

class ApprovedOptions implements OptionSourceInterface
{
    public function toOptionArray()
    {
        $options = [];
        $options[] = [
            'label' => 'Yes',
            'value' => true
        ];
        $options[] = [
            'label' => 'No',
            'value' => false
        ];

        return $options;
    }
}