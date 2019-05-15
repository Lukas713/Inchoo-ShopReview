<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Reviews;

use Magento\Backend\App\Action;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var Config
     */
    private $config;

    /**
     * Index constructor.
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory,
        Config $config

    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->config = $config;
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}
