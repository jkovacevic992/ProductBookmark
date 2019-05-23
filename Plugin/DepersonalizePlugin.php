<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/23/19
 * Time: 8:45 AM
 */

namespace Inchoo\ProductBookmark\Plugin;

use Magento\Customer\Model\Session;
use Magento\PageCache\Model\DepersonalizeChecker;

class DepersonalizePlugin
{

    /**
     * @var DepersonalizeChecker
     */
    protected $depersonalizeChecker;

    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $session;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var \Magento\Customer\Model\Visitor
     */
    protected $visitor;

    /**
     * @var int
     */
    protected $customerGroupId;

    protected $customerId;

    /**
     * @var string
     */
    protected $formKey;

    /**
     * @param DepersonalizeChecker $depersonalizeChecker
     * @param \Magento\Framework\Session\SessionManagerInterface $session
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\Customer\Model\Visitor $visitor
     */
    public function __construct(
        DepersonalizeChecker $depersonalizeChecker,
        \Magento\Framework\Session\SessionManagerInterface $session,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\Visitor $visitor
    ) {
        $this->session = $session;
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
        $this->visitor = $visitor;
        $this->depersonalizeChecker = $depersonalizeChecker;
    }

    /**
     * Before generate Xml
     *
     * @param \Magento\Framework\View\LayoutInterface $subject
     * @return array
     */
    public function beforeGenerateXml(\Magento\Framework\View\LayoutInterface $subject)
    {
        if ($this->depersonalizeChecker->checkIfDepersonalize($subject)) {
            $this->customerGroupId = $this->customerSession->getCustomerGroupId();
            $this->customerId = $this->customerSession->getCustomerId();
            $this->formKey = $this->session->getData(\Magento\Framework\Data\Form\FormKey::FORM_KEY);
        }
        return [];
    }

    /**
     * After generate Xml
     *
     * @param \Magento\Framework\View\LayoutInterface $subject
     * @param \Magento\Framework\View\LayoutInterface $result
     * @return \Magento\Framework\View\LayoutInterface
     */
    public function afterGenerateXml(\Magento\Framework\View\LayoutInterface $subject, $result)
    {
        if ($this->depersonalizeChecker->checkIfDepersonalize($subject)) {
            $this->visitor->setSkipRequestLogging(true);
            $this->visitor->unsetData();
            $this->session->clearStorage();
            $this->customerSession->clearStorage();
            $this->session->setData(\Magento\Framework\Data\Form\FormKey::FORM_KEY, $this->formKey);
            $this->customerSession->setCustomerGroupId($this->customerGroupId);
            $this->customerSession->setCustomerId($this->customerId);
            $this->customerSession->setCustomer($this->customerFactory->create()->setGroupId($this->customerGroupId));
        }
        return $result;
    }
}
