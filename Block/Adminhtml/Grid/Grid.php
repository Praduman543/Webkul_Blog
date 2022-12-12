<?php
namespace Webkul\Blog\Block\Adminhtml\Grid;

class Grid extends \Magento\Backend\Block\Widget\Grid\Container
{

	protected function _construct()
	{
		$this->_controller = 'adminhtml_wkblog';
		$this->_blockGroup = ' Webkul_Blog';
		$this->_headerText = __('Posts');
		parent::_construct();

		$this->removeButton('add');

		/// for add new custome btn
    
		$this->addButton(
			'Create New Post',
			[
				'label' => __('Create New Post'),
				'on_click' => sprintf("location.href = '%s';", $this->getUrl('wkblog/blog/edit')),
				'class' => 'primary',
				'level' => 1
			]
		);
	}
}