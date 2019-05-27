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
use Magento\Framework\App\Request\Http;

class Save extends AbstractAction
{
    /**
     * @var \Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * @var Http
     */
    private $request;

    public function __construct(
        Context $context,
        \Inchoo\ProductBookmark\Api\BookmarkRepositoryInterface $bookmarkRepository,
        Session $session,
        Http $request
    ) {
        parent::__construct($context, $session);
        $this->bookmarkRepository = $bookmarkRepository;
        $this->request = $request;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $this->isLoggedIn();
        $content = $this->request->getPost();
        if ($content['list'] === null || $content['list'] === '') {
            $this->messageManager->addErrorMessage('No bookmark list selected.');
            return $this->_redirect($this->_redirect->getRefererUrl());
        }
        if (!$this->bookmarkRepository->saveToDb($content)) {
            $this->messageManager->addErrorMessage('This product is already in your list.');
        } else {
            $this->messageManager->addSuccessMessage('Product saved to bookmark list.');
        }
        return $this->_redirect('bookmark/bookmarklist/bookmarklistdetails/id/' . $content['list']);
    }
}
