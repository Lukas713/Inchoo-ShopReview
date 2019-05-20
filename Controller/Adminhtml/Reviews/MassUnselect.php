<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Reviews;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory;
use Magento\Backend\App\Action;

class MassUnselect extends Action
{
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        Action\Context $context,
        StoreReviewRepositoryInterface $storeReviewRepository,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->storeReviewRepository = $storeReviewRepository;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $result = $this->getRequest()->getParam("selected");
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(StoreReviewInterface::STORE_REVIEW_ID, $result);
        foreach ($collection as $model) {
            $model->setSelected(false);
            $this->storeReviewRepository->save($model);
        }
        $this->messageManager->addSuccessMessage("Successful");
        return $this->_redirect("store_review/reviews");
    }
}
