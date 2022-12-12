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
use Magento\Security\Model\AdminSessionsManager;
use Magento\Store\Model\StoreManagerInterface;

/**
 * BloggerAction Class
 */
class ViewFullBlog extends Column
{
    const BLOG_URL = "wkblog/blog/title/blogid/";
    /**
     * @var AdminSessionsManager
     */
    protected $adminSessionsManager;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManagerInterface;

    protected $_coreRegistry = null;

    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;
    /**
     * @param AdminSessionsManager $adminSessionsManager
     * @param ContextInterface   $context
     * @param StoreManagerInterface $storeManagerInterface
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        AdminSessionsManager $adminSessionsManager,
        ContextInterface $context,
        StoreManagerInterface $storeManagerInterface,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->adminSessionsManager = $adminSessionsManager;
        $this->_storeManagerInterface = $storeManagerInterface;
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

        $adminSession = $this->adminSessionsManager;
        $baseUrl = $this->getBaseUrl();
        if (isset($dataSource['data']['items'])) {
            $name = $this->getData('name');
            $blogId = $this->context->getFilterParam('id');
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$name] =
                "<a href='" . $baseUrl . self::BLOG_URL . $item['id'] . '/?SID='
                . $adminSession->getCurrentSession()->getSessionId() . "
                ' target='blank' title='" . __('View Full Blog') . "'>" . __('View Full Blog') . '</a>';
            }
        }
        // echo"<pre>";
        // print_r($dataSource);die;
        return $dataSource;
    }

    /**
     * to get Base Url
     * @return baseurl
     */
    public function getBaseUrl()
    {
        return $this->_storeManagerInterface->getStore()->getBaseUrl();
    }
}
