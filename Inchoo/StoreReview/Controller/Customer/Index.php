<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Inchoo\StoreReview\Api\Data\StoreReviewInterfaceFactory;
use Inchoo\StoreReview\Model\StoreReviewRepository;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var StoreReviewRepository
     */
    private $storeReviewRepository;
    /**
     * @var StoreReviewInterfaceFactory
     */
    private $storeReviewInterfaceFactory;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        StoreReviewRepository $storeReviewRepository,
        StoreReviewInterfaceFactory $storeReviewInterfaceFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->storeReviewRepository = $storeReviewRepository;
        $this->storeReviewInterfaceFactory = $storeReviewInterfaceFactory;
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}
