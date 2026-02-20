<?php
    add_action('widgets_init', 'register_zbfox_author_widget');
    function register_zbfox_author_widget()
    {
        register_widget('Zbfox_Author_Widget');
    }

    class Zbfox_Author_Widget extends WP_Widget
    {

        public function __construct()
        {
            parent::__construct(
                'zbfox_author_widget',
                'Zbfox 创作者计划',
                array('description' => '用于鼓励创作者的激励计划小工具')
            );
        }

        public function widget($args, $instance)
        {
            $link = !empty($instance['link']) ? $instance['link'] : huliku_get_domain();
            $conversion_rate = !empty($instance['conversion_rate']) ? $instance['conversion_rate'] : 50;
            $custom_link = !empty($instance['custom_link']) ? $instance['custom_link'] : huliku_get_domain() . 'newposts/';
            $additional_content = !empty($instance['additional_content']) ? $instance['additional_content'] : '本站开放社区创作者计划泛指通过发布文章、社区帖子和社区提问解惑，以及提供优质评论，为创作者提供收益机会，同时创作者也可与其他用户建立交流和互动.';

            $allusers = get_users(['has_published_posts' => ['post']]);
            $authors_count = count($allusers);

            extract($args);
            echo $before_widget;
            wp_enqueue_style('zbfox-author-widget-style', get_stylesheet_directory_uri() . '/widgets/css/zbfox_author_widget.css', array(), '1.0.0');
?>
            <div class="huliku-author">
                <span></span>
                <div class="huliku-author-content">
                    <h3 class="huliku-fw-semibold">
                        <i class="ti ti-brand-powershell"></i>创作者激励计划
                    </h3>
                    <span class="huliku-content-int"><?php echo $additional_content; ?>
                        <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener">规则详情</a>
                    </span>
                    <div class="huliku-justify-content-between" style="display: flex;">
                        <div>
                            <span style="font-size: 30px;color: var(--theme-color);font-weight: 600; margin-right: 2px;"><?php echo $authors_count; ?></span>位
                            <p>创作者加入</p>
                        </div>
                        <div>
                            <span style="font-size: 30px;color: var(--theme-color);font-weight: 600;margin-right: 2px;"><?php echo number_format(calculate_total_points() / $conversion_rate, 2); ?></span>元
                            <p>累计发放收益</p>
                        </div>
                    </div>
                    <div class="huliku-zeromo-joinbtn">
                        <a href="<?php echo esc_url($custom_link); ?>" class="huliku-author-join btn" target="_blank" rel="noopener">立即加入</a>
                        <a href="<?php echo esc_url($link); ?>" class="huliku-author-more btn" target="_blank" rel="noopener">规则详情</a>
                    </div>
                </div>
            </div>
        <?php
            echo $after_widget;
        }

        public function form($instance)
        {
            $link = !empty($instance['link']) ? $instance['link'] : huliku_get_domain();
            $conversion_rate = !empty($instance['conversion_rate']) ? $instance['conversion_rate'] : 50;
            $custom_link = !empty($instance['custom_link']) ? $instance['custom_link'] : huliku_get_domain() . 'newposts/';
            $additional_content = !empty($instance['additional_content']) ? $instance['additional_content'] : '本站开放社区创作者计划泛指通过发布文章、社区帖子和社区提问解惑，以及提供优质评论，为创作者提供收益机会，同时创作者也可与其他用户建立交流和互动.';

        ?>
            <p>
                <label for="<?php echo $this->get_field_id('additional_content'); ?>">内容设置：</label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('additional_content'); ?>" name="<?php echo $this->get_field_name('additional_content'); ?>"><?php echo esc_textarea($additional_content); ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('link'); ?>">规则详情链接：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('conversion_rate'); ?>">积分比例 (1元 = N积分)：<br>默认1元=50积分</label>
                <input class="widefat" id="<?php echo $this->get_field_id('conversion_rate'); ?>" name="<?php echo $this->get_field_name('conversion_rate'); ?>" type="text" value="<?php echo esc_attr($conversion_rate); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('custom_link'); ?>">点击加入链接：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('custom_link'); ?>" name="<?php echo $this->get_field_name('custom_link'); ?>" type="text" value="<?php echo esc_attr($custom_link); ?>">
            </p>
<?php
            echo '<p>';
            echo zbfox_necessary();
            echo '</p>';
        }

        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['link'] = !empty($new_instance['link']) ? strip_tags($new_instance['link']) : huliku_get_domain();
            $instance['conversion_rate'] = !empty($new_instance['conversion_rate']) ? strip_tags($new_instance['conversion_rate']) : 50;
            $instance['custom_link'] = !empty($new_instance['custom_link']) ? strip_tags($new_instance['custom_link']) : huliku_get_domain() . 'newposts/';
            $instance['additional_content'] = !empty($new_instance['additional_content']) ? sanitize_text_field($new_instance['additional_content']) : '';

            return $instance;
        }
    }

    function calculate_total_points()
    {
        global $wpdb;
        $total_points = $wpdb->get_var("SELECT SUM(meta_value) FROM $wpdb->usermeta WHERE meta_key = 'points'");

        return $total_points;
    }

    function huliku_get_domain()
    {
        return 'javascript:void(0)';
    }

