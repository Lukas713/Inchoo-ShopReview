<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Escaper;

class Save extends Redirecter
{
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;

    /**
     * @var Escaper
     */
    private $escaper;
    /**
     * @var Session
     */
    private $session;

    /**
     * Save constructor.
     * @param Context $context
     * @param StoreReviewRepositoryInterface $storeReviewRepository
     * @param Escaper $escaper
     * @param Session $session
     */
    public function __construct(
        Context $context,
        StoreReviewRepositoryInterface $storeReviewRepository,
        Escaper $escaper,
        Session $session
    ) {
        parent::__construct($context, $session);
        $this->storeReviewRepository = $storeReviewRepository;
        $this->escaper = $escaper;
        $this->session = $session;
    }

    public function execute()
    {
        $this->redirectIfNotLogged();
        if ($this->getRequest()->getParam(StoreReviewInterface::TITLE) != ''
                && $this->getRequest()->getParam(StoreReviewInterface::CONTENT) != '') {
            $result = $this->getRequest()->getParams();
            $result = $this->escapeHtml($result); 
            if (!isset($result[StoreReviewInterface::STORE_REVIEW_ID])) {
                $this->modelInsertRecord($result);
            }
            $model = $this->storeReviewRepository->getById($result[StoreReviewInterface::STORE_REVIEW_ID]);
            if ($model->getCustomer() != $this->session->getCustomerId()) {
                $this->messageManager->addErrorMessage("Wrong entity!");
                return $this->_redirect("store_review/customer");
            }
            $this->modelInsertRecord($result);
        }
        $this->messageManager->addNoticeMessage("All fields are required");
        return $this->_redirect("store_review/customer/create");
    }



    protected function modelInsertRecord($review)
    {
        $this->storeReviewRepository->insertRecord($review);
        $this->messageManager->addSuccessMessage("Successfully!");
        return $this->_redirect("store_review/customer");
    }

    protected function escapeHtml($result = [])
    {
        foreach ($result as $key => $value) {
            $result[$key] = $this->escaper->escapeHtml($value);
        }
        return $result;
    }
}
