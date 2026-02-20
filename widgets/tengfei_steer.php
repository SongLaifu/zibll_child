<?php
    add_action('widgets_init', 'widget_custom_steer');

    function widget_custom_steer()
    {
        register_widget('custom_widget_steer');
    }

    class custom_widget_steer extends WP_Widget
    {

        function __construct()
        {
            parent::__construct(
                'custom_widget_steer',
                __('ZibTF 侧边栏引导卡片', 'custom'),
                array('description' => __('子比主题文章侧边引导卡片美化', 'custom'))
            );
        }

        public function widget($args, $instance)
        {
            wp_enqueue_style('tengfei_menu_styles', get_stylesheet_directory_uri() . '/widgets/css/tengfei_steer.css');
            extract($args);
            $title = apply_filters('widget_title', $instance['title']);
            $subtitle = $instance['subtitle'];
            $image_url = $instance['image_url'];
            $icon_url = $instance['icon_url'];
            $ad_link = $instance['ad_link'];

            // 这里使用新提供的HTML结构和CSS类名，将变量嵌入其中，并按照规律展示多个.img元素
            echo '<div class="flex items-center justify-start">
    <div data-v-15ac1b16="" class="ad flex-1" style="max-width: 320px; --rgb: 241,144,144; --default: #8f2a2a; --control-color: #932b2b; --bg: rgba(241,144,144,1); --bgTrans: rgba(241,144,144,0); --textShadow: -1px -1px rgba(255,255,255,.8),
.1053em.1053em rgba(82,0,0,0.12),
.1842em.1842em.1316em rgba(82,0,0,0.12); --image-shadow: 0 1em 1em rgba(82,0,0,0.3);">
        <div data-v-15ac1b16="" class="bg-wrapper">';

            // 循环生成8列8行的.img元素
            for ($i = 0; $i < 8; $i++) {
                echo '<div data-v-15ac1b16="" class="strip">';
                for ($j = 0; $j < 8; $j++) {
                    echo '<div data-v-15ac1b16="" class="img"
                    style="background-image: url(' . $image_url . ');"></div>';
                }
                echo '</div>';
            }

            echo '</div>
        <div data-v-15ac1b16="" class="wrapper">
            <div data-v-15ac1b16="" class="icon flex items-center"><img data-v-15ac1b16=""
                    src="' . $icon_url . '" ></div>
            <div data-v-15ac1b16="" class="toolbar is-light">
                <div data-v-15ac1b16="" class="info">
                    <p data-v-15ac1b16="">' . $title . '</p>
                    <p data-v-15ac1b16=""><span data-v-15ac1b16="" class="tag font-slogan">广告</span> ' . $subtitle . '</p>
                </div>
                <div data-v-15ac1b16="" class="get-more">
                    <a href="' . $ad_link . '">查看</a>
                </div>
            </div>
        </div>
    </div>
</div>';
        }

        public function form($instance)
        {


            $title = !empty($instance['title']) ? $instance['title'] : __('默认标题', 'custom');
            $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : __('默认副标题', 'custom');
            $image_url = !empty($instance['image_url']) ? $instance['image_url'] : '';
            $icon_url = !empty($instance['icon_url']) ? $instance['icon_url'] : get_stylesheet_directory_uri() . '/widgets/img/O1CN016dmZq91QbIlEeEv5K_!!2210123621994.png';
            $ad_link = !empty($instance['ad_link']) ? $instance['ad_link'] : '';

?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('广告介绍:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php _e('图片链接:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('image_url'); ?>" name="<?php echo $this->get_field_name('image_url'); ?>" type="text" value="<?php echo esc_attr($image_url); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('icon_url'); ?>"><?php _e('图标链接:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('icon_url'); ?>" name="<?php echo $this->get_field_name('icon_url'); ?>" type="text" value="<?php echo esc_attr($icon_url); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('ad_link'); ?>"><?php _e('广告跳转链接:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('ad_link'); ?>" name="<?php echo $this->get_field_name('ad_link'); ?>" type="text" value="<?php echo esc_attr($ad_link); ?>">
            </p>
<?php
        }

        public function update($new_instance, $style = '')
        {
            $instance = array();
            $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
            $instance['subtitle'] = !empty($new_instance['subtitle']) ? strip_tags($new_instance['subtitle']) : '';
            $instance['image_url'] = !empty($new_instance['image_url']) ? strip_tags($new_instance['image_url']) : '';
            $instance['icon_url'] = !empty($new_instance['icon_url']) ? strip_tags($new_instance['icon_url']) : '';
            $instance['ad_link'] = !empty($new_instance['ad_link']) ? strip_tags($new_instance['ad_link']) : 'javascript:void(0)';

            return $instance;
        }
    }
?>