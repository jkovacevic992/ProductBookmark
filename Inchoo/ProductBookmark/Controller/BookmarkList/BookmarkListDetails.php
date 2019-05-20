<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 8:35 AM
 */

namespace Inchoo\ProductBookmark\Controller\BookmarkList;

use Inchoo\ProductBookmark\Controller\AbstractAction;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class BookmarkListDetails extends AbstractAction
{

    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface
     */
    private $bookmarkListRepository;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Session $session,
        \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface $bookmarkListRepository
    ) {
        parent::__construct($context, $session);
        $this->pageFactory = $pageFactory;
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $this->isLoggedIn();
        $bookmarkListId = $this->getRequest()->getParam('id');
        $bookmarkList = $this->bookmarkListRepository->getById($bookmarkListId);
        if (!$this->checkCustomerPermissions($bookmarkList->getCustomerEntityId())) {
            $this->messageManager->addErrorMessage(_('Access forbidden.'));
            return $this->_redirect('customer/account');
        }

        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('My Bookmarks'));
        return $resultPage;

    }
}
