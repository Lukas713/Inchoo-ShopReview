<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Data\Form\FormKey\Validator;


class Edit extends Redirecter
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct(
        Context $context,
        Session $session,
        Validator $validator,
        PageFactory $pageFactory
    ) {
        parent::__construct($context, $session, $validator);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        $this->redirectIfNotLogged();
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set("Edit Review");
        if ($this->getRequest()->getParam('id') != '') {
            return $page;
        }
        $this->messageManager->addNoticeMessage("Something went wrong, please try again");
        return $this->_redirect("store_review/customer");
    }
}
