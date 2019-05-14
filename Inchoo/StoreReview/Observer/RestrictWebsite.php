<?php

namespace Inchoo\StoreReview\Observer;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Context;

/**
 * https://inchoo.net/magento/restrict-website-access-require-log/
 * Class RestrictWebsite
 * @package Inchoo\StoreReview\Observer
 */
class RestrictWebsite implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;
    /**
     * @var \Magento\Framework\App\Response\Http
     */
    private $response;
    /**
     * @var \Magento\Framework\UrlFactory
     */
    private $urlFactory;
    /**
     * @var \Magento\Framework\App\Http\Context
     */
    private $context;
    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    private $actionFlag;

    public function __construct
    (
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\UrlFactory $urlFactory,
        \Magento\Framework\App\Http\Context $context,
        \Magento\Framework\App\ActionFlag $actionFlag
    )
    {
        $this->eventManager = $eventManager;
        $this->response = $response;
        $this->urlFactory = $urlFactory;
        $this->context = $context;
        $this->actionFlag = $actionFlag;
    }

    public function execute(Observer $observer)
    {
        $allowedRoutes = [
            'customer_account_login',
            'customer_account_loginpost',
            'customer_account_create',
            'customer_account_createpost',
            'customer_account_logoutsuccess',
            'customer_account_confirm',
            'customer_account_confirmation',
            'customer_account_forgotpassword',
            'customer_account_forgotpasswordpost',
            'customer_account_createpassword',
            'customer_account_resetpasswordpost',
            'customer_section_load'
        ];

        $request = $observer->getEvent()->getRequest();
        $isCustomerLoggedIn = $this->context->getValue(Context::CONTEXT_AUTH);
        $actionFullName = strtolower($request->getFullActionName());

        if (!$isCustomerLoggedIn && !in_array($actionFullName, $allowedRoutes)) {
            $this->response->setRedirect($this->urlFactory->create()->getUrl('customer/account/login'));
        }
    }

}