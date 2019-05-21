<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Model\StoreReviewRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;

class Create extends Redirecter
{
    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var StoreReviewRepository
     */
    private $reviewRepository;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Context $context,
        Session $session,
        PageFactory $pageFactory,
        StoreReviewRepository $reviewRepository,
        StoreManagerInterface $storeManager,
        Validator $validator
    )
    {
        parent::__construct($context, $session, $validator);
        $this->pageFactory = $pageFactory;
        $this->reviewRepository = $reviewRepository;
        $this->session = $session;
        $this->storeManager = $storeManager;
    }

    public function execute()
    {
        $this->redirectIfNotLogged();
        $id = $this->session->getCustomerId();
        $website = $this->storeManager->getWebsite()->getId();
        $result = $this->reviewRepository->getByStore(
            [
                StoreReviewInterface::WEBSITE => $website,
                StoreReviewInterface::CUSTOMER => $id
            ]
        );
        if (!empty($result->getItems())) {
            $this->messageManager->addNoticeMessage("You can publish only one review per website");
            return $this->_redirect("store_review/customer");
        }
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set(__("Create Review"));
        return $page;
    }
}
