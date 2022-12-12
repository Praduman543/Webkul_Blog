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
namespace Webkul\Blog\Controller\Adminhtml\Comment;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Webkul\Blog\Model\PostComment;
use Magento\Framework\Registry;

class AddComment extends Action
{
    
    protected $_session;

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var Attributes
     */
    protected $_postComment;

    /**
     * @param Context     $context
     * @param Registry    $registry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PostComment $postComment,
        PageFactory $resultPageFactory
    ) {
        $this->_registry = $registry;
        $this->_postComment = $postComment;
        $this->_session = $context->getSession();
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }
    
    /**
     * @return page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
       
        $postComment =  $this->_postComment;
        if ($this->getRequest()->getParam('id')) {
            $postComment->load($id, 'id');
        }
      
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $postComment->setData($data);
        }
     
        $this->_registry->register('PostComment', $postComment);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Comment'));
        $content = $resultPage->getLayout()->createBlock(\Webkul\Blog\Block\Adminhtml\Comment\AddComment::class);
        $resultPage->addContent($content);
        return $resultPage;
    }
}
