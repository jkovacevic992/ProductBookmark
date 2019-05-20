<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 1:56 PM
 */

namespace Inchoo\ProductBookmark\Ui\Component\Listing;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    private $bookmarkCollection;

    public function __construct(
        $name,
        $primaryFieldName,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark\CollectionFactory $bookmarkCollection,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->bookmarkCollection = $bookmarkCollection;
        $this->collection = $productCollectionFactory->create();
    }

    /**
     *
     *
     * {@inheritdoc}
     */
    public function getData()
    {
        $bookmarks = $this->bookmarkCollection->create();
        $bookmarks->load();
        $array = [];

        foreach ($bookmarks as $bookmark) {
            $array[] = $bookmark->getProductEntityId();
        }
        $timesBookmarked = array_count_values($array);

        try {
            $items = $this->getCollection()->addFieldToFilter('entity_id', $array)->addAttributeToSelect('name')->toArray();
        } catch (\Exception $e) {
            return false;
        }
        $data = [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => array_values($items),
        ];

        foreach ($data['items'] as $key => $product) {
            $productId = $product['entity_id'];
            $data['items'][$key]['bookmarked'] = $timesBookmarked[$productId];
        }

        return $data;
    }
}
