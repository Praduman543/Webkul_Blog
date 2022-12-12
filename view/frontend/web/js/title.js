/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_Blog
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

/*jshint jquery:true*/
require(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function (
        $,
        modal
    ) {
        const MAX_WORDS = 30;
        var ellipsestext = "...";
        var moretext = "Show more";
        var lesstext = "Show less";
        $('.comments_text p').each(function(){
            var content = $(this).html();
            let count_words = content.split(' ').length;
            if(count_words > MAX_WORDS){
                var c = content.split(/\s+/).slice(0,MAX_WORDS).join(" ")
                var h = content.split(/\s+/).slice(MAX_WORDS+1,count_words).join(" ")
                $(this).html(
                   c+'<span>... </span><a href="#" class="more">Show More</a>'+
                    '<span style="display:none;"> '+ h + '  <a href="#" class="less">Show less</a></span>'
                );
            }
        });
        $('a.more').click(function(e){
            e.preventDefault();
            $(this).hide().prev().hide();
            $(this).next().show();        
        });
        
        $('a.less').click(function(e){
            e.preventDefault();
            $(this).parent().hide().prev().show().prev().show();    
        });
    }
)