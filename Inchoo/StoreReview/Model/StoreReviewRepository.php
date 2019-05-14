<?php

namespace Inchoo\StoreReview\Model;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\Data\StoreReviewInterfaceFactory;
use Inchoo\StoreReview\Api\Data\StoreReviewSearchResultsInterfaceFactory;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Inchoo\StoreReview\Model\ResourceModel\StoreReview\Collection;
use Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

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
     * @var StoreReviewSearchResultsInterfaceFactory
     */
    private $searchResultsInterfaceFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Session
     */
    private $session;

    /**
     * StoreReviewRepository constructor.
     * @param StoreReviewInterfaceFactory $storeReviewInterfaceFactory
     * @param ResourceModel\StoreReview $storeReviewResource
     * @param ResourceModel\StoreReview\CollectionFactory $collectionFactory
     * @param StoreReviewSearchResultsInterfaceFactory $searchResultsInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        StoreReviewInterfaceFactory $storeReviewInterfaceFactory,
        \Inchoo\StoreReview\Model\ResourceModel\StoreReview $storeReviewResource,
        CollectionFactory $collectionFactory,
        StoreReviewSearchResultsInterfaceFactory $searchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor,
        StoreManagerInterface $storeManager,
        Session $session
    ) {
        $this->storeReviewInterfaceFactory = $storeReviewInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->storeReviewResource = $storeReviewResource;
        $this->searchResultsInterfaceFactory = $searchResultsInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->storeManager = $storeManager;
        $this->session = $session;
    }

    /**
     * Delete news.
     *
     * @param StoreReviewInterface $review
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(StoreReview $review)
    {
        try {
            $this->storeReviewResource->delete($review);
            return true;
        } catch (CouldNotDeleteException $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    /**
     * Retrieve news.
     *
     * @param int
     * @return StoreReviewInterface
     * @throws LocalizedException
     */
    public function getById($id)
    {
        $model = $this->storeReviewInterfaceFactory->create();
        $this->storeReviewResource->load($model, $id);
        if (!$model->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $id));
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StoreReviewInterface[]
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** \Magento\Framework\Api\SearchResults $searchResult */
        $searchResult = $this->searchResultsInterfaceFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }

    public function insertRecord($params = [])
    {
        try {
            /** @var StoreReview $model */
            $model = $this->storeReviewInterfaceFactory->create();
            $store = $this->storeManager->getStore();
            $model->setContent($params[StoreReviewInterface::CONTENT]);
            $model->setTitle($params[StoreReviewInterface::TITLE]);
            $model->setStore($store->getId());
            $model->setWebsite($store->getWebsiteId());
            $model->setCustomer($this->session->getCustomerId());
            $this->save($model);
        } catch (CouldNotSaveException $exception) {
            var_dump($exception->getMessage());
        }
    }

    /**
     * Save news.
     *
     * @param StoreReviewInterface $review
     * @return StoreReviewInterface
     * @throws LocalizedException
     */
    public function save(StoreReview $review)
    {
        try {
            $this->storeReviewResource->save($review);
        } catch (CouldNotSaveException $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $review;
    }
}
