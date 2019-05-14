<?php

namespace Inchoo\StoreReview\Setup;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()
            ->newTable(StoreReviewInterface::STORE_REVIEW_TABLE_NAME)
            ->addColumn(
                StoreReviewInterface::STORE_REVIEW_ID,
                Table::TYPE_INTEGER,
                null,
                ['auto_increment' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                'id'
            )->addColumn(
                StoreReviewInterface::WEBSITE,
                Table::TYPE_SMALLINT,
                5,
                ['unsigned' => true],
                'foreign key at store_website'
            )->addColumn(
                StoreReviewInterface::CUSTOMER,
                Table::TYPE_INTEGER,
                10,
                ['unsigned' => true],
                'foregin key at customer_entity'
            )->addColumn(
                StoreReviewInterface::STORE,
                Table::TYPE_SMALLINT,
                5,
                ['unsigned' => true],
                'foreign key at store'
            )->addColumn(
                StoreReviewInterface::CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'datetime when review is created'
            )->addColumn(
                StoreReviewInterface::TITLE,
                Table::TYPE_TEXT,
                50,
                ['nullable' => false, 'default' => Table::TYPE_TEXT],
                'Review content'
            )->addColumn(
                StoreReviewInterface::CONTENT,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false, 'default' => Table::TYPE_TEXT],
                'Review content'
            )->addColumn(
                StoreReviewInterface::UPDATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['default' => Table::TIMESTAMP_INIT_UPDATE],
                'datetime when review is updated'
            )->addColumn(
                StoreReviewInterface::APPROVED,
                Table::TYPE_BOOLEAN,
                null,
                ['default' => false, 'nullable' => false],
                'does admin approves this review'
            )->addColumn(
                StoreReviewInterface::SELECTED,
                Table::TYPE_BOOLEAN,
                null,
                ['default' => false, 'nullable' => false],
                'is this review selected on frontend'
            )->addForeignKey(
                $setup->getFkName(
                    StoreReviewInterface::STORE_REVIEW_TABLE_NAME,
                    StoreReviewInterface::WEBSITE,
                    'store_website',
                    'webiste_id'
                ),
                StoreReviewInterface::WEBSITE,
                $setup->getTable('store_website'),
                'website_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    StoreReviewInterface::STORE_REVIEW_TABLE_NAME,
                    StoreReviewInterface::CUSTOMER,
                    'customer_entity',
                    StoreReviewInterface::CUSTOMER
                ),
                StoreReviewInterface::CUSTOMER,
                $setup->getTable('customer_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    StoreReviewInterface::STORE_REVIEW_TABLE_NAME,
                    StoreReviewInterface::STORE,
                    'store',
                    'store_id'
                ),
                StoreReviewInterface::STORE,
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            );

        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }
}
