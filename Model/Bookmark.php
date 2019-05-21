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

    /**
     * @param $id
     * @return Bookmark
     */
    public function setWebsiteId($id)
    {
        return $this->setData(self::WEBSITE_ID, $id);
    }

    /**
     * @param $id
     * @return Bookmark
     */
    public function setBookmarkListEntityId($id)
    {
        return $this->setData(self::BOOKMARK_LIST_ENTITY_ID, $id);
    }

    /**
     * @param $id
     * @return Bookmark
     */
    public function setProductEntityId($id)
    {
        return $this->setData(self::PRODUCT_ENTITY_ID, $id);
    }

    /**
     * @return mixed
     */
    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    /**
     * @return mixed
     */
    public function getBookmarkListEntityId()
    {
        return $this->getData(self::BOOKMARK_LIST_ENTITY_ID);
    }

    /**
     * @return mixed
     */
    public function getProductEntityId()
    {
        return $this->getData(self::PRODUCT_ENTITY_ID);
    }
}
