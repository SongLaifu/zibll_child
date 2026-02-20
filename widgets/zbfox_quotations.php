<?php
    // 注册小工具
    function register_zbfox_quotations_widget()
    {
        register_widget('QuotationsWidget');
    }
    add_action('widgets_init', 'register_zbfox_quotations_widget');

    class QuotationsWidget extends WP_Widget
    {

        public function __construct()
        {
            $widget = array(
                'w_id'        => 'zbfox_quotations_widget',
                'w_name'      => 'Zbfox 古诗一言',
                'classname'   => '',
                'description' => '显示日期+古诗一言（建议在侧边栏使用）',
            );
            parent::__construct($widget['w_id'], $widget['w_name'], $widget);
        }

        public function widget($args, $instance)
        {
            wp_enqueue_style('zbfox-quotations-style', get_stylesheet_directory_uri() . '/widgets/css/zbfox_quotations.css');
            wp_enqueue_script('zbfox-quotations-script', get_stylesheet_directory_uri() . '/widgets/js/zbfox_quotations.js');

            $poems = !empty($instance['poems']) ? explode("\n", $instance['poems']) : [
                '休对故人思故国，且将新火试新茶。诗酒趁年华。——宋苏轼《望江南》',
                '山中何事？松花酿酒，春水煎茶。——元张可久《人月圆》',
                // 你可以添加更多默认的古诗
            ];

            $bg_images = !empty($instance['bg_images']) ? explode("\n", $instance['bg_images']) : [
                get_stylesheet_directory_uri() . '/widgets/img/1.webp',
                get_stylesheet_directory_uri() . '/widgets/img/2.webp',
                get_stylesheet_directory_uri() . '/widgets/img/3.webp',
            ];

            wp_localize_script('zbfox-quotations-script', 'zbfoxQuotationsData', array(
                'poems' => $poems,
                'bg_images' => $bg_images,
            ));

            echo $before_widget;
?>
            <div class="wiiuii-suiji-main">
                <div class="wiiuii-suiji-header">
                    <div class="xingyu-dt-ty">
                        <span class="xingyu-dt-day wiiuiiDay"></span>
                        <p class="xingyu-sj-date">
                            <span class="wiiuiiYear"></span>
                            <span class="wiiuiiMonth"></span>
                        </p>
                    </div>
                    <div class="xingyu-sjzt-ty">
                        <span class="xingyu-yiyin"></span>
                    </div>
                </div>
                <div class="xingyu-sj-qhbtn">
                    <span id="xingyu-qh-btn">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i> 换一句</span>
                </div>
                <div class="xingyu-sjtitle-ty">
                    <span>—— 更多资源分享，敬请关注<?php echo get_bloginfo('name'); ?> ——</span>
                </div>
            </div>
        <?php
            echo $aefore_widget;
        }

        public function form($instance)
        {
            $poems = !empty($instance['poems']) ? $instance['poems'] : '';
            $bg_images = !empty($instance['bg_images']) ? $instance['bg_images'] : implode("\n", [
                get_stylesheet_directory_uri() . '/widgets/img/1.webp',
                get_stylesheet_directory_uri() . '/widgets/img/2.webp',
                get_stylesheet_directory_uri() . '/widgets/img/3.webp',
            ]);

        ?>
            <p>
                <label for="<?php echo $this->get_field_id('poems'); ?>">古诗文本（每行一首）:</label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('poems'); ?>" name="<?php echo $this->get_field_name('poems'); ?>"><?php echo esc_textarea($poems); ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('bg_images'); ?>">背景图片（每行一个）:</label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('bg_images'); ?>" name="<?php echo $this->get_field_name('bg_images'); ?>"><?php echo esc_textarea($bg_images); ?></textarea>
            </p>
<?php
            echo '<p>';
            echo zbfox_necessary();
            echo '</p>';
        }

        public function update($new_instance, $old_instance)
        {
            $instance = [];
            $instance['poems'] = (!empty($new_instance['poems'])) ? strip_tags($new_instance['poems']) : '';
            $instance['bg_images'] = (!empty($new_instance['bg_images'])) ? strip_tags($new_instance['bg_images']) : '';

            return $instance;
        }
    }
?>