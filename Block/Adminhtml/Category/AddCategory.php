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
namespace Webkul\Blog\Block\Adminhtml\Category;

class AddCategory extends \Magento\Backend\Block\Widget\Form\Container
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
        $this->_controller = 'adminhtml_category';
        parent::_construct();
        $this->buttonList->remove('reset');
        $this->buttonList->remove('delete');
        $this->buttonList->update(
            'back',
            'onclick',
            "setLocation('" . $this->getUrl('wkblog/category/managecategories') . "')"
        );
        $this->buttonList->update('save', 'label', __('Save'));
    }
}
