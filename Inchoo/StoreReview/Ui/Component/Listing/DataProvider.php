<?php

namespace Inchoo\StoreReview\Ui\Component\Listing;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Data\Collection\AbstractDb;
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
        \Inchoo\StoreReview\Model\ResourceModel\StoreReview\CollectionFactory $collectionFactory,
        CustomerRepositoryInterface $customerRepository,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        $this->collection->setOrder(StoreReviewInterface::CREATED_AT, AbstractDb::SORT_ORDER_DESC);
        $this->collection->getSelect()->group(StoreReviewInterface::APPROVED);
        $data = $this->collection->toArray();
        foreach ($data as $key) {
            if (!is_array($key)) {
                continue;
            }
            foreach ($key as $item => $value) {
                $model = $this->customerRepository->getById($value[StoreReviewInterface::CUSTOMER]);
                $data['items'][$item]['email'] = $model->getEmail();
            }
        }
        return $data;
    }
}
