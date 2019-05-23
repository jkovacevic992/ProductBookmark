<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 9:54 AM
 */

namespace Inchoo\ProductBookmark\Model;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BookmarkListRepository implements BookmarkListRepositoryInterface
{
    /**
     * @var Data\BookmarkListInterfaceFactory
     */
    private $bookmarkListModelFactory;
    /**
     * @var ResourceModel\BookmarkList
     */
    private $bookmarkListResource;
    /**
     * @var ResourceModel\BookmarkList\CollectionFactory
     */
    private $bookmarkListCollectionFactory;
    /**
     * @var Data\BookmarkListSearchResultsInterfaceFactory
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
        \Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory $bookmarkListModelFactory,
        \Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList $bookmarkListResource,
        \Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList\CollectionFactory $bookmarkListCollectionFactory,
        \Inchoo\ProductBookmark\Api\Data\BookmarkListSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        Escaper $escaper
    ) {
        $this->bookmarkListModelFactory = $bookmarkListModelFactory;
        $this->bookmarkListResource = $bookmarkListResource;
        $this->bookmarkListCollectionFactory = $bookmarkListCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->escaper = $escaper;
    }

    /**
     * @param  $bookmarkListId
     * @return Data\BookmarkListInterface|mixed
     * @throws NoSuchEntityException
     */
    public function getById($bookmarkListId)
    {
        $bookmarkList = $this->bookmarkListModelFactory->create();
        $this->bookmarkListResource->load($bookmarkList, $bookmarkListId);
        if (!$bookmarkList->getId()) {
            throw new NoSuchEntityException(__('Bookmark List with that ID does not exist.'));
        }
        return $bookmarkList;
    }

    /**
     * @param  Data\BookmarkListInterface $bookmarkList
     * @return Data\BookmarkListInterface|mixed
     * @throws CouldNotSaveException
     */
    public function save(Data\BookmarkListInterface $bookmarkList)
    {
        try {
            $this->bookmarkListResource->save($bookmarkList);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $bookmarkList;
    }

    /**
     * @param  Data\BookmarkListInterface $bookmarkList
     * @return bool|mixed
     * @throws CouldNotDeleteException
     */
    public function delete(Data\BookmarkListInterface $bookmarkList)
    {
        try {
            $this->bookmarkListResource->delete($bookmarkList);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param  SearchCriteriaInterface $searchCriteria
     * @return Data\BookmarkListSearchResultsInterface|mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->bookmarkListCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /**
 * @var Data\BookmarkListSearchResultsInterface $searchResults 
*/
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param  $content
     * @param  $customerId
     * @return mixed|void
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function saveToDb($content, $customerId)
    {
        $content = $this->escaper->escapeHtml($content);

        $bookmarkList = $this->bookmarkListModelFactory->create();
        $bookmarkList->setCustomerEntityId($customerId);
        $bookmarkList->setTitle($content);
        $this->bookmarkListResource->save($bookmarkList);
    }
}
