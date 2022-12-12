<?php
/**
 * Webkul Software
 *
 * @category    Webkul
 * @package     Webkul_Blog
 * @author      Webkul
 * @copyright   Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license     https://store.webkul.com/license.html
 */
namespace Webkul\Blog\Controller\Adminhtml\Blog;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
use Webkul\Blog\Helper\Data;
use Magento\Ui\Component\MassAction\Filter;

/**
 * MassBlogDelete Class
 */
class BlogApproveaction extends \Magento\Backend\App\Action
{

    /**
     * @param Webkul\Blog\Model\Blog
     */
    protected $_blogModel;
    /**
     * @param  Filter
     */
    protected $filter;
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_massModel;

    /** @var \Webkul\Helper\Data
     */
    protected $_helperData;

    /**
     * @param \Webkul\Blog\Model\Blog                 $blogModel
     * @param \Magento\Ui\Component\MassAction\Filter $massModel
     * @param Action\Context                          $context
     */
    public function __construct(
        \Webkul\Blog\Model\ResourceModel\Blog\CollectionFactory $blogModel,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Data $helperData,
        Filter $filter,
        \Magento\Ui\Component\MassAction\Filter $massModel,
        Action\Context $context
    ) {
        $this->filter = $filter;
        $this->_blogModel = $blogModel;
        $this->_helperData = $helperData;
        $this->_massModel = $massModel;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $adminName = $this->_scopeConfig->getValue('trans_email/ident_general/name', $storeScope);
        $adminEmail = $this->_scopeConfig->getValue('trans_email/ident_general/email', $storeScope);
        $status = 1;
        $collection = $this->filter->getCollection(
            $this->_blogModel->create()
        );
        if ($collection->getSize()) {
            try {
                foreach ($collection as $data) {
                    $bloggerId = $data->getUserId();
                    $customerName = $data->getCustomerName();
                    $customerEmail = $data->getCustomerEmail();
                    $title = $data->getSubject();
                    $senderInfo = [];
                    $receiverInfo = [];
                    $details = "";
                    $receiverInfo = [
                        'name' => $customerName,
                        'email' => $customerEmail,
                     ];
                    $senderInfo = [
                        'name' => $adminName,
                        'email' => $adminEmail,
                     ];
                    if ($status == 1) {
                        $details ="approved";
                    }
                    $emailTempVariables = [];
                    $emailTempVariables['name'] = $customerName;
                    $emailTempVariables['status'] = $details;
                    $emailTempVariables['senderName'] = $adminName;
                    $emailTempVariables['subject'] = $title;
                    $this->_helperData->blogNotification(
                        $emailTempVariables,
                        $senderInfo,
                        $receiverInfo
                    );
                }
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        if ($status == 2) {
            foreach ($collection as $blogs) {
                $blogs->delete();
            }
            $this->messageManager->addSuccess(__('Blogs deleted successfully'));
        } else {
            foreach ($collection as $blog) {
                $postId = $blog->getUserId();
                $blog->setBlogStatus($status);
                $blog->save();
            }
            $this->messageManager->addSuccess(__('Status of the selected blog(s) changed to approved'));
        }
        $this->_helperData->cleanMagentoCache();
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('wkblog/blog/manageblog/');
    }
}
