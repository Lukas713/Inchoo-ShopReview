<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Reviews;

use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Backend\App\Action;

class MassDelete extends Action
{
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;

    /**
     * MassDelete constructor.
     * @param Action\Context $context
     * @param StoreReviewRepositoryInterface $storeReviewRepository
     */
    public function __construct(
        Action\Context $context,
        StoreReviewRepositoryInterface $storeReviewRepository
    ) {
        parent::__construct($context);
        $this->storeReviewRepository = $storeReviewRepository;
    }

    public function execute()
    {
        $result = $this->getRequest()->getParam('selected');
        foreach ($result as $key => $value){
            $this->storeReviewRepository->deleteById($value);
        }
        $this->messageManager->addSuccessMessage("Successful");
        return $this->_redirect("store_review/reviews/");
    }
}
