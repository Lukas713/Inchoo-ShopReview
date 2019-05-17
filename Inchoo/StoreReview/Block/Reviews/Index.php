<?php


namespace Inchoo\StoreReview\Block\Reviews;


use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Test\Handler\Store\StoreInterface;

class Index extends Template
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct
    (
        Template\Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StoreReviewRepositoryInterface $storeReviewRepository,
        StoreManagerInterface $storeManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeReviewRepository = $storeReviewRepository;
        $this->storeManager = $storeManager;
    }

    public function getReviews()
    {
        $store = $this->storeManager->getStore();
        $this->searchCriteriaBuilder->addFilter(StoreReviewInterface::APPROVED, true);
        $this->searchCriteriaBuilder->addFilter(StoreReviewInterface::SELECTED, true);
        $this->searchCriteriaBuilder->addFilter(StoreReviewInterface::STORE, $store->getId());
        $this->searchCriteriaBuilder->addFilter(StoreReviewInterface::WEBSITE, $store->getWebsiteId());
        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->storeReviewRepository->getList($searchCriteria)->getItems();
    }
}