<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 12:09 PM
 */

namespace Inchoo\ProductBookmark\Controller\BookmarkList;

use Inchoo\ProductBookmark\Controller\AbstractAction;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class DeleteBookmarkList extends AbstractAction
{
    /**
     * @var \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface
     */
    private $bookmarkListRepository;

    public function __construct(
        Context $context,
        Session $session,
        \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface $bookmarkListRepository
    ) {
        parent::__construct($context, $session);
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
        try {
            $bookmarkListId = $this->getRequest()->getParam('id');
            $bookmarkList = $this->bookmarkListRepository->getById($bookmarkListId);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('No such bookmark list.'));
            return $this->_redirect('bookmark/bookmarklist/bookmarklist');
        }

        if ($customerId !== $bookmarkList->getCustomerEntityId()) {
            $this->messageManager->addErrorMessage(__('Access forbidden.'));
            return $this->_redirect('bookmark/bookmarklist/bookmarklist');
        }

        if (!$this->bookmarkListRepository->delete($bookmarkList)) {
            $this->messageManager->addErrorMessage(__('Cannot delete bookmark list.'));
            return $this->_redirect('bookmark/bookmarklist/bookmarklist');
        }

        $this->messageManager->addSuccessMessage(__('Bookmark list deleted.'));
        return $this->_redirect('bookmark/bookmarklist/bookmarklist');
    }
}
