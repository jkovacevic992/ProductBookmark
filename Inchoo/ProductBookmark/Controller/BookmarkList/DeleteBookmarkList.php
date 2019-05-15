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
        $bookmarkListId = $this->getRequest()->getParam('id');
        $bookmarkList = $this->bookmarkListRepository->getById($bookmarkListId);
        $this->bookmarkListRepository->delete($bookmarkList);
        $this->messageManager->addSuccessMessage('Bookmark list deleted.');
        return $this->_redirect('bookmark/bookmarklist/bookmarklist');
    }
}
