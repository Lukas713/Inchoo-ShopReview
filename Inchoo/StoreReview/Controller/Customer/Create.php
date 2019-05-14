<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Create extends Redirecter
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct(
        Context $context,
        Session $session,
        PageFactory $pageFactory
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
