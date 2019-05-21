<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:54 AM
 */

namespace Inchoo\ProductBookmark\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Bookmark extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('bookmark', 'bookmark_id');
    }
}
