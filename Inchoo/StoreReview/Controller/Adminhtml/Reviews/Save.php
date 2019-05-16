<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Reviews;

use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Escaper;

class Save extends Action
{
    /**
     * @var Http
     */
    private $request;
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;
    /**
     * @var Escaper
     */
    private $escaper;

    public function __construct
    (
        Action\Context $context,
        Http $request,
        StoreReviewRepositoryInterface $storeReviewRepository,
        Escaper $escaper
    )
    {
        parent::__construct($context);
        $this->request = $request;
        $this->storeReviewRepository = $storeReviewRepository;
        $this->escaper = $escaper;
    }

    public function execute()
    {
        $params = $this->request->getPost()->toArray();
        $this->storeReviewRepository->insertRecord($this->escapeHtml($params));
        $this->messageManager->addSuccessMessage("Successful");
        return $this->_redirect("store_review/reviews/index");
    }

    protected function escapeHtml($result = [])
    {
        foreach ($result as $key => $value) {
            $result[$key] = $this->escaper->escapeHtml($value);
        }
        return $result;
    }
}