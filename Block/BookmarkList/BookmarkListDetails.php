<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 8:41 AM
 */

namespace Inchoo\ProductBookmark\Block\BookmarkList;

use Inchoo\ProductBookmark\Api\Data\BookmarkInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

class BookmarkListDetails extends Template
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productCollectionFactory;
    /**
     * @var \Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface
     */
    private $bookmarkRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var \Magento\Catalog\Helper\Image
     */
    private $helper;

    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface $bookmarkRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Catalog\Helper\Image $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productCollectionFactory = $productCollectionFactory;
        $this->bookmarkRepository = $bookmarkRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->helper = $helper;
    }

    /**
     * Returns product collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductCollection()
    {
        $websiteId = $this->_storeManager->getStore()->getWebsiteId();
        $bookmarkListId = $this->getRequest()->getParam('id');
        $this->searchCriteriaBuilder
            ->addFilter(BookmarkInterface::BOOKMARK_LIST_ENTITY_ID, $bookmarkListId)
            ->addFilter(BookmarkInterface::WEBSITE_ID, $websiteId);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $bookmarks = $this->bookmarkRepository->getList($searchCriteria)->getItems();
        $array = [];
        foreach ($bookmarks as $bookmark) {
            $array[] = $bookmark->getProductEntityId();
        }
        if (empty($array)) {
            return null;
        }
        $collection = $this->productCollectionFactory->create();
        $collection
            ->addFieldToFilter('entity_id', $array)
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('image')
            ->addAttributeToSelect('price');
        $collection->getData();

        return $collection;
    }

    /**
     * Load product image
     *
     * @param  $product
     * @param  $image
     * @return string
     */
    public function getImage($product, $image)
    {
        return $this->helper->init($product, $image)->getUrl();
    }

    /**
     * Remove product from bookmark list by ID
     *
     * @param  $productId
     * @return string
     */
    public function removeProduct($productId)
    {
        $bookmarkListId = $this->getRequest()->getParam('id');
        $this->searchCriteriaBuilder
            ->addFilter(BookmarkInterface::BOOKMARK_LIST_ENTITY_ID, $bookmarkListId)
            ->addFilter(BookmarkInterface::PRODUCT_ENTITY_ID, $productId);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $bookmark = $this->bookmarkRepository->getList($searchCriteria)->getItems();
        return $this->getUrl('bookmark/bookmark/deletebookmark/id/', ['id' => reset($bookmark)->getId()]);
    }
}
