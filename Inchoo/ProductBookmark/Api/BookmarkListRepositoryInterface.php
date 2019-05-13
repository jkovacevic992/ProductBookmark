<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:43 AM
 */

namespace Inchoo\ProductBookmark\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface BookmarkListRepositoryInterface
{
    public function getById($bookmarkListId);
    public function save(Data\BookmarkListInterface $bookmarkList);
    public function delete(Data\BookmarkListInterface $bookmarkList);
    public function getList(SearchCriteriaInterface $searchCriteria);
    public function saveToDb($content, $customerId);
}
