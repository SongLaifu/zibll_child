<?php
    // 注册自定义小工具
    add_action('widgets_init', 'register_custom_widget');
    function register_custom_widget()
    {
        wp_enqueue_style('zbfox_icon_card_styles', get_stylesheet_directory_uri() . '/widgets/css/zbfox_icon_card.css');
        register_widget('Zbfox_Custom_Icon_Links');
    }

    // 自定义图标小工具类
    class Zbfox_Custom_Icon_Links extends WP_Widget
    {
        public function __construct()
        {
            $widget = array(
                'w_id'        => 'zbfox_custom_icon_links',
                'w_name'      => 'Zbfox 横向图标卡片',
                'classname'   => '',
                'description' => '显示带链接的自定义图标。',
            );
            parent::__construct($widget['w_id'], $widget['w_name'], $widget);
        }

        public function widget($args, $instance)
        {
            echo $before_widget;
            // 小工具内容
?>
            <div class="huliku-flex">
                <div class="huliku-icon-card flex ac zib-widget">
                    <?php
                    for ($i = 1; $i <= 15; $i++) {
                        $url = !empty($instance['url_' . $i]) ? $instance['url_' . $i] : '';
                        $link = !empty($instance['link_' . $i]) ? $instance['link_' . $i] : '';

                        if (!empty($url) && !empty($link)) {
                    ?>
                            <a class="huliku-main" target="_blank" href="<?php echo esc_url($link); ?>">
                                <div class="huliku-cover-icon">
                                    <img src="<?php echo esc_url($url); ?>" alt="图标 <?php echo $i; ?>">
                                </div>
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <?php

            echo $after_widget;
        }

        public function form($instance)
        {
            // 小工具表单
            for ($i = 1; $i <= 15; $i++) {
                $url = !empty($instance['url_' . $i]) ? $instance['url_' . $i] : '';
                $link = !empty($instance['link_' . $i]) ? $instance['link_' . $i] : '';
            ?>
                <p>
                    <label for="<?php echo $this->get_field_id('url_' . $i); ?>">
                        <p style="color:red">图片<?php echo $i; ?>：</p>
                    </label>
                    <input class="widefat" id="<?php echo $this->get_field_id('url_' . $i); ?>" name="<?php echo $this->get_field_name('url_' . $i); ?>" type="text" value="<?php echo esc_attr($url); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('link_' . $i); ?>">跳转地址<?php echo $i; ?>：</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('link_' . $i); ?>" name="<?php echo $this->get_field_name('link_' . $i); ?>" type="text" value="<?php echo esc_attr($link); ?>">
                </p>
<?php
            }
            echo '<p>';
            echo zbfox_necessary();
            echo '</p>';
        }
    }
