<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:44 AM
 */

namespace Inchoo\ProductBookmark\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface BookmarkRepositoryInterface
{
    public function getById($bookmarkId);
    public function save(Data\BookmarkInterface $bookmark);
    public function delete(Data\BookmarkInterface $bookmark);
    public function getList(SearchCriteriaInterface $searchCriteria);
}
