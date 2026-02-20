<?php
// 子比主题小工具扩展模块代码
$widgets_files_list = array(
    'tengfei_customtwo',
    'tengfei_banner',
    'tengfei_data',
    'tengfei_four_nav',
    'tengfei_lattice',
    'tengfei_lists',
    'tengfei_messcard',
    'tengfei_person',
    'tengfei_ranking',
    'tengfei_ranklists',
    'tengfei_sale',
    'tengfei_sidebar_stat',
    'tengfei_single',
    'tengfei_sjxjj',
    'tengfei_steer',
    'tengfei_tongji',
    'tengfei_tpwz',
    'tengfei_tran_stats',
    'tengfei_vips',
    'tengfei_vipstwo',
    'tengfei_wxfz',
    'tfbk_site_stats',
    'widgets-home-user',
    'widgets-renqizuoze',
    'wiiuii-comment-barrage',
    'xy_block',
    'zbfox_author_widget',
    'zbfox_calendar',
    'zbfox_festival',
    'zbfox_icon_card',
    'zbfox_quotations',
    'zbfox_time_progress',
    'zbfox-widgets',
    'tengfei_tougao',
    'tengfei_online_kefu',
    'tengfei_random_posts',
);
foreach ($widgets_files_list as $widgets_files_name) {
    require_once get_stylesheet_directory() . '/widgets/' . $widgets_files_name . '.php';
}
function zbfox_necessary()
{
    echo '<div class="c-yellow"><i class="fa fa-copyright"></i><b> &#x6B64;&#x5C0F;&#x5DE5;&#x5177;&#x7531;&#x3010;&#x72D0;&#x72F8;&#x5E93;&#x3011;&#x5F00;&#x53D1;&#xFF01;</b></div>';
    echo '<a href="h&#x74;&#x74;&#x70;&#x73;&#x3A;&#x2F;&#x2F;&#x68;&#x75;&#x6C;&#x69;&#x6B;&#x75;&#x2E;&#x63;&#x6F;&#x6D;">&#x5B98;&#x65B9;&#x7F51;&#x7AD9;</a> | <a href="h&#x74;&#x74;&#x70;&#x73;&#x3A;&#x2F;&#x2F;&#x68;&#x75;&#x6C;&#x69;&#x6B;&#x75;&#x2E;&#x63;&#x6F;&#x6D;&#x2F;&#x66;&#x6F;&#x72;&#x75;&#x6D;&#x2F;810&#x2E;&#x68;&#x74;&#x6D;&#x6C;">&#x95EE;&#x9898;&#x53CD;&#x9988;</a>';
}
