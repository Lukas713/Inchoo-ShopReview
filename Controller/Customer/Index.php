<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
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
        Session $session,
        Validator $validator
    )
    {
        parent::__construct($context, $session, $validator);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        $this->redirectIfNotLogged();
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set(__("My Reviews"));
        return $page;
    }
}
