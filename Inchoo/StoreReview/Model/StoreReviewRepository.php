<?php

namespace Inchoo\StoreReview\Model;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Backend\Model\Auth;
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
     * @var Auth
     */
    private $auth;

    /**
     * StoreReviewRepository constructor.
     * @param \Inchoo\StoreReview\Api\Data\StoreReviewInterfaceFactory $storeReviewInterfaceFactory
     * @param ResourceModel\StoreReview $storeReviewResource
     * @param ResourceModel\StoreReview\CollectionFactory $collectionFactory
     * @param \Inchoo\StoreReview\Api\Data\StoreReviewSearchResultsInterfaceFactory $searchResultsInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param StoreManagerInterface $storeManager
     * @param Session $session
     * @param SearchCriteriaBuilder $criteriaBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param Auth $auth
     * @param FilterBuilder $filterBuilder
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
        Auth $auth,
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
        $this->auth = $auth;
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

    /**
     * @param array $params
     * @return StoreReviewInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function insertRecord($params = [])
    {
        try {
            $model = $this->getById($params[StoreReviewInterface::STORE_REVIEW_ID]);
            $model->setContent($params[StoreReviewInterface::CONTENT]);
            $model->setTitle($params[StoreReviewInterface::TITLE]);
            $model->setFakeCustomer($params[StoreReviewInterface::FAKE_CUSTOMER] ?? null);
            $model->setApproved($params[StoreReviewInterface::APPROVED] ?? false);
            $model->setSelected($params[StoreReviewInterface::SELECTED] ?? false);
            $model->setStore($params[StoreReviewInterface::STORE] ?? null);

        } catch (\Exception $exception) {
            $model = $this->storeReviewInterfaceFactory->create();
            $store = $this->storeManager->getStore();
            $model->setContent($params[StoreReviewInterface::CONTENT]);
            $model->setTitle($params[StoreReviewInterface::TITLE]);
            $model->setStore($store->getId());
            $model->setWebsite($store->getWebsiteId());
            $model->setCustomer($this->session->getCustomerId() ?? null);
            $model->setFakeCustomer($params[StoreReviewInterface::FAKE_CUSTOMER] ?? null);
        }
        return $this->save($model);
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
        $filter->setField(StoreReviewInterface::WEBSITE);
        $filter->setValue($params[StoreReviewInterface::WEBSITE]);

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

    public function deleteById($id)
    {
        try {
            $model = $this->getById($id);
        } catch (NoSuchEntityException $exception) {
            throw new $exception();
        }
        return $this->delete($model);
    }
}
