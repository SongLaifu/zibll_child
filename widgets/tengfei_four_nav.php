<?php
    // 添加样式加载
    add_action('wp_enqueue_scripts', 'tengfei_widget_styles');
    function tengfei_widget_styles()
    {
        wp_enqueue_style('tengfei-ceshi-widget-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_four_nav.css', array(), '1.0.0');
    }

    add_action('widgets_init', 'widget_four_nav_sites');
    function widget_four_nav_sites()
    {
        register_widget('widget_four_nav');
    }

    class widget_four_nav extends WP_Widget
    {
        // 定义默认值
        private $defaults = array(
            'widget_title' => '近期热门网址',
            'default_title' => '腾飞博客',
            'default_link' => 'https://www.tfbkw.com',
            'default_icon' => 'https://www.tfbkw.com/favicon.ico',
            'default_desc' => '致力于分享优质实用的互联网资源'
        );

        function __construct()
        {
            parent::__construct(
                'widget_four_nav',
                __('ZibTF 四站导航小工具', 'zib'),
                array('description' => __('显示四个自定义导航站点', 'zib'),)
            );
        }

        public function widget($args, $instance)
        {
            extract($args);
            $before_widget = '<div style="margin-bottom:20px;">';
            $after_widget = '</div>';

            echo $before_widget;
?>
            <div class="card zeromo-item zeromo-list-item overflow-hidden">
                <div class="z-item-wrap">
                    <div class="z-item-site-wrap">
                        <h5 class="d-flex align-items-center z-item-site-title position-relative fw-semibold">
                            <?php echo !empty($instance['widget_title']) ? esc_html($instance['widget_title']) : $this->defaults['widget_title']; ?>
                        </h5>
                        <span class="z-item-site-before"></span>
                        <div class="z-item-site-content">
                            <?php for ($i = 1; $i <= 4; $i++) : ?>
                                <div class="z-item-site-list mb-3">
                                    <a href="<?php echo esc_url(!empty($instance['link_' . $i]) ? $instance['link_' . $i] : $this->defaults['default_link']); ?>"
                                        target="_blank"
                                        title="<?php echo esc_attr(!empty($instance['title_' . $i]) ? $instance['title_' . $i] : $this->defaults['default_title']); ?>">
                                        <div class="site-content d-flex align-items-center">
                                            <img src="<?php echo esc_url(!empty($instance['icon_' . $i]) ? $instance['icon_' . $i] : $this->defaults['default_icon']); ?>"
                                                alt="<?php echo esc_attr(!empty($instance['title_' . $i]) ? $instance['title_' . $i] : $this->defaults['default_title']); ?>"
                                                style="height:auto; width:auto;">
                                            <div class="site-content-meta">
                                                <h5 class="fw-semibold">
                                                    <?php echo esc_html(!empty($instance['title_' . $i]) ? $instance['title_' . $i] : $this->defaults['default_title']); ?>
                                                </h5>
                                                <span class="site-content-meta-intd">
                                                    <?php echo esc_html(!empty($instance['desc_' . $i]) ? $instance['desc_' . $i] : $this->defaults['default_desc']); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            echo $after_widget;
        }

        public function form($instance)
        {
            $widget_title = isset($instance['widget_title']) ? $instance['widget_title'] : $this->defaults['widget_title'];
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('widget_title'); ?>">小工具标题：</label>
                <input class="widefat" type="text"
                    id="<?php echo $this->get_field_id('widget_title'); ?>"
                    name="<?php echo $this->get_field_name('widget_title'); ?>"
                    value="<?php echo esc_attr($widget_title); ?>"
                    placeholder="<?php echo esc_attr($this->defaults['widget_title']); ?>">
            </p>
            <?php
            for ($i = 1; $i <= 4; $i++) {
                $title = isset($instance['title_' . $i]) ? $instance['title_' . $i] : '';
                $link = isset($instance['link_' . $i]) ? $instance['link_' . $i] : '';
                $icon = isset($instance['icon_' . $i]) ? $instance['icon_' . $i] : '';
                $desc = isset($instance['desc_' . $i]) ? $instance['desc_' . $i] : '';
            ?>
                <p><strong>站点 <?php echo $i; ?> 设置</strong></p>
                <p>
                    <label for="<?php echo $this->get_field_id('title_' . $i); ?>">标题：</label>
                    <input class="widefat" type="text"
                        id="<?php echo $this->get_field_id('title_' . $i); ?>"
                        name="<?php echo $this->get_field_name('title_' . $i); ?>"
                        value="<?php echo esc_attr($title); ?>"
                        placeholder="<?php echo esc_attr($this->defaults['default_title']); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('link_' . $i); ?>">链接：</label>
                    <input class="widefat" type="url"
                        id="<?php echo $this->get_field_id('link_' . $i); ?>"
                        name="<?php echo $this->get_field_name('link_' . $i); ?>"
                        value="<?php echo esc_attr($link); ?>"
                        placeholder="<?php echo esc_attr($this->defaults['default_link']); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('icon_' . $i); ?>">图标URL：</label>
                    <input class="widefat" type="url"
                        id="<?php echo $this->get_field_id('icon_' . $i); ?>"
                        name="<?php echo $this->get_field_name('icon_' . $i); ?>"
                        value="<?php echo esc_attr($icon); ?>"
                        placeholder="<?php echo esc_attr($this->defaults['default_icon']); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('desc_' . $i); ?>">描述：</label>
                    <textarea class="widefat"
                        id="<?php echo $this->get_field_id('desc_' . $i); ?>"
                        name="<?php echo $this->get_field_name('desc_' . $i); ?>"
                        placeholder="<?php echo esc_attr($this->defaults['default_desc']); ?>"><?php echo esc_textarea($desc); ?></textarea>
                </p>
                <hr>
<?php
            }
        }

        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['widget_title'] = (!empty($new_instance['widget_title'])) ? strip_tags($new_instance['widget_title']) : $this->defaults['widget_title'];

            for ($i = 1; $i <= 4; $i++) {
                $instance['title_' . $i] = (!empty($new_instance['title_' . $i])) ? strip_tags($new_instance['title_' . $i]) : '';
                $instance['link_' . $i] = (!empty($new_instance['link_' . $i])) ? esc_url_raw($new_instance['link_' . $i]) : '';
                $instance['icon_' . $i] = (!empty($new_instance['icon_' . $i])) ? esc_url_raw($new_instance['icon_' . $i]) : '';
                $instance['desc_' . $i] = (!empty($new_instance['desc_' . $i])) ? strip_tags($new_instance['desc_' . $i]) : '';
            }
            return $instance;
        }
    }
?>