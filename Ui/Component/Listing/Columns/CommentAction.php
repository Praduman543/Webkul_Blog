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
namespace Webkul\Blog\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

/**
 * CategoryAction Class
 * Edit Action For Category
 */
class CommentAction extends Column
{
    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;

    protected $_coreRegistry = null;

    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param  array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $storeId = $this->context->getFilterParam('id');
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['viewcomment'] = [
                    'href' => $this->_urlBuilder->getUrl(
                        'wkblog/comment/addcomment',
                        ['id' => $item['id'], 'store' => $storeId]
                    ),
                    'label' => __('View Comment'),
                    'hidden' => false,
                ];
            }
        }
        return $dataSource;
    }
}
