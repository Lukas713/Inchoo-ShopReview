<?php


namespace Inchoo\StoreReview\Block\Reviews;


use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Model\ResourceModel\StoreReview;
use Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

class Index extends Template
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var CollectionFactory
     */
    private $colection;

    private $collectionFactory;


    public function __construct
    (
        Template\Context $context,
        StoreManagerInterface $storeManager,
        CollectionFactory $colectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
        $this->collectionFactory = $colectionFactory;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
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

    public function getCustomCollection()
    {
        if ($this->colection !== null) {
            return $this->colection;
        }
        $store = $this->storeManager->getStore();
        $this->colection = $this->collectionFactory->create()
            ->addFieldToFilter(
                StoreReviewInterface::APPROVED,
                ['eq' => true]
            )->addFieldToFilter(
                StoreReviewInterface::SELECTED,
                ['eq' => true]
            )->addFieldToFilter(
                StoreReviewInterface::STORE,
                ['eq' => $store->getId()]
            )->addFieldToFilter(
                StoreReviewInterface::WEBSITE,
                ['eq' => $store->getWebsiteId()]
            );
        return $this->colection;

    }
}