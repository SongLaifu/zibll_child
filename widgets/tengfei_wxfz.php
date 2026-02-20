<?php
    add_action('widgets_init', 'widget_custom_time_progress');
    function widget_custom_time_progress()
    {
        register_widget('wiget_wx_fz');
    }

    class wiget_wx_fz extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'wxgzh_widget',
                __('ZibTF 公众号翻转小工具', 'text_domain'),
                array('description' => __('公众号翻转小工具', 'text_domain'),)
            );
        }

        public function widget($args, $instance)
        {
            //获取主题目录中的CSS文件路径
            $css_url = get_stylesheet_directory_uri() . '/widgets/css/weixinhao.css';

            if (!empty($instance['hide_box'])) {
                $args['before_widget'] = '<div style="margin-bottom:20px;">';
                $args['after_widget'] = '</div>';
            }

            $url = !empty($instance['url']) ? esc_url($instance['url']) : get_stylesheet_directory_uri() . '/widgets/wechat.html'; // 默认链接地址

            echo $args['before_widget'];
?>
            <div class="card-widget" id="card-wechat" onclick="window.open('<?php echo $url; ?>');">
                <div id="flip-wrapper">
                    <div id="flip-content">
                        <div class="face"></div>
                        <div class="back face"></div>
                    </div>
                </div>
            </div>
        <?php
            // 动态加载CSS文件
            echo '<link rel="stylesheet" href="' . esc_url($css_url) . '" type="text/css">';
            echo $args['after_widget'];
        }

        public function form($instance)
        {
            $hide_box = !empty($instance['hide_box']) ? '1' : '0';
            $url = !empty($instance['url']) ? esc_url($instance['url']) : ''; // 设置链接地址的显示文字
        ?>
            <p>
                <input class="checkbox" type="checkbox" <?php checked($hide_box, '1'); ?> id="<?php echo $this->get_field_id('hide_box'); ?>" name="<?php echo $this->get_field_name('hide_box'); ?>" />
                <label for="<?php echo $this->get_field_id('hide_box'); ?>">隐藏背景盒子并保留空白边距</label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('url'); ?>">点击链接：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
            </p>
<?php
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['hide_box'] = !empty($new_instance['hide_box']) ? '1' : '0';
            $instance['url'] = (!empty($new_instance['url'])) ? strip_tags($new_instance['url']) : '';
            return $instance;
        }
    }
?>