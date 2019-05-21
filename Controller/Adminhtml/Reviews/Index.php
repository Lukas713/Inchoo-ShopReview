<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Reviews;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Inchoo_StoreReview::reviews';

    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct
    (
        Action\Context $context,
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