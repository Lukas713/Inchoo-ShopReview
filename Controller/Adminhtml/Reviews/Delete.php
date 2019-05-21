<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Reviews;

use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Inchoo_StoreReview::reviews';

    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;
    /**
     * @var Http
     */
    private $request;

    public function __construct(
        Action\Context $context,
        StoreReviewRepositoryInterface $storeReviewRepository,
        Http $request
    )
    {
        parent::__construct($context);
        $this->storeReviewRepository = $storeReviewRepository;
        $this->request = $request;
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $id = $this->request->getParam('store_review');
        try {
            $this->storeReviewRepository->deleteById($id);
            $this->messageManager->addSuccessMessage("Successful");
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addNoticeMessage($exception->getMessage());
        }
        return $this->_redirect("store_review/reviews/index");
    }
}
