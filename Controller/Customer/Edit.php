<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;


class Edit extends Redirecter
{
    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $reviewRepository;

    public function __construct(
        Context $context,
        Session $session,
        Validator $validator,
        PageFactory $pageFactory,
        StoreReviewRepositoryInterface $reviewRepository
    )
    {
        parent::__construct($context, $session, $validator);
        $this->pageFactory = $pageFactory;
        $this->reviewRepository = $reviewRepository;
    }

    public function execute()
    {
        $this->redirectIfNotLogged();
        $id = $this->getRequest()->getParam('id');
        try {
            $model = $this->reviewRepository->getById($id);
            if ($model->getCustomer() != $this->session->getCustomerId()) {
                throw new NoSuchEntityException(__('Wrong entity id'));
            }
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage("Wrong entity id");
            return $this->_redirect("store_review/customer/index");
        }
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set(__("Edit Review"));
        return $page;
    }
}
