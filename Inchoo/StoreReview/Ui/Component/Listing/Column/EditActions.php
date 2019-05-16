<?php

namespace Inchoo\StoreReview\Ui\Component\Listing\Column;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class EditActions extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }
        foreach ($dataSource['data']['items'] as & $item) {
            if (isset($item[StoreReviewInterface::STORE_REVIEW_ID])) {
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->context->getUrl(
                            'store_review/reviews/edit',
                            ['id' => $item[StoreReviewInterface::STORE_REVIEW_ID]]
                        ),
                        'label' => __('Edit')
                    ]
                ];
            }
        }
        return $dataSource;
    }
}