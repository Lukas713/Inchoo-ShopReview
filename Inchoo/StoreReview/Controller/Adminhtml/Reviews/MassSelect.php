<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Reviews;

use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Backend\App\Action;

class MassSelect extends Action
{
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;

    /**
     * MassSelect constructor.
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
        $result = $this->getRequest()->getParam("selected");
        foreach ($result as $key => $value) {
            $model = $this->storeReviewRepository->getById($value);
            $model->setSelected(true);
            $this->storeReviewRepository->save($model);
        }
        $this->messageManager->addSuccessMessage("Successful");
        return $this->_redirect("store_review/reviews");
    }
}
