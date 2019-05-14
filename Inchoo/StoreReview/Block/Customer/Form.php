<?php

namespace Inchoo\StoreReview\Block\Customer;

use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ResponseFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;

class Form extends Template
{
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $reviewRepository;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var MessageInterface
     */
    private $message;
    /**
     * @var UrlInterface
     */
    private $url;
    /**
     * @var ResponseFactory
     */
    private $factory;

    public function __construct(
        Template\Context $context,
        StoreReviewRepositoryInterface $reviewRepository,
        Session $session,
        ManagerInterface $message,
        UrlInterface $url,
        ResponseFactory $factory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->reviewRepository = $reviewRepository;
        $this->session = $session;
        $this->message = $message;
        $this->url = $url;
        $this->factory = $factory;
    }

    public function frontPage()
    {
        return $this->getUrl('store_review/customer');
    }

    public function getSavePage()
    {
        return $this->getUrl('store_review/customer/save');
    }

    public function getEditPage()
    {
        return $this->getUrl('store_review/customer/edit');
    }

    public function checkCustomerAndReviewId()
    {
        $id = $this->getRequest()->getParam('id');
        try {
            $model = $this->reviewRepository->getById($id);
            if ($model->getCustomer() != $this->session->getCustomerId()) {
                $this->message->addErrorMessage("You dont have permission to do that");
                return false;
            }
        } catch (NoSuchEntityException $exception) {
            $this->message->addErrorMessage("No souch entity");
            return false;
        }
        return $model;
    }
}
