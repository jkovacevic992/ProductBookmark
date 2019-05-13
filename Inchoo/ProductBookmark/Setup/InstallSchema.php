<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 8:51 AM
 */

namespace Inchoo\ProductBookmark\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $bookmarkListTable = $setup->getConnection()->newTable(
            $setup->getTable('bookmark_list')
        )->addColumn(
            'bookmark_list_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Bookmark List ID'
        )->addColumn(
            'bookmark_list_title',
            Table::TYPE_TEXT,
            255,
            [],
            'Bookmark List Title'
        )->addColumn(
            'customer_entity_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false]
        )->addForeignKey(
            'customer',
            'customer_entity_id',
            'customer_entity',
            'entity_id'
        )->setComment('Bookmark List Table');

        $setup->getConnection()->createTable($bookmarkListTable);

        $bookmarkTable = $setup->getConnection()->newTable(
            $setup->getTable('bookmark')
        )->addColumn(
            'bookmark_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Bookmark ID'
        )->addColumn(
            'bookmark_list_entity_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false]
        )->addColumn(
            'product_entity_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false]
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Bookmark Created At'
        )->addForeignKey(
            'bookmark_list',
            'bookmark_list_entity_id',
            'bookmark_list',
            'bookmark_list_id'
        )->addForeignKey(
            'product',
            'product_entity_id',
            'catalog_product_entity',
            'entity_id'
        )->setComment('Bookmark Table');

        $setup->getConnection()->createTable($bookmarkTable);

        $setup->endSetup();
    }
}
