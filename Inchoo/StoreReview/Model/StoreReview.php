<?php

namespace Inchoo\StoreReview\Model;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Magento\Framework\Model\AbstractModel;

class StoreReview extends AbstractModel implements StoreReviewInterface
{

    public function _construct()
    {
        $this->_init(\Inchoo\StoreReview\Model\ResourceModel\StoreReview::class);
    }

    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @param int, $id
     * @return StoreReviewInterface
     */
    public function setWebsite($id)
    {
        return $this->setData(self::WEBSITE, $id);
    }

    /**
     * @param int, customer $id
     * @return StoreReviewInterface
     */
    public function setCustomer($id)
    {
        return $this->setData(self::CUSTOMER, $id);
    }

    /**
     * @param int, store view $id
     * @return StoreReviewInterface
     */
    public function setStore($id)
    {
        return $this->setData(self::STORE, $id);
    }

    /**
     * @param string, current datetime
     * @return StoreReviewInterface
     */
    public function setCreatedAt($date)
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * @param string, current datetime
     * @return StoreReviewInterface
     */
    public function setUpdatedAt($date)
    {
        return $this->setData(self::UPDATED_AT, $date);
    }

    /**
     * @param bool
     * @return StoreReviewInterface
     */
    public function setApproved($bool)
    {
        return $this->setData(self::APPROVED, $bool);
    }

    /**
     * @param bool
     * @return StoreReviewInterface
     */
    public function setSelected($bool)
    {
        return $this->setData(self::SELECTED, $bool);
    }

    /**
     * @return int
     */
    public function getWebsite()
    {
        return $this->getData(self::WEBSITE);
    }

    /**
     * @return int
     */
    public function getCustomer()
    {
        return $this->getData(self::CUSTOMER);
    }

    /**
     * @return int
     */
    public function getStore()
    {
        return $this->getData(self::STORE);
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @return bool
     */
    public function getApproved()
    {
        return $this->getData(self::APPROVED);
    }

    /**
     * @return bool
     */
    public function getSelected()
    {
        return $this->getData(self::SELECTED);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::STORE_REVIEW_ID);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }
}