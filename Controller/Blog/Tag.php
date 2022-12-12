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

namespace Webkul\Blog\Controller\Blog;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Webkul\Blog\Api\BlogRepositoryInterface;

/**
 * Tag Class
 * blog tags
 */
class Tag extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;
    
    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory,
        BlogRepositoryInterface $blogRepository,
        PageFactory $resultPageFactory
    ) {
        $this->_blogRepository = $blogRepository;
        $this->_categoryFactory = $categoryFactory;
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $pageTitle = $this->getRequest()->getParam('tag');
        if (isset($pageTitle) && (!empty($pageTitle))) {
            $collection = $this->_blogRepository->getBlogByTagName($pageTitle);
            $categoryCollection = $this->_categoryFactory->getTable('wk_category');
            $collection->getSelect()->joinleft(
                $categoryCollection.' as pd',
                'main_table.category_id = pd.id',
                ['category','status']
            );
            $collection = $collection->addFieldToFilter('blog_status', ['eq'=>1])->setOrder('created_at', 'DESC');
            foreach ($collection as $blog) {
                $resultPage->getConfig()->setDescription($blog->getMetadescription());
                $resultPage->getConfig()->setKeywords($blog->getMetakeywords());
            }
            $resultPage->getConfig()->getTitle()->set($pageTitle);
        } else {
            $this->_forward('defaultNoRoute');
        }
        return $resultPage;
    }
}
