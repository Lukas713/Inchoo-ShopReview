<?php

namespace Inchoo\StoreReview\Ui\Component\Listing;

use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param \Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    public function getData()
    {
        /** @var \Inchoo\StoreReview\Model\ResourceModel\StoreReview\Collection $collection */
        return $this->collection->toArray();
    }
}
