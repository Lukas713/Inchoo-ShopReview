<?php
namespace Inchoo\StoreReview\Ui\Component\Listing;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Magento\Backend\Model\Auth;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;
    /**
     * @var Auth
     */
    private $auth;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory $collectionFactory,
        CustomerRepositoryInterface $customerRepository,
        Auth $auth,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->customerRepository = $customerRepository;
        $this->auth = $auth;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        $this->collection->setOrder(StoreReviewInterface::CREATED_AT, AbstractDb::SORT_ORDER_DESC);
        $joinCondition = 'main_table.customer = customer_entity.entity_id';
        $this->collection->getSelect(

        )->joinLeft(
            'customer_entity',
            $joinCondition,
            []
        )->columns('customer_entity.email');
        $data = $this->collection->toArray();
        return $data;
    }
}
