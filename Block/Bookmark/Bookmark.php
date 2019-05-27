<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 10:04 AM
 */

namespace Inchoo\ProductBookmark\Block\Bookmark;

use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
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
    /**
     * @var \Magento\Catalog\Model\Session
     */
    private $catalogSession;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Session $session,
        \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface $bookmarkListRepository,
        \Magento\Catalog\Model\Session $catalogSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->session = $session;
        $this->bookmarkListRepository = $bookmarkListRepository;
        $this->catalogSession = $catalogSession;
    }

    /**
     * Returns URL for form
     *
     * @return string
     */
    public function getAction()
    {
        return $this->getUrl('bookmark/bookmark/save');
    }

    /**
     * Returns product ID from registry
     *
     * @return mixed
     */
    public function getProductId()
    {
        return $this->getRequest()->getParam('id');
    }

    /**
     * Returns bookmark lists for logged in customer
     *
     * @return mixed
     */
    public function getBookmarkLists()
    {
        $customerId = $this->session->getCustomerId();
        $this->searchCriteriaBuilder->addFilter(BookmarkListInterface::CUSTOMER_ENTITY_ID, $customerId);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->bookmarkListRepository->getList($searchCriteria)->getItems();
    }

    public function isLoggedIn()
    {
        if (!$this->session->isLoggedIn()) {
            return false;
        }
        return true;
    }
}
