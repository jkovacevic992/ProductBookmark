<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 10:37 AM
 */

namespace Inchoo\ProductBookmark\Controller\Bookmark;

use Inchoo\ProductBookmark\Controller\AbstractAction;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

class Save extends AbstractAction
{
    /**
     * @var \Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    public function __construct(
        Context $context,
        \Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface $bookmarkRepository,
        Session $session
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
        $this->isLoggedIn();
        $content = $this->getRequest()->getParams();

        $this->bookmarkRepository->saveToDb($content);

        return $this->_redirect('bookmark/bookmarklist/bookmarklist');
    }
}
