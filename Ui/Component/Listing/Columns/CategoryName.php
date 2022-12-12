<?php
/**
 * Webkul Blog Category Name UI.
 * @category  Webkul
 * @package   Webkul_Blog
 * @author    Webkul
 * @copyright Copyright (c)  Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace  Webkul\Blog\Ui\Component\Listing\Columns;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Webkul\Blog\Model\CategoryFactory;

/**
 * Class Categoryname.
 * Get Category Name
 */
class CategoryName extends Column
{
    /**
     * @var  Webkul\Blog\Model\CategoryFactory
     */
    private $categoryFactory;

    /**
     * Constructor.
     *
     * @param ContextInterface           $context
     * @param UiComponentFactory         $uiComponentFactory
     * @param CategoryFactory            $categoryFactory
     * @param array                      $components
     * @param array                      $data
     */

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CategoryFactory $categoryFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->CategoryFactory = $categoryFactory;
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $customer =  $this->CategoryFactory->create()->getCollection()
                ->addFieldToFilter('entity_id', $item['category_id'])->getFirstItem();
                $item[$this->getData('name')] = $customer->getCategory();
            }
        }
        return $dataSource;
    }
}
