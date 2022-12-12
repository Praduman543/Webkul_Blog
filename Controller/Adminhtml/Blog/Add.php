<?php
namespace Webkul\Blog\Controller\Adminhtml\Blog;
use Magento\Backend\App\Action;
use Webkul\Blog\Model\Blog as Blog;

class Add extends \Magento\Backend\App\Action
{
    /**
     * Edit A Contact Page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();

        $contactDatas = $this->getRequest()->getParam('contact');
        if(is_array($contactDatas)) {
            $contact = $this->_objectManager->create(Contact::class);
            $contact->setData($contactDatas)->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/grid');
        }
    }
}