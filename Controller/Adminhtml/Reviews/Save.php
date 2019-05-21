<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Reviews;

use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\Request\Http;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Inchoo_StoreReview::reviews';

    /**
     * @var Http
     */
    private $request;
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;

    public function __construct(
        Action\Context $context,
        Http $request,
        StoreReviewRepositoryInterface $storeReviewRepository
    )
    {
        parent::__construct($context);
        $this->request = $request;
        $this->storeReviewRepository = $storeReviewRepository;
    }

    public function execute()
    {
        $params = $this->request->getPost()->toArray();
        $this->storeReviewRepository->insertRecord($params);
        $this->messageManager->addSuccessMessage("Successful");
        return $this->_redirect("store_review/reviews/index");
    }
}
