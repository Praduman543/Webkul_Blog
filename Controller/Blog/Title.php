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
use Magento\Framework\Controller\ResultFactory;

/**
 * Title Class
 * blog title
 */
class Title extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Webkul\Blog\Model\Blog $blogModel
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_blogModel = $blogModel;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('blogid');
        $resultPage = $this->_resultPageFactory->create();
        if (isset($id) && (!empty($id))) {
            $subject = $this->_blogModel->load($id)->getSubject();
            $resultPage->getConfig()->getTitle()->set($subject);
            return $resultPage;
        } else {
            $this->_forward('defaultNoRoute');
            return $resultPage;
        }
    }
}
