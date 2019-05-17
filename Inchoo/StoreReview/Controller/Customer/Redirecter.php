<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;

abstract class Redirecter extends Action
{
    /**
     * @var Session
     */
    private $session;
    /**
     * @var Validator
     */
    private $validator;

    public function __construct(
        Context $context,
        Session $session,
        Validator $validator
    ) {
        parent::__construct($context);
        $this->session = $session;
        $this->validator = $validator;
    }

    public function redirectIfNotLogged()
    {
        if (!$this->session->isLoggedIn()) {
            $this->messageManager->addNoticeMessage("You must be signed in");
            return $this->_redirect("/");
        }
    }

    public function validateFormKey()
    {
        if (!$this->validator->validate($this->getRequest())) {
            $this->messageManager->addErrorMessage("Something went wrong, please try again");
            return $this->_redirect("store_review/customer");
        }
    }
}
