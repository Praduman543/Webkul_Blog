<?php
/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_Blog
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\Blog\Controller\Blog;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

/**
 * ViewPost Class
 * view post page
 */
class ViewPost extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;
    
    /**
     * @param Context     $context
     * @param PageFactory $reultPageFactory
     * @param array       $data
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Webkul\Blog\Helper\Data $helper
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Blog'));
        return $resultPage;
    }

    public function getHelper()
    {
        return $this->helper;
    }
}
