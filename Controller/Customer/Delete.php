<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;

class Delete extends Redirecter
{
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;

    public function __construct(
        Context $context,
        StoreReviewRepositoryInterface $storeReviewRepository,
        Session $session,
        Validator $validator
    ) {
        parent::__construct($context, $session, $validator);
        $this->storeReviewRepository = $storeReviewRepository;
    }

    public function execute()
    {
        $this->redirectIfNotLogged();
        $id = $this->getRequest()->getParam('id');
        /** @var \Inchoo\StoreReview\Model\StoreReview $model */
        $model = $this->storeReviewRepository->getById($id);
        if($model->getCustomer() != $this->session->getCustomerId()){
            $this->messageManager->addErrorMessage("Wrong entity id");
            return $this->_redirect("store_review/customer/index");
        }
        $this->storeReviewRepository->deleteById($id);
        $this->messageManager->addSuccessMessage("Successful");
        return $this->_redirect("store_review/customer/index");
    }
}
