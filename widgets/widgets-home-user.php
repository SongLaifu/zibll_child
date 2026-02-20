<?php
    add_action('widgets_init', 'widget_register_home_authent_users');

    function widget_register_home_authent_users()
    {
        register_widget('widget_ui_authent_home_user_listsents');
    }

    class widget_ui_authent_home_user_listsents extends WP_Widget
    {
        public function __construct()
        {
            $widget = array(
                'w_id'        => 'widget_ui_authent_home_user_listsents',
                'w_name'      => __('ZYX 首页用户注册列表'),
                'classname'   => '',
                'description' => '首页显示网站新用户列表，以及会员列表',
            );
            parent::__construct($widget['w_id'], $widget['w_name'], $widget);
        }

        public function widget($args, $instance)
        {
            if (!zib_widget_is_show($instance)) {
                return;
            }

            extract($args);

            $defaults = array(
                'title'        => '',
                'mini_title'   => '',
                'more_but'     => '<i class="fa fa-angle-right fa-fw"></i>更多',
                'more_but_url' => '',
                'hide_box'     => false,
                'number'       => 8,
            );

            $instance = wp_parse_args((array) $instance, $defaults);
            $mini_title = $instance['mini_title'];

            if ($mini_title) {
                $mini_title = '<small class="ml10">' . $mini_title . '</small>';
            }

            $title = $instance['title'];
            $more_but = '';

            if ($instance['more_but'] && $instance['more_but_url']) {
                $more_but = '<div class="pull-right em09 mt3"><a href="' . $instance['more_but_url'] . '" class="muted-2-color">' . $instance['more_but'] . '</a></div>';
            }

            $mini_title .= $more_but;

            if ($title) {
                $title = '<div class="box-body notop"><div class="title-theme">' . $title . $mini_title . '</div></div>';
            }

            echo '<div class="theme-box">';
            echo $title;
            echo '
    <style>
    /**用户排行榜开始*/
            .hot-top .left {
                float: left;
            }
                
            .hot-top .right .top-ul li a h3 {
                white-space: nowrap;
            }

            .hot-top .right {
                float: right;
            }

            img {
                border: none;
            }

            .hot-top {
                width: 100%;
                background: var(--main-bg-color);
                margin-bottom: 25px;
                padding: 22px 20px;
                position: relative;
                height: 147px;
                overflow: hidden;
                border-radius: 10px 10px 10px 10px;
            }

            .hot-top .tg-ph {
                background-size: 100% 100%;
                position: absolute;
                right: 0;
                top: 0;
                z-index: 2;
                display: block;
                width: 60px;
                height: 60px;
            }

            .hot-top .left {
                height: 100%;
            }

            .hot-top .left a {
                display: block;
                width: 121px;
                height: 45px;
                line-height: 45px;
                background: #f6f6f6;
                text-align: center;
                font-size: 15px;
                color: #989898;
                margin-bottom: 13px;
                cursor: pointer;
                border-radius: 10px;
            }

            .hot-top .left a:last-child {
                margin-bottom: 0;
            }

            .hot-top .left .hover {
                background: #ff82c1;
                color: #FFF;
                position: relative;
            }

            .hot-top .left .hover:after {
                content: "";
                width: 0;
                height: 0;
                border-top: 7px solid transparent;
                border-bottom: 7px solid transparent;
                border-left: 10px solid #ff82c1;
                position: absolute;
                top: 15.5px;
                right: -10px;
                z-index: 1;
            }

            .hot-top .right-main {
                height: 100%;
                overflow-y: auto;
                margin-bottom: 30px;
            }

            .hot-top .right-main:last-child {
                margin-bottom: 0px;
            }

            .hot-top .right-overflow {
                transition: 0.4s all;
                transform: translateY(0);
            }

            .hot-top .right {
                float: left;
                width: calc( 100% - 147px);
                margin-left: 26px;
                height: 100%;
            }

            .hot-top .right .top-ul {
                height: 130px;
                overflow: hidden;
            }

            .hot-top .right .top-ul li {
                width: 78px;
                float: center;
                margin:0px 18px;
                display:inline-block;
            }

            .hot-top .right .top-ul li:nth-child(10n) {
                margin-right: 0;
            }

            .hot-top .right .top-ul li a {
                display: block;
            }

            .hot-top .right .top-ul li a .list-img {
                width: 100%;
                height: 78px;
                line-height: 78px;
                text-align: center;
                border-radius: 10px;
            }

            .hot-top .right .top-ul li a .list-img img {
                width: 100%;
            }

            .hot-top .right .top-ul li a .list-img img:hover {
                opacity: 0.8;
            }

            .hot-top .right .top-ul li a h3 {
                margin-top: 7px;
                font-size: 13px;
                line-height: 25px;
                height: 25px;
                overflow: hidden;
                width: 100%;
                text-align: center;
            }

            .new-position {
                height: 780px;
            }

            .new-position .left {
                height: 100%;
                width: calc( ( 100% - 13px ) * 0.36 );
            }

            .new-position .right {
                width: calc( ( 100% - 13px ) * 0.64 );
                height: 100%;
                background: #FFF;
                padding: 17px 28px;
            }

            .new-position .layui-carousel > [carousel-item] > * {
                background: #FFF;
            }

            .new-position #index-lb {
                height: 300px;
            }

            .new-position #index-lb div div img {
                width: 100%;
                min-height: 100%;
            }

            .new-position .index-login {
                background: #FFF;
                margin-top: 13px;
                height: calc( 767px - 300px);
                padding: 25px 33px;
                position: relative;
            }

            span.note {
                position: absolute;
                top: 10px;
                right: -50px;
                z-index: 1;
                width: 140px;
                height: 20px;
                background: #ff82c1;
                color: #fff;
                line-height: 20px;
                -webkit-transform: rotate(45deg);
                transform: rotate(45deg);
                text-align: center;
                font-size: 12px;
            }
img.rela {
    position: absolute;
    left: 52px;
    z-index: 2;
    /* right: 50px; */
    top: 58px;
    height: 25px;
    width: 25px;
}

  /*头像呼吸光环和鼠标悬停旋转放大开始*/
             img.yuan {  
    border-radius: 50%;  
    animation: light 4s ease-in-out infinite;  
    transition: 2s;  
}  
  
img.yuan:hover {  
    transform: scale(1) rotate(720deg);  
}

        /*头像呼吸光环和鼠标悬停旋转放大结束*/
            /**用户排行榜结束*/
            </style>
        <div class="hot-top layui-clear">
            <span class="note">用户排行榜</span>
            <i class="tg-ph"></i>
            <div class="left">
                <a class="hover" id="lively_online" onmouseenter=lively_online()>最新注册</a>
                <a class="" id="contribution" onmouseenter=contribution()>会员用户</a>
            </div>
            <div class="right">
                <div class="right-overflow" id="yhturns" style="transform: translateY(0px);">
                    <div class="right-main">
                        <ul class="layui-clear top-ul">';
            global $wpdb;
            $lzj1 = $wpdb->get_results("SELECT user_id FROM $wpdb->usermeta where meta_key='nickname' order by user_id desc limit 10");
            $string1 = '';
            foreach ($lzj1 as $result) {
                $args = $result->user_id;
                $string1 .= $args . ',';
            }

            $user_query = new WP_User_Query(array('include' => ($string1)));

            if (!empty($user_query->results)) {
                foreach ($user_query->results as $user) {
                    $avatar_img = zib_get_data_avatar($user->ID);
                    $user_home_url = zib_get_user_home_url($user->ID);

                    $helf = zib_get_user_home_url($user->ID);
                    $html = '';
                    $html .= '<a href="' . $helf . '">' . $html . '</a>';
                    echo '<li><div class="user-avatar">
        
        <a href="' . zib_get_user_home_url($user->id) . '">  
        
        
        
        <span class="avatar-img avatar-lg">' . $avatar_img .  '</a><a href="' . zib_get_user_home_url($user->ID) . '"><h3>' . $user->display_name . ' </h3></a></span></div></li>';
                }
            } else {
                echo '没有用户';
            }
?>
            </ul>
            </div>
            <div class="right-main">
                <ul class="layui-clear top-ul">
                    <?php
                    global $wpdb;
                    $lzj2 = $wpdb->get_results("SELECT user_id FROM $wpdb->usermeta where meta_key='vip_level' and meta_value='1' or meta_key='vip_level'  and meta_value='2' order by user_id desc limit 8");
                    $string2 = '';
                    foreach ($lzj2 as $result) {
                        $args = $result->user_id;
                        $string2 .= $args . ',';
                    }

                    $user_query = new WP_User_Query(array('include' => ($string2)));

                    if (!empty($user_query->results)) {
                        foreach ($user_query->results as $user) {
                            $avatar_img = zib_get_data_avatar($user->ID);
                            $vip_icon   = '';
                            $vip_icon = zib_get_avatar_badge($user->ID);
                            $helf = zib_get_user_home_url($user->ID);
                            $html = '<a href="' . $helf . '">' . $html . '</a>';
                            echo '<li><div class="user-avatar"><span class="avatar-img avatar-lg">' . $avatar_img . $vip_icon . '<a href="' . zib_get_user_home_url($user->ID) . '"><h3>' . $user->display_name . ' </h3></a></span></div></li>';
                        }
                    } else {
                        echo '没有用户';
                    }
                    ?>
                </ul>
            </div>
            </div>
            </div>
            </div>
            <script type="text/javascript">
                function lively_online() {
                    document.getElementById('lively_online').className = 'hover';
                    document.getElementById('contribution').className = ' ';
                    document.getElementById('yhturns').style = 'transform: translateY(0px);';
                }

                function contribution() {
                    document.getElementById('lively_online').className = ' ';
                    document.getElementById('contribution').className = 'hover';
                    document.getElementById('yhturns').style = 'transform: translateY(-160px);';
                }
            </script>
        <?php
            echo '</div>';
        }

        public function form($instance)
        {
            $defaults = array(
                'title'        => '',
                'mini_title'   => '',
                'more_but'     => '<i class="fa fa-angle-right fa-fw"></i>更多',
                'more_but_url' => '',
                'number'       => 8,
                'hide_box'     => '',
            );

            $instance = wp_parse_args((array) $instance, $defaults);

            $page_input[] = array(
                'name'  => __('标题：', 'zib_language'),
                'id'    => $this->get_field_name('title'),
                'std'   => $instance['title'],
                'style' => 'margin: 10px auto;',
                'type'  => 'text',
            );
            $page_input[] = array(
                'name'  => __('副标题：', 'zib_language'),
                'id'    => $this->get_field_name('mini_title'),
                'std'   => $instance['mini_title'],
                'style' => 'margin: 10px auto;',
                'type'  => 'text',
            );
            $page_input[] = array(
                'name'  => __('标题右侧按钮->文案：', 'zib_language'),
                'id'    => $this->get_field_name('more_but'),
                'std'   => $instance['more_but'],
                'style' => 'margin: 10px auto;',
                'type'  => 'text',
            );
            $page_input[] = array(
                'name'  => __('标题右侧按钮->链接：', 'zib_language'),
                'id'    => $this->get_field_name('more_but_url'),
                'std'   => $instance['more_but_url'],
                'desc'  => '设置为任意链接',
                'style' => 'margin: 10px auto;',
                'type'  => 'text',
            );
            $page_input[] = array(
                //    'name'  => __('显示背景盒子', 'zib_language'),
                'id'    => $this->get_field_name('hide_box'),
                'std'   => $instance['hide_box'],
                'desc'  => '不显示背景盒子',
                'style' => 'margin: 10px auto;',
                'type'  => 'checkbox',
            );

            echo zib_get_widget_show_type_input($instance, $this->get_field_name('show_type'));

            echo zib_edit_input_construct($page_input);
        ?>

<?php
        }
    }
