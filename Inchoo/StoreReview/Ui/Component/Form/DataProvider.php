<?php

namespace Inchoo\StoreReview\Ui\Component\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
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
        $joinCondition = 'main_table.customer = customer_entity.entity_id';
        $this->collection->getSelect(

        )->joinLeft(
            'customer_entity',
            $joinCondition,
            []
        )->columns('customer_entity.email');
        $data = $this->getCollection()->getFirstItem();
        if ($data->getId()) {
            $data[$data->getId()] = $data->toArray();
        }
        return $data;
    }
}
