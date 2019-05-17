<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Reviews;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Create extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct
    (
        Context $context,
        PageFactory $pageFactory
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}