<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 1:27 PM
 */

namespace Inchoo\ProductBookmark\Block\BookmarkList;

use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
use Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

class BookmarkList extends Template
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var \Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList\CollectionFactory
     */
    private $collection;

    public function __construct(
        Template\Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory $collection,
        Session $session,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->session = $session;
        $this->collection = $collection;
    }

    /**
     * Returns URL for form action
     * @return string
     */
    public function getFormAction()
    {
        return '/bookmark/bookmarklist/save';
    }

    /**
     * Returns Bookmark list by ID
     * @param $id
     * @return string
     */
    public function getBookmarkListById($id)
    {
        return $this->getUrl('bookmark/bookmarklist/bookmarklistdetails/id/', ['id' => $id]);
    }


    /**
     * Removes Bookmark list by ID
     * @param $id
     * @return string
     */
    public function removeBookmarkList($id)
    {
        return $this->getUrl('bookmark/bookmarklist/deletebookmarklist/', ['id' => $id]);
    }

    /**
     * Pagination
     * @return $this|Template
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Custom Pagination'));
        if ($this->getBookmarkListCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getBookmarkListCollection()
                );
            $this->setChild('pager', $pager);
            $this->getBookmarkListCollection()->load();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Returns Bookmark list collection for pagination
     * @return \Inchoo\ProductBookmark\Model\ResourceModel\BookmarkList\Collection
     */
    public function getBookmarkListCollection()
    {
        $customerId = $this->session->getCustomerId();
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest(

        )->getParam('limit') : 5;
        $collection = $this->collection->create();
        $collection->addFieldToFilter(BookmarkListInterface::CUSTOMER_ENTITY_ID, ['eq' => $customerId]);
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }
}
