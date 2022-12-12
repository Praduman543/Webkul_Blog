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
namespace Webkul\Blog\Model;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * PostCommentStatus Class
 * post comment status to array
 */
class PostCommentStatus implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
                        [
                            'label' => __('Pending'),
                            'value' => 0
                        ],
                        [
                            'label' => __('Approved'),
                            'value' => 1
                        ]
                    ];
        return $options;
    }
}
