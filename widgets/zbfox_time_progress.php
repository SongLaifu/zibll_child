<?php
    add_action('widgets_init', 'widget_time_progress');
    function widget_time_progress()
    {
        register_widget('widget_ui_time_progress');
    }

    class widget_ui_time_progress extends WP_Widget
    {
        public function __construct()
        {
            $widget = array(
                'w_id'        => 'widget_ui_time_progress',
                'w_name'      => 'Zbfox 时间胶囊',
                'classname'   => '',
                'description' => '显示时间胶囊，建议侧边栏显示。',
            );
            parent::__construct($widget['w_id'], $widget['w_name'], $widget);
        }

        public function widget($args, $instance)
        {
            echo $before_widget;

            wp_enqueue_style('zbfox-time-progress-style', get_stylesheet_directory_uri() . '/widgets/css/zbfox_time_progress.css', array(), '1.0.0');
            wp_enqueue_script('zbfox-time-progress-script', get_stylesheet_directory_uri() . '/widgets/js/zbfox_time_progress.js', array('jquery'), '1.0.0', true);

            $class = ($instance['hide_box'] !== 'on') ? ' theme-box' : '';
            $in_affix = $instance['in_affix'] ? ' data-affix="true"' : '';

            echo '<div class="zbfox-time-progress blue' . $class . '"' . $in_affix . '>';
            echo '<div class="progress-warp">';
            echo '<div class="progress-progress" id="progress-bar"></div>';
            echo '<div class="progress-text" id="progress-text">%</div>';
            echo '</div>';
            echo '<div class="progress-note">';
            echo '<div class="progress-time-title" id="progress-time-title">月</div>';
            echo '<div class="progress-time-sub-title" id="progress-time-sub-title">天</div>';
            echo '</div>';
            echo '</div>';

            echo $after_widget;
        }

        public function form($instance)
        {
            $defaults = array(
                'hide_box' => '',
                'in_affix' => '',
            );

            $instance = wp_parse_args((array) $instance, $defaults);

?>
            <p>
                <label>
                    <input type="checkbox" <?php checked($instance['hide_box'], 'on'); ?> id="<?php echo $this->get_field_id('hide_box'); ?>" name="<?php echo $this->get_field_name('hide_box'); ?>" />
                    不显示背景盒子
                </label>
            </p>
            <p>
                <label>
                    <input type="checkbox" <?php checked($instance['in_affix'], 'on'); ?> id="<?php echo $this->get_field_id('in_affix'); ?>" name="<?php echo $this->get_field_name('in_affix'); ?>" />
                    侧栏随动（仅在侧边栏有效）
                </label>
            </p>
<?php
            echo '<p>';
            echo zbfox_necessary();
            echo '</p>';
        }
    }
