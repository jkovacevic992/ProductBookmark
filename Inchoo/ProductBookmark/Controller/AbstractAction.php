<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 2:27 PM
 */

namespace Inchoo\ProductBookmark\Controller;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

abstract class AbstractAction extends Action
{

    /**
     * @var Session
     */
    private $session;

    public function __construct(Context $context, Session $session)
    {
        parent::__construct($context);
        $this->session = $session;
    }

    protected function isLoggedIn()
    {
        if (!$this->session->isLoggedIn()) {
            $this->session->setAfterAuthUrl($this->_url->getCurrentUrl());
            $this->session->authenticate();
        }
    }
}
