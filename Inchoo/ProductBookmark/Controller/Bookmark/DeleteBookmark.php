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

    public function __construct(
        Context $context,
        Session $session,
        \Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface $bookmarkRepository
    ) {
        parent::__construct($context, $session);
        $this->bookmarkRepository = $bookmarkRepository;
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
        $bookmarkId = $this->getRequest()->getParam('id');
        $bookmark = $this->bookmarkRepository->getById($bookmarkId);
        $this->bookmarkRepository->delete($bookmark);
        $this->messageManager->addSuccessMessage('Product removed from bookmark list.');
        return $this->_redirect('bookmark/bookmarklist/bookmarklist');
    }
}