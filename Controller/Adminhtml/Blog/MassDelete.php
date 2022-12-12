<?php
namespace Webkul\Blog\Controller\Adminhtml\Blog;
use Magento\Backend\App\Action;
use Webkul\Blog\Model\Contact;

class MassDelete extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected', []);
        if (!is_array($ids) || !count($ids)) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }
        foreach ($ids as $id) {
            if ($contact = $this->_objectManager->create(Contact::class)->load($id)) {
                $contact->delete();
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', count($ids)));

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}