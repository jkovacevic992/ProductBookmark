<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 10:04 AM
 */

namespace Inchoo\ProductBookmark\Block\Bookmark;

use Inchoo\ProductBookmark\Api\Data\BookmarkListInterface;
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
     * @var \Magento\Customer\Model\SessionFactory
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
        \Magento\Customer\Model\SessionFactory $session,
        \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface $bookmarkListRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->session = $session;
        $this->bookmarkListRepository = $bookmarkListRepository;
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
        return $this->registry->registry('product')->getId();
    }

    /**
     * Returns bookmark lists for logged in customer
     *
     * @return mixed
     */
    public function getBookmarkLists()
    {
        $customerId = $this->session->create()->getCustomerId();
        $this->searchCriteriaBuilder->addFilter(BookmarkListInterface::CUSTOMER_ENTITY_ID, $customerId);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->bookmarkListRepository->getList($searchCriteria)->getItems();
    }

    public function isLoggedIn()
    {
        if (!$this->session->create()->isLoggedIn()) {
            return false;
        }
        return true;
    }
}
