<?php

namespace Inchoo\StoreReview\Controller\Customer;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\NoSuchEntityException;

class Save extends Redirecter
{
    /**
     * @var StoreReviewRepositoryInterface
     */
    private $storeReviewRepository;

    /**
     * @var Escaper
     */
    private $escaper;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var Http
     */
    private $request;

    /**
     * Save constructor.
     * @param Context $context
     * @param StoreReviewRepositoryInterface $storeReviewRepository
     * @param Escaper $escaper
     * @param Session $session
     */
    public function __construct(
        Context $context,
        StoreReviewRepositoryInterface $storeReviewRepository,
        Escaper $escaper,
        Session $session,
        Http $request
    ) {
        parent::__construct($context, $session);
        $this->storeReviewRepository = $storeReviewRepository;
        $this->escaper = $escaper;
        $this->session = $session;
        $this->request = $request;
    }

    public function execute()
    {
        $this->redirectIfNotLogged();
        $params = $this->escapeHtml($this->request->getPost()->toArray()
        );
        if (isset($params[StoreReviewInterface::STORE_REVIEW_ID])) {
            try {
                $model = $this->storeReviewRepository->getById($params[StoreReviewInterface::STORE_REVIEW_ID]);
                if ($model->getCustomer() != $this->session->getCustomerId()) {
                    $this->messageManager->addErrorMessage("Wrong entity id");
                    return $this->_redirect("store_review/customer");
                }
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
                return $this->_redirect("store_review/customer");
            }
        }
        $this->storeReviewRepository->insertRecord($params);
        $this->messageManager->addSuccessMessage("Successfully");
        return $this->_redirect("store_review/customer");
    }

    protected function escapeHtml($result = [])
    {
        foreach ($result as $key => $value) {
            $result[$key] = $this->escaper->escapeHtml($value);
        }
        return $result;
    }
}
