<?php

namespace Inchoo\StoreReview\Model;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
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
     * @var SearchCriteriaBuilder
     */
    private $criteriaBuilder;
    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * StoreReviewRepository constructor.
     * @param StoreReviewInterfaceFactory $storeReviewInterfaceFactory
     * @param ResourceModel\StoreReview $storeReviewResource
     * @param ResourceModel\StoreReview\CollectionFactory $collectionFactory
     * @param StoreReviewSearchResultsInterfaceFactory $searchResultsInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \Inchoo\StoreReview\Api\Data\StoreReviewInterfaceFactory $storeReviewInterfaceFactory,
        \Inchoo\StoreReview\Model\ResourceModel\StoreReview $storeReviewResource,
        \Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory $collectionFactory,
        \Inchoo\StoreReview\Api\Data\StoreReviewSearchResultsInterfaceFactory $searchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor,
        StoreManagerInterface $storeManager,
        Session $session,
        SearchCriteriaBuilder $criteriaBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        FilterBuilder $filterBuilder
    ) {
        $this->storeReviewInterfaceFactory = $storeReviewInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->storeReviewResource = $storeReviewResource;
        $this->searchResultsInterfaceFactory = $searchResultsInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->storeManager = $storeManager;
        $this->session = $session;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
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
        return $model;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StoreReviewInterface[]
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Inchoo\StoreReview\Model\ResourceModel\StoreReview\Collection  $collection */
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
            $model = $this->getById($params[StoreReviewInterface::STORE_REVIEW_ID]);
            $model->setContent($params[StoreReviewInterface::CONTENT]);
            $model->setTitle($params[StoreReviewInterface::TITLE]);
            $model->setApproved(false);
        } catch (\Exception $exception) {
            $model = $this->storeReviewInterfaceFactory->create();
            $store = $this->storeManager->getStore();
            $model->setContent($params[StoreReviewInterface::CONTENT]);
            $model->setTitle($params[StoreReviewInterface::TITLE]);
            $model->setStore($store->getId());
            $model->setWebsite($store->getWebsiteId());
            $model->setCustomer($this->session->getCustomerId());
        }
        $this->save($model);
        return $model;
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

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StoreReviewInterface[]
     * @throws LocalizedException
     */
    public function getByStore($params = [])
    {
        $filter = $this->filterBuilder->create();
        $filter->setField(StoreReviewInterface::STORE);
        $filter->setValue($params[StoreReviewInterface::STORE]);

        $filter1 = $this->filterBuilder->create();
        $filter1->setField(StoreReviewInterface::CUSTOMER);
        $filter1->setValue($params[StoreReviewInterface::CUSTOMER]);

        $this->filterGroupBuilder->addFilter($filter);
        $filterGroup = $this->filterGroupBuilder->create();

        $this->filterGroupBuilder->addFilter($filter1);
        $filterGroup1 = $this->filterGroupBuilder->create();

        $searchCriteria = $this->criteriaBuilder->create();
        $searchCriteria->setFilterGroups([$filterGroup, $filterGroup1]);

        return $this->getList($searchCriteria);
    }
}
