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
namespace Webkul\Blog\Block\Adminhtml\Comment;

class AddComment extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    /**
     *
     * @return void
     */
    protected function _construct()
    {
     
        $this->_objectId = 'id';
        $this->_blockGroup = 'Webkul_Blog';
        $this->_controller = 'adminhtml_comment';
        parent::_construct();
        $this->buttonList->update(
            'back',
            'onclick',
            "setLocation('"
            . $this->getUrl('wkblog/comment/postcomment/post_id/'
            .$this->getRequest()->getParam('id')) . "')"
        );
        $this->buttonList->remove('delete');
        $this->buttonList->remove('reset');
        $this->buttonList->remove('save');
    }
}
