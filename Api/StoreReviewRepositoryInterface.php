<?php

namespace Inchoo\StoreReview\Api;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Model\StoreReview;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;

interface StoreReviewRepositoryInterface
{
    /**
     * Save news.
     *
     * @param StoreReviewInterface $review
     * @return StoreReviewInterface
     * @throws LocalizedException
     */
    public function save(StoreReview $review);

    /**
     * Delete news.
     *
     * @param StoreReviewInterface $review
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(StoreReview $review);

    /**
     * Retrieve news.
     *
     * @param int
     * @return StoreReviewInterface
     * @throws LocalizedException
     */
    public function getById($id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StoreReviewInterface[]
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Retrieve news.
     *
     * @param int
     * @return StoreReviewInterface
     * @throws LocalizedException
     */
    public function getByStore($id);

    public function insertRecord($params = []);

    /**
     * Delete review with id
     * @param int $id
     * @return mixed|bool
     */
    public function deleteById($id);
}
