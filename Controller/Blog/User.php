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
 * User Class
 * blog users
 */
class User extends \Magento\Framework\App\Action\Action
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
        \Magento\Customer\Model\Customer $customerModel,
        \Webkul\Blog\Helper\Data $helperData
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_customerModel = $customerModel;
        $this->helperData = $helperData;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $id = $this->getRequest()->getParam('userid');
        if (isset($id) && (!empty($id))) {
            $customer = $this->_customerModel->load($this->getRequest()->getParam('userid'))->getData();
            $resultPage->getConfig()->getTitle()->set($customer['firstname']." ".$customer['lastname']);
        } else {
            $this->_forward('defaultNoRoute');
        }
        return $resultPage;
    }
    public function getHelper()
    {
        return $this->helperData;
    }
}
