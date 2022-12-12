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
namespace Webkul\Blog\Block\Adminhtml\Comment\Edit;

/**
 * Adminhtml Blog category Edit Form
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig, //in your constructor pass the following argument
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {

        parent::_construct();
        $this->setId('comment_form');
        $this->setTitle(__('View Comment'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
       
        $model = $this->_coreRegistry->registry('PostComment');
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form',
                        'action' => $this->getData('action'),
                        'method' => 'post'
                        ]
                    ]
        );
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Comment'), 'class' => 'fieldset-wide']
        );
     
        $fieldset->addField(
            'comment',
            'editor',
            [
                'name' => 'comment',
                'label' => __('Comment'),
                'title' => __('Comment'),
                'style' => 'height:10em',
                'required' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );
       
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
