<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Redirecter
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
        if ($this->getRequest()->getParam('id') != '') {
            return $this->pageFactory->create();
        }
        $this->messageManager->addNoticeMessage("Something went wrong, please try again");
        return $this->_redirect("store_review/customer");
    }
}
