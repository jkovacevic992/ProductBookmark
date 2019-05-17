<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:44 AM
 */

namespace Inchoo\ProductBookmark\Api\Data;

interface BookmarkInterface
{
    const BOOKMARK_ID = 'bookmark_id';

    const BOOKMARK_LIST_ENTITY_ID = 'bookmark_list_entity_id';

    const PRODUCT_ENTITY_ID = 'product_entity_id';

    const WEBSITE_ID = 'website_id';

    public function getId();

    public function setId($id);
}
