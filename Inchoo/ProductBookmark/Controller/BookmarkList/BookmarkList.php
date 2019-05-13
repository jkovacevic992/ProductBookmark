<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 1:23 PM
 */

namespace Inchoo\ProductBookmark\Controller\BookmarkList;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class BookmarkList extends Action
{

    /**
     * @var PageFactory
     */
    protected $pageFactory;
    /**
     * @var Session
     */
    protected $session;

    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
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
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->set('My Bookmarks');
        return $resultPage;
    }
}
