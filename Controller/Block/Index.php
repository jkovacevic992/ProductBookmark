<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/23/19
 * Time: 10:09 AM
 */

namespace Inchoo\ProductBookmark\Controller\Block;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\LayoutFactory;

class Index extends Action
{

    /**
     * @var LayoutFactory
     */
    private $layoutFactory;

    public function __construct(Context $context, LayoutFactory $layoutFactory)
    {
        parent::__construct($context);
        $this->layoutFactory = $layoutFactory;
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
        $result = $this->layoutFactory->create();
        return $result;
    }
}
