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

    public function getId();

    public function setId($id);
}
