<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:54 AM
 */

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BookmarkRepository implements BookmarkRepositoryInterface
{

    /**
     * @var Data\BookmarkInterfaceFactory
     */
    private $bookmarkModelFactory;
    /**
     * @var ResourceModel\Bookmark
     */
    private $bookmarkResource;
    /**
     * @var ResourceModel\Bookmark\CollectionFactory
     */
    private $bookmarkCollectionFactory;
    /**
     * @var Data\BookmarkSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var Escaper
     */
    private $escaper;

    public function __construct(
        \Inchoo\ProductBookmark\Api\Data\BookmarkInterfaceFactory $bookmarkModelFactory,
        \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark $bookmarkResource,
        \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark\CollectionFactory $bookmarkCollectionFactory,
        \Inchoo\ProductBookmark\Api\Data\BookmarkSearchResultsInterfaceFactory $searchResultsFactory,
        Escaper $escaper,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->bookmarkModelFactory = $bookmarkModelFactory;
        $this->bookmarkResource = $bookmarkResource;
        $this->bookmarkCollectionFactory = $bookmarkCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->escaper = $escaper;
    }

    public function getById($bookmarkId)
    {
        $bookmark = $this->bookmarkModelFactory->create();
        $this->bookmarkResource->load($bookmark, $bookmarkId);
        if (!$bookmark->getId()) {
            throw new NoSuchEntityException(__('Bookmark with that ID does not exist.'));
        }
        return $bookmark;
    }

    public function save(Data\BookmarkInterface $bookmark)
    {
        try {
            $this->bookmarkResource->save($bookmark);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $bookmark;
    }

    public function delete(Data\BookmarkInterface $bookmark)
    {
        try {
            $this->bookmarkResource->delete($bookmark);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->bookmarkCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\BookmarkSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function saveToDb($content)
    {
        $productId = $this->escaper->escapeHtml($content['productId']);
        $bookmarkListId = $this->escaper->escapeHtml($content['list']);
        $bookmarkCheck = $this->bookmarkCollectionFactory->create();
        $bookmarkCheck
            ->addFieldToFilter('product_entity_id', ['eq' => $productId])
            ->addFieldToFilter('bookmark_list_entity_id', ['eq' => $bookmarkListId]);
        $id = $bookmarkCheck->getData();
        if (!empty($id)) {
            return false;
        }
        $bookmark = $this->bookmarkModelFactory->create();
        $bookmark->setBookmarkListEntityId($bookmarkListId);
        $bookmark->setProductEntityId($productId);
        $this->bookmarkResource->save($bookmark);
        return true;
    }


}
