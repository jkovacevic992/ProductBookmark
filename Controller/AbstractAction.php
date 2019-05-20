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
    protected $session;

    public function __construct(Context $context, Session $session)
    {
        parent::__construct($context);
        $this->session = $session;
    }

    /**
     * Check if user is logged in
     */
    protected function isLoggedIn()
    {
        if (!$this->session->isLoggedIn()) {
            $this->session->setAfterAuthUrl($this->_url->getCurrentUrl());
            $this->session->authenticate();
        }
    }

    /**
     * Check if customer has permissions for bookmark list
     * @param $id
     * @return bool
     */
    protected function checkCustomerPermissions($id)
    {
        $customerId = $this->session->getCustomerId();
        if ($id !== $customerId) {
            return false;
        }
        return true;
    }
}
