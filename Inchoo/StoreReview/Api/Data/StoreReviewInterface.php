<?php

namespace Inchoo\StoreReview\Api\Data;

interface StoreReviewInterface
{
    const STORE_REVIEW_TABLE_NAME = 'Inchoo_StoreReview';
    const STORE_REVIEW_ID = 'store_review';
    const WEBSITE = 'store_website';
    const CUSTOMER = 'customer';
    const STORE = 'store';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const APPROVED = 'approved';
    const SELECTED = 'selected';
    const CONTENT = 'review_content';
    const TITLE = 'review_title';

    /**
     * @param string, title of the review
     * @return StoreReviewInterface
     */
    public function setTitle($title);

    /**
     * @param string, content of the review
     * @return StoreReviewInterface
     */
    public function setContent($content);

    /**
     * @param int, $id
     * @return StoreReviewInterface
     */
    public function setWebsite($id);

    /**
     * @param int, customer $id
     * @return StoreReviewInterface
     */
    public function setCustomer($id);

    /**
     * @param int, store view $id
     * @return StoreReviewInterface
     */
    public function setStore($id);

    /**
     * @param string, current datetime
     * @return StoreReviewInterface
     */
    public function setCreatedAt($date);

    /**
     * @param string, current datetime
     * @return StoreReviewInterface
     */
    public function setUpdatedAt($date);

    /**
     * @param bool
     * @return StoreReviewInterface
     */
    public function setApproved($bool);

    /**
     * @param bool
     * @return StoreReviewInterface
     */
    public function setSelected($bool);

    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getWebsite();

    /**
     * @return int
     */
    public function getCustomer();

    /**
     * @return int
     */
    public function getStore();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @return bool
     */
    public function getApproved();

    /**
     * @return bool
     */
    public function getSelected();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getContent();
}
