<?php

namespace Inchoo\StoreReview\Model;

use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class StoreReviewRepository implements StoreReviewRepositoryInterface
{
    /**
     * @var StoreReviewInterfaceFactory
     */
    private $storeReviewInterfaceFactory;
    /**
     * @var ResourceModel\StoreReview\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ResourceModel\StoreReview
     */
    private $storeReviewResource;
    /**
     * @var \Inchoo\StoreReview\Api\Data\StoreReviewSearchResultsInterfaceFactory
     */
    private $searchResultsInterfaceFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct
    (
        \Inchoo\StoreReview\Api\Data\StoreReviewInterfaceFactory $storeReviewInterfaceFactory,
        \Inchoo\StoreReview\Model\ResourceModel\StoreReview $storeReviewResource,
        \Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory $collectionFactory,
        \Inchoo\StoreReview\Api\Data\StoreReviewSearchResultsInterfaceFactory $searchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->storeReviewInterfaceFactory = $storeReviewInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->storeReviewResource = $storeReviewResource;
        $this->searchResultsInterfaceFactory = $searchResultsInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save news.
     *
     * @param \Inchoo\StoreReview\Api\Data\StoreReviewInterface $review
     * @return \Inchoo\StoreReview\Api\Data\StoreReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(StoreReview $review)
    {
        try {
            $this->storeReviewResource->save($review);
        }catch(CouldNotSaveException $exception){
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $review;
    }

    /**
     * Delete news.
     *
     * @param \Inchoo\StoreReview\Api\Data\StoreReviewInterface $review
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(StoreReview $review)
    {
        try {
            $this->storeReviewResource->delete($review);
            return true;
        }catch (CouldNotDeleteException $exception){
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    /**
     * Retrieve news.
     *
     * @param int
     * @return \Inchoo\StoreReview\Api\Data\StoreReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id)
    {
        $model = $this->storeReviewInterfaceFactory->create();
        $this->storeReviewResource->load($model, $id);
        if(!$model->getId()){
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $id));
        }
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\StoreReview\Api\Data\StoreReviewInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Inchoo\StoreReview\Model\ResourceModel\StoreReview\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** \Magento\Framework\Api\SearchResults $searchResult */
        $searchResult = $this->searchResultsInterfaceFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }
}