<?php
    add_action('widgets_init', 'widget_register_tj2');

    function widget_register_tj2()
    {
        register_widget('widget_ui_home_user_tjs');
    }

    class widget_ui_home_user_tjs extends WP_Widget
    {
        public function __construct()
        {
            $widget = array(
                'w_id'        => 'widget_ui_home_user_tjs',
                'w_name'      => __('ZibTF 底部统计小工具'),
                'classname'   => '',
            );
            parent::__construct($widget['w_id'], $widget['w_name'], $widget);
        }

        public function widget($args, $instance)
        {
            wp_enqueue_style('hfw-custom-widget-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_tongji_widget.css', array(), '1.0.0');

            wp_enqueue_style('hfw-custom-widget-style', get_stylesheet_directory_uri() . '/widgets/css/tj2.css', array(), '1.0.0');

            if (!zib_widget_is_show($instance)) {
                return;
            }

            extract($args);

            $title = $instance['title'];
            $custom_text = !empty($instance['custom_text']) ? $instance['custom_text'] : '今天是';

            if ($title) {
                $title = '<div class="box-body notop"><div class="title-theme">' . $title . '</div></div>';
            }

            echo '<div class="zib-widget widget_tj">';
            echo $title;
?>
            <script type="text/javascript">
                var stat_wzzs = "<?php echo wp_count_posts()->publish; ?>";
                var stat_bzfb = "<?php echo get_posts_count_from_last_168h('post'); ?>";
                var stat_yxsj = "<?php echo floor((time() - strtotime('2023-11-1 13:57:00')) / 86400); ?>";
                var stat_zcyh = "<?php global $wpdb;
                                    echo $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users"); ?>";
                var stat_zfwl = "<?php echo nd_get_all_views(); ?>";
            </script>
            <div class="textwidget custom-html-widget">
                <div id="mizhi-info-wg-mian">
                    <div class="mizhi-info-item">
                        <div class="mizhi-wz-item">
                            <div class="mizhi-wz-sty mizhi-wzzs-item">
                                <svg class="icon fa-2x" aria-hidden="true">
                                    <use xlink:href="#icon-wenzhang"></use>
                                </svg>
                                <span class="mizhi-i-num">
                                    <script type="text/javascript">
                                        document.write(stat_wzzs);
                                    </script>篇
                                </span>
                                <span class="frame-bg" title="文章数目">文章数目</span>
                            </div>
                            <div class="mizhi-wz-sty mizhi-jrfb-item">
                                <svg class="icon fa-2x" aria-hidden="true">
                                    <use xlink:href="#icon-benzhoudianjihou-copy"></use>
                                </svg>
                                <span class="mizhi-i-num">
                                    <script type="text/javascript">
                                        document.write(stat_bzfb);
                                    </script>篇
                                </span>
                                <span class="frame-bg" title="本周发布">本周发布</span>
                            </div>
                        </div>
                        <div class="mizhi-yhzs-item">
                            <svg class="icon fa-2x" aria-hidden="true">
                                <use xlink:href="#icon-yonghu"></use>
                            </svg>
                            <span class="mizhi-i-num">
                                <script type="text/javascript">
                                    document.write(stat_zcyh);
                                </script>位
                            </span>
                            <span class="frame-bg" title="注册用户">注册用户</span>
                        </div>
                        <div class="mizhi-yxsj-item">
                            <svg class="icon fa-2x" aria-hidden="true">
                                <use xlink:href="#icon-daojishi"></use>
                            </svg>
                            <span class="mizhi-i-num">
                                <script type="text/javascript">
                                    document.write(stat_yxsj);
                                </script>天
                            </span>
                            <span class="frame-bg" title="运行时间">运行时间</span>
                        </div>
                        <div class="mizhi-llzs-item">
                            <svg class="icon fa-2x" aria-hidden="true">
                                <use xlink:href="#icon-yanjing-"></use>
                            </svg>
                            <span class="mizhi-i-num">
                                <script type="text/javascript">
                                    document.write(stat_zfwl);
                                </script>次
                            </span>
                            <span class="frame-bg" title="浏览次数">浏览次数</span>
                        </div>
                        <div class="mizhi-sjcs-item">
                            <div class="mizhi-sjcj-m">
                                <span class="mizhi-i-num"><?php echo esc_html($custom_text); ?></span>
                                <div id="mizhi-date-text"></div>
                                <div id="mizhi-week-text"></div>
                                <div class="mizhi-meo-item">
                                    <img id="mizhi-meos">
                                </div>
                                <div class="mizhi-sjcj-content">
                                    <span id="mizhi-fatalism"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mizhi-sjcs-item2"><iframe src="<?php echo get_stylesheet_directory_uri() . "/widgets/week-1.html"; ?>" width="290" height="290" frameborder="no"></iframe></div>
                    </div>
                </div>
            </div>
            <style>
                .content-wrap {
                    margin: 0;
                    padding: 0;
                }
            </style>
            <script>
                $(function() {
                    var myDate = new Date();
                    var year = myDate.getFullYear();
                    var mon = myDate.getMonth() + 1;
                    var date = myDate.getDate();
                    var week = myDate.getDay();
                    var weeks = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
                    $("#mizhi-date-text").html(year + "年" + mon + "月" + date + "日 " + weeks[week]);

                    if (week > 0 && week < 5) {
                        $("#mizhi-fatalism").html("再坚持一下还有" + (5 - week) + "天就到周末啦！");
                    } else if (week === 5) {
                        $("#mizhi-fatalism").html("啊啊啊，明天就是周末啦！");
                    } else {
                        $("#mizhi-fatalism").html("今天是周末，好好放肆玩一下吧！");
                    }

                    var imgElement = document.getElementById('mizhi-meos');
                    var imgSrc = "<?php echo get_stylesheet_directory_uri() . "/widgets/img/week-" ?>" + week + ".webp";

                    var img = new Image();
                    img.src = imgSrc;
                    img.onload = function() {
                        imgElement.src = imgSrc;
                        imgElement.style.display = 'block';
                        imgElement.style.background = 'none'; // 移除占位符背景
                    };
                    img.onerror = function() {
                        console.error("Failed to load image: " + imgSrc);
                    };
                });

                $("#mizhi-info-wg-mian").parents(".zib-widget").css({
                    padding: "0",
                    background: "none"
                });
            </script>
            <script src="<?php echo get_stylesheet_directory_uri() . "/widgets/js/font_4345756_xl21sab9jum.js" ?>"></script>
        <?php
            echo '</div>';
        }

        public function form($instance)
        {
            $custom_text = !empty($instance['custom_text']) ? $instance['custom_text'] : '';
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('custom_text'); ?>">自定义文本:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('custom_text'); ?>" name="<?php echo $this->get_field_name('custom_text'); ?>" type="text" value="<?php echo esc_attr($custom_text); ?>">
            </p>
<?php
            echo zib_get_widget_show_type_input($instance, $this->get_field_name('show_type'));
        }

        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['custom_text'] = (!empty($new_instance['custom_text'])) ? strip_tags($new_instance['custom_text']) : '今天是';
            return $instance;
        }
    }

    // if (!function_exists('zib_widget_is_show')) {
    //     function zib_widget_is_show($instance)
    //     {
    //         return true; // 替换为实际的检查逻辑
    //     }
    // }

    // if (!function_exists('zib_get_widget_show_type_input')) {
    //     function zib_get_widget_show_type_input($instance, $field_name)
    //     {
    //         return '<input type="hidden" name="' . $field_name . '" value="1">'; // 替换为实际的实现
    //     }
    // }

    function nd_get_all_views()
    {
        global $wpdb;
        $count = 0;
        $views = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key='views'");
        foreach ($views as $key => $value) {
            $meta_value = $value->meta_value;
            if ($meta_value != ' ') {
                $count += (int)$meta_value;
            }
        }
        return $count;
    }



    /*
* @Project : 统计本周文章数量
* @Author : Huliku
* @Url : huliku.com
* @LastEditTime : 2023-06-26 02:23:48
* @Email : ihuliku@qq.com
*/
    function get_posts_count_from_last_168h($post_type = 'post')
    {
        global $wpdb;
        $numposts = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(ID) " .
                    "FROM {$wpdb->posts} " .
                    "WHERE " .
                    "post_status='publish' " .
                    "AND post_type= %s " .
                    "AND post_date> %s",
                $post_type,
                date('Y-m-d H:i:s', strtotime('-168 hours'))
            )
        );
        return $numposts;
    }



    /*
* @Project : 统计总访问量
* @Author : Huliku
* @Url : huliku.com
* @LastEditTime : 2023-06-26 02:23:48
* @Email : ihuliku@qq.com
*/
    function nd_get_all_view()
    {
        global $wpdb;
        $count = 0;
        $views = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key='views'");
        foreach ($views as $key => $value) {
            $meta_value = $value->meta_value;
            if ($meta_value != ' ') {
                $count += (int)$meta_value;
            }
        }
        return $count;
    }
