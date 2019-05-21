<?php


namespace Inchoo\StoreReview\Controller\Adminhtml\Reviews;


use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory;
use Magento\Backend\App\Action;

class MassDisapprove extends Action
{
    const ADMIN_RESOURCE = 'Inchoo_StoreReview::reviews';

    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct
    (
        Action\Context $context,
        StoreReviewRepositoryInterface $storeReviewRepository,
        CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->storeReviewRepository = $storeReviewRepository;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $result = $this->getRequest()->getParam("selected");
        foreach($result as $key => $value){
            $model = $this->storeReviewRepository->getById($value);
            $model->setApproved(false);
            $this->storeReviewRepository->save($model);
        }
        $this->messageManager->addSuccessMessage("Successful");
        return $this->_redirect("store_review/reviews");
    }
}