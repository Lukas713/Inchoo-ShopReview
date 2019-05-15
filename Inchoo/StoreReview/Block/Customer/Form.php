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
     * @var ResponseFactory
     */
    private $factory;

    public function __construct(
        Template\Context $context,
        StoreReviewRepositoryInterface $reviewRepository,
        Session $session,
        ManagerInterface $message,
        ResponseFactory $factory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->reviewRepository = $reviewRepository;
        $this->session = $session;
        $this->message = $message;
        $this->factory = $factory;
    }

    public function getFrontPage()
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

    /**
     * load review id
     * @return bool|\Inchoo\StoreReview\Api\Data\StoreReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function checkCustomerAndReviewId()
    {
        $id = $this->getRequest()->getParam('id');
        try {
            $model = $this->reviewRepository->getById($id);
            if ($model->getCustomer() != $this->session->getCustomerId()) {
                $this->message->addErrorMessage("Wrong entity id");
                return false;
            }
        } catch (NoSuchEntityException $exception) {
            $this->message->addErrorMessage("No souch entity");
            return false;
        }
        return $model;
    }
}
