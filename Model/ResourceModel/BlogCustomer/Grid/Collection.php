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
namespace Webkul\Blog\Model\ResourceModel\BlogCustomer\Grid;

use Magento\Framework\Api\Search\SearchResultInterface as SearchInterface;
use Magento\Framework\Search\AggregationInterface;
use Webkul\Blog\Model\ResourceModel\BlogCustomer\Collection as BlogCollection;

/**
 * Webkul\Blog\Model\ResourceModel\BlogCustomer\Grid Class
 * Collection for displaying grid of Blog.
 */
class Collection extends BlogCollection implements SearchInterface
{
    /**
     * @var SearchAggregationInterface
     */
    protected $_aggregations;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface    $entity
     * @param \Psr\Log\LoggerInterface                                     $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetch
     * @param \Magento\Framework\Event\ManagerInterface                    $event
     * @param \Magento\Store\Model\StoreManagerInterface                   $storeManager
     * @param mixed|null                                                   $mainTable
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb         $eventPrefix
     * @param mixed                                                        $eventObject
     * @param mixed                                                        $resourceModel
     * @param string                                                       $model
     * @param null                                                         $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null    $resource
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entity,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetch,
        \Magento\Framework\Event\ManagerInterface $event,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = \Magento\Framework\View\Element\UiComponent\DataProvider\Document::class,
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct(
            $entity,
            $logger,
            $fetch,
            $event,
            $storeManager,
            $connection,
            $resource
        );
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
        $this->_map['fields']['created_at'] = 'main_table.created_at';
    }

    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->_aggregations;
    }

    /**
     * @param AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->_aggregations = $aggregations;
    }

    /**
     * Retrieve all ids for collection
     * Backward compatibility with EAV collection
     *
     * @param  int $limitCount
     * @param  int $offset
     * @return array
     */
    public function getAllIds($limitCount = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limitCount, $offset), $this->_bindParams);
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param                                         \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return                                        $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param                                         int $totalCount
     * @return                                        $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param                                         \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return                                        $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * renders fileter before.
     *
     * @return                                        parent
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _renderFiltersBefore()
    {
        $joinTable = $this->getTable('customer_grid_flat');
        $this->getSelect()->join(
            $joinTable.' as customer',
            'main_table.user_id = customer.entity_id',
            ['name', 'email', 'billing_telephone', 'billing_country_id', 'billing_city', 'billing_postcode']
        );
        parent::_renderFiltersBefore();
    }
}
