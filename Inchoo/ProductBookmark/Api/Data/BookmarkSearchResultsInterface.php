<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:46 AM
 */

namespace Inchoo\ProductBookmark\Api\Data;

use Magento\Framework\Api\Search\SearchResultInterface;

interface BookmarkSearchResultsInterface extends SearchResultInterface
{
    public function getItems();

    public function setItems(array $items = null);
}
