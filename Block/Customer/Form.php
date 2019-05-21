<?php

namespace Inchoo\StoreReview\Block\Customer;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Element\Template;

class Form extends Template
{
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $reviewRepository;

    /**
     * @var MessageInterface
     */
    private $message;

    public function __construct(
        Template\Context $context,
        StoreReviewRepositoryInterface $reviewRepository,
        ManagerInterface $message,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->reviewRepository = $reviewRepository;
        $this->message = $message;
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
     * @return bool|StoreReviewInterface
     * @throws LocalizedException
     */
    public function checkCustomerAndReviewId()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->reviewRepository->getById($id);
        return $model;
    }
}
