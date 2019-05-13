<?php

namespace Inchoo\StoreReview\Block\Customer;

use Magento\Framework\View\Element\Template;

class Index extends Template
{
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function getCreatePage(){
        return $this->getUrl('store_review/customer/create');
    }
}