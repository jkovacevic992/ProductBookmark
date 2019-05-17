<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 1:27 PM
 */

namespace Inchoo\ProductBookmark\Block\BookmarkList;

use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

class BookmarkList extends Template
{
    /**
     * @var \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface
     */
    private $bookmarkListRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var Session
     */
    private $session;

    public function __construct(
        Template\Context $context,
        \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface $bookmarkListRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Session $session,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->bookmarkListRepository = $bookmarkListRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->session = $session;
    }

    public function getFormAction()
    {
        return '/bookmark/bookmarklist/save';
    }

    public function getBookmarkLists()
    {
        $customerId = $this->session->getCustomerId();
        $this->searchCriteriaBuilder->addFilter(BookmarkListInterface::CUSTOMER_ENTITY_ID, $customerId);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $bookmarkLists = $this->bookmarkListRepository->getList($searchCriteria)->getItems();
        return $bookmarkLists;
    }

    public function getBookmarkListById($id)
    {
        return $this->getUrl('bookmark/bookmarklist/bookmarklistdetails/id/', ['id' => $id]);
    }

    public function removeBookmarkList($id)
    {
        return $this->getUrl('bookmark/bookmarklist/deletebookmarklist/', ['id' => $id]);
    }
}
