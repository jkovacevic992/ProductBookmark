<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 12:31 PM
 */

namespace Inchoo\ProductBookmark\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), "1.1.0", "<")) {
            $setup->getConnection()->addColumn(
                $setup->getTable('bookmark'),
                'website_id',
                ['type' => Table::TYPE_SMALLINT, 'nullable' => false, 'unsigned' => true, 'comment' => 'Website ID']
            );

            $setup->getConnection()->addForeignKey(
                $setup->getFkName('bookmark', 'website_id', 'store_website', 'website_id'),
                'bookmark',
                'website_id',
                'store_website',
                'website_id',
                Table::ACTION_CASCADE
            );
            $setup->endSetup();
        }
    }
}
