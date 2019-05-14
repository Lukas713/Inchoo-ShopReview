<?php

namespace Inchoo\StoreReview\Block\Customer;

use Magento\Framework\View\Element\Template;

class Form extends Template
{
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function frontPage(){
        return "Hello World!";
    }

    public function getSavePage() {
        return $this->getUrl('store_review/customer/save');
    }

    public function getEditPage(){
        return $this->getUrl('store_review/customer/edit');
    }

    public function getIndexPage(){
        return $this->getUrl('store_review/customer');
    }
}