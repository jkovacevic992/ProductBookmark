<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:44 AM
 */

namespace Inchoo\ProductBookmark\Api\Data;

interface BookmarkListInterface
{
    const BOOKMARK_LIST_ID = 'bookmark_list_id';
    const BOOKMARK_LIST_TITLE = 'bookmark_list_title';
    const CUSTOMER_ENTITY_ID = 'customer_entity_id';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param  $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param  $title
     * @return mixed
     */
    public function setTitle($title);
}
