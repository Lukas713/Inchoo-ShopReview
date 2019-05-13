<?php

namespace Inchoo\StoreReview\Api;

use Inchoo\StoreReview\Model\StoreReview;
use Magento\Framework\Api\SearchCriteriaInterface;

interface StoreReviewRepositoryInterface
{
    /**
     * Save news.
     *
     * @param \Inchoo\StoreReview\Api\Data\StoreReviewInterface $review
     * @return \Inchoo\StoreReview\Api\Data\StoreReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(StoreReview $review);

    /**
     * Delete news.
     *
     * @param \Inchoo\StoreReview\Api\Data\StoreReviewInterface $review
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(StoreReview $review);

    /**
     * Retrieve news.
     *
     * @param int
     * @return \Inchoo\StoreReview\Api\Data\StoreReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\StoreReview\Api\Data\StoreReviewInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}