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
    /**
     * @param  $bookmarkId
     * @return mixed
     */
    public function getById($bookmarkId);

    /**
     * @param  Data\BookmarkInterface $bookmark
     * @return mixed
     */
    public function save(Data\BookmarkInterface $bookmark);

    /**
     * @param  Data\BookmarkInterface $bookmark
     * @return mixed
     */
    public function delete(Data\BookmarkInterface $bookmark);

    /**
     * @param  SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
