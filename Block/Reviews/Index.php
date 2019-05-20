<?php


namespace Inchoo\StoreReview\Block\Reviews;


use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Inchoo\StoreReview\Model\ResourceModel\StoreReview;
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
    /**
     * @var StoreReview\CollectionFactory
     */
    private $colection;

    public function __construct
    (
        Template\Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StoreReviewRepositoryInterface $storeReviewRepository,
        StoreManagerInterface $storeManager,
        \Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory $colectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeReviewRepository = $storeReviewRepository;
        $this->storeManager = $storeManager;
        $this->colection = $colectionFactory;
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

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Shop Reviews'));
        if ($this->getCustomCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getCustomCollection()
                );
            $this->setChild('pager', $pager);
            $this->getCustomCollection()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    public function getCustomCollection()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest(

        )->getParam('limit') : 5;
        $collection = $this->colection->create();
        $store = $this->storeManager->getStore();
        $collection->addFieldToFilter(StoreReviewInterface::STORE, $store->getId());
        $collection->addFieldToFilter(StoreReviewInterface::WEBSITE, $store->getWebsiteId());
        $collection->addFieldToFilter(StoreReviewInterface::APPROVED, true);
        $collection->addFieldToFilter(StoreReviewInterface::SELECTED, true);
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }
}