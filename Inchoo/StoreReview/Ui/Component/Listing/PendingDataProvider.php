<?php

namespace Inchoo\StoreReview\Ui\Component\Listing;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Magento\Ui\DataProvider\AbstractDataProvider;

class PendingDataProvider extends AbstractDataProvider
{

    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    public function __construct
    (
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory $collectionFactory,
        Filter $filter,
        FilterBuilder $filterBuilder,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->filter = $filter;
        $this->filterBuilder = $filterBuilder;
    }

    public function getData(){
        $this->collection->addFieldToFilter(StoreReviewInterface::APPROVED, ['eq' => false]);
        $data = $this->collection->toArray();
        return $data;
    }
}