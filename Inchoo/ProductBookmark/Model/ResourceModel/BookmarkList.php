<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:53 AM
 */

namespace Inchoo\ProductBookmark\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class BookmarkList extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('bookmark_list', 'bookmark_list_id');
    }
}
