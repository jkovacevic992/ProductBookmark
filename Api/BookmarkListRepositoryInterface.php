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
    /**
     * @param  $bookmarkListId
     * @return mixed
     */
    public function getById($bookmarkListId);

    /**
     * @param  Data\BookmarkListInterface $bookmarkList
     * @return mixed
     */
    public function save(Data\BookmarkListInterface $bookmarkList);

    /**
     * @param  Data\BookmarkListInterface $bookmarkList
     * @return mixed
     */

    /**
     * @param  Data\BookmarkListInterface $bookmarkList
     * @return mixed
     */
    public function delete(Data\BookmarkListInterface $bookmarkList);

    /**
     * @param  SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param  $content
     * @param  $customerId
     * @return mixed
     */
    public function saveToDb($content, $customerId);
}
