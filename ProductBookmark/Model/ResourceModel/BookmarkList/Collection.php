<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:53 AM
 */

namespace Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Inchoo\ProductBookmark\Model\BookmarkList::class,
            \Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList::class
        );
    }
}
