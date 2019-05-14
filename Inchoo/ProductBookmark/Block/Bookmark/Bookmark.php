<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 10:04 AM
 */

namespace Inchoo\ProductBookmark\Block\Bookmark;

use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class Bookmark extends Template
{
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface
     */
    private $bookmarkListRepository;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Session $session,
        \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface $bookmarkListRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->session = $session;
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    public function getAction()
    {
        return $this->getUrl('bookmark/bookmark/save');
    }

    public function getProductId()
    {
        return $this->registry->registry('product')->getId();
    }

    public function getBookmarkLists()
    {
        $customerId = $this->session->getCustomerId();
        $this->searchCriteriaBuilder->addFilter('customer_entity_id', $customerId);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $bookmarkLists = $this->bookmarkListRepository->getList($searchCriteria)->getItems();
        return $bookmarkLists;
    }
}
