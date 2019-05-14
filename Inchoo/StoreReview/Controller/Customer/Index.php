<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Redirecter
{
    /**
     * @var PageFactory
     */
    private $pageFactory;


    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Session $session
    ) {
        parent::__construct($context, $session);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        $this->redirectIfNotLogged();
        return $this->pageFactory->create();
    }
}
