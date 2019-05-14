<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 3:26 PM
 */

namespace Inchoo\ProductBookmark\Controller\BookmarkList;

use Inchoo\ProductBookmark\Controller\AbstractAction;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

class Save extends AbstractAction
{
    /**
     * @var Session
     */
    private $session;
    /**
     * @var \Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory
     */
    private $bookmarkListModelFactory;
    /**
     * @var \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface
     */
    private $bookmarkListRepository;

    public function __construct(
        Context $context,
        Session $session,
        \Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory $bookmarkListModelFactory,
        \Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface $bookmarkListRepository
    ) {
        parent::__construct($context, $session);
        $this->session = $session;
        $this->bookmarkListModelFactory = $bookmarkListModelFactory;
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
        try {
            $customerId = $this->session->getCustomerId();
            $content = $this->getRequest()->getParam('title');
            $this->bookmarkListRepository->saveToDb($content, $customerId);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(_('Could not create new bookmark list.'));
        }

        $this->messageManager->addSuccessMessage(_('Bookmark list successfully saved.'));
        return $this->_redirect('bookmark/bookmarklist/bookmarklist');
    }
}
