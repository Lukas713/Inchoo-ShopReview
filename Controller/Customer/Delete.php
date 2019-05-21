<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Inchoo\StoreReview\Model\StoreReview;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\NoSuchEntityException;

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
    )
    {
        parent::__construct($context, $session, $validator);
        $this->storeReviewRepository = $storeReviewRepository;
    }

    public function execute()
    {
        $this->redirectIfNotLogged();
        $id = $this->getRequest()->getParam('id');
        try {
            /** @var StoreReview $model */
            $model = $this->storeReviewRepository->getById($id);
            if ($model->getCustomer() != $this->session->getCustomerId()) {
                $this->messageManager->addErrorMessage("Wrong entity id");
                return $this->_redirect("store_review/customer/index");
            }
            $this->storeReviewRepository->deleteById($id);
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage("There is no entity with id " . $id);
            return $this->_redirect("store_review/customer/index");
        }
        $this->messageManager->addSuccessMessage("Successful");
        return $this->_redirect("store_review/customer/index");
    }
}
