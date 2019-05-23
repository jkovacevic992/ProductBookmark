<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 9:31 AM
 */

namespace Inchoo\ProductBookmark\Controller\Bookmark;

use Inchoo\ProductBookmark\Controller\AbstractAction;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

class DeleteBookmark extends AbstractAction
{
    /**
     * @var \Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface
     */
    private $bookmarkRepository;
    /**
     * @var \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface
     */
    private $bookmarkListRepository;

    public function __construct(
        Context $context,
        Session $session,
        \Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface $bookmarkRepository,
        \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface $bookmarkListRepository
    ) {
        parent::__construct($context, $session);
        $this->bookmarkRepository = $bookmarkRepository;
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
        $customerId = $this->session->getCustomerId();
        $bookmarkId = $this->getRequest()->getParam('id');
        try {
            $bookmark = $this->bookmarkRepository->getById($bookmarkId);
            $bookmarkList = $this->bookmarkListRepository->getById($bookmark->getBookmarkListEntityId());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage('Cannot delete bookmark.');
            return $this->_redirect('bookmark/bookmarklist/bookmarklist');
        }
        if ($customerId !== $bookmarkList->getCustomerEntityId()) {
            $this->messageManager->addErrorMessage('Access forbidden.');
            return $this->_redirect('bookmark/bookmarklist/bookmarklist');
        }
        $this->bookmarkRepository->delete($bookmark);
        $this->messageManager->addSuccessMessage('Product removed from bookmark list.');
        return $this->_redirect($this->_redirect->getRefererUrl());
    }
}
