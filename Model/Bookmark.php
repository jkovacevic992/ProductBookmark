<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:54 AM
 */

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Magento\Framework\Model\AbstractModel;

class Bookmark extends AbstractModel implements BookmarkInterface
{
    protected function _construct()
    {
        $this->_init(\Inchoo\ProductBookmark\Model\ResourceModel\Bookmark::class);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->getData(self::BOOKMARK_ID);
    }

    /**
     * @param mixed $id
     * @return Bookmark|AbstractModel|mixed
     */
    public function setId($id)
    {
        return $this->setData(self::BOOKMARK_ID, $id);
    }
}
