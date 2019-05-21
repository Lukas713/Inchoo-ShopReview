<?php

namespace Inchoo\StoreReview\Ui\Component\Listing;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        CustomerRepositoryInterface $customerRepository,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getData()
    {
        $this->collection->setOrder(StoreReviewInterface::CREATED_AT, AbstractDb::SORT_ORDER_DESC);
        $joinCondition = 'main_table.customer = customer_entity.entity_id';
        $this->collection->getSelect()->joinLeft(
            'customer_entity',
            $joinCondition,
            []
        )->columns('customer_entity.email');
        $data = $this->collection->toArray();
        return $data;
    }
}
