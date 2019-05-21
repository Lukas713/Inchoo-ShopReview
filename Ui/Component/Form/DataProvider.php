<?php

namespace Inchoo\StoreReview\Ui\Component\Form;

use Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory;
use Magento\Framework\DataObject;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * @return array|DataObject
     */
    public function getData()
    {
        $joinCondition = 'main_table.customer = customer_entity.entity_id';
        $this->collection->getSelect()->joinLeft(
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
