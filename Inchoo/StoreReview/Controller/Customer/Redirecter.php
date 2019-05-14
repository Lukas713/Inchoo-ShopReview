<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

abstract class Redirecter extends Action
{
    /**
     * @var Session
     */
    private $session;

    public function __construct
    (
        Context $context,
        Session $session
    )
    {
        parent::__construct($context);
        $this->session = $session;
    }

    public function redirectIfNotLogged() {
        if(!$this->session->isLoggedIn()){
            $this->messageManager->addNoticeMessage("You must be signed in");
            return $this->_redirect("/");
        }
    }
}