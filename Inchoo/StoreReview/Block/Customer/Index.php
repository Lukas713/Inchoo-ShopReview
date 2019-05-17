<?php

namespace Inchoo\StoreReview\Block\Customer;
use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

class Index extends Template
{
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $reviewRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $criteriaBuilder;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct
    (
        Template\Context $context,
        StoreReviewRepositoryInterface $reviewRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        \Magento\Customer\Model\Session $session,
        StoreManagerInterface $storeManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->reviewRepository = $reviewRepository;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->session = $session;
        $this->storeManager = $storeManager;
    }

    public function getReviews()
    {
        $customerId = $this->session->getCustomerId();
        $this->criteriaBuilder->addFilter(StoreReviewInterface::CUSTOMER, $customerId);
        $searchCriteria = $this->criteriaBuilder->create();

        return $this->reviewRepository->getList($searchCriteria)->getItems();
    }

    public function getCreatePage()
    {
        return $this->getUrl('store_review/customer/create');
    }

    public function getStoreWithId($id)
    {
        return $this->storeManager->getStore($id)->getName();
    }

    public function getApprovedString($i)
    {
        return (int)$i == 0 ? "No" : "Yes";
    }

    public function getEditUrl($id){
        return $this->getUrl('store_review/customer/edit/id/' . $id);
    }
}
