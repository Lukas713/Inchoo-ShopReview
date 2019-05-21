<?php

namespace Inchoo\StoreReview\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface StoreReviewSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return StoreReviewInterface[]
     */
    public function getItems();

    /**
     * @param StoreReviewInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
