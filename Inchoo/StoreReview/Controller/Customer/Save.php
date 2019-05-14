<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\Data\StoreReviewInterfaceFactory;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Escaper;
use Magento\Store\Model\StoreManagerInterface;

class Save extends Action
{
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;

    /**
     * @var Escaper
     */
    private $escaper;

    public function __construct(
        Context $context,
        StoreReviewRepositoryInterface $storeReviewRepository,
        Escaper $escaper
    ) {
        parent::__construct($context);
        $this->storeReviewRepository = $storeReviewRepository;
        $this->escaper = $escaper;
    }

    public function execute()
    {
        if ($this->getRequest()->getParam('submit') !== '') {
            if ($this->getRequest()->getParam(StoreReviewInterface::TITLE) != ''
                && $this->getRequest()->getParam(StoreReviewInterface::CONTENT) != '') {
                $result = $this->getRequest()->getParams();
                foreach ($result as $key => $value) {
                    $result[$key] = $this->escaper->escapeHtml($value);
                }
                $this->storeReviewRepository->insertRecord($result);
                $this->messageManager->addSuccessMessage("Successfully added record");
                return $this->_redirect("store_review/customer");
            }
        }
        $this->messageManager->addNoticeMessage("All fields are required");
        return $this->_redirect("store_review/customer/create");
    }
}
