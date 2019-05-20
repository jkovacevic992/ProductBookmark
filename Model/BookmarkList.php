<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:54 AM
 */

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Magento\Framework\Model\AbstractModel;

class BookmarkList extends AbstractModel implements BookmarkListInterface
{
    protected function _construct()
    {
        $this->_init(\Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList::class);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->getData(self::BOOKMARK_LIST_ID);
    }

    /**
     * @param mixed $id
     * @return BookmarkList|AbstractModel|mixed
     */
    public function setId($id)
    {
        return $this->setData(self::BOOKMARK_LIST_ID, $id);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getData(self::BOOKMARK_LIST_TITLE);
    }

    /**
     * @param $title
     * @return BookmarkList|mixed
     */
    public function setTitle($title)
    {
        return $this->setData(self::BOOKMARK_LIST_TITLE, $title);
    }
}
