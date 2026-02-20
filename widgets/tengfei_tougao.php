<?php
    // 引入CSS
    wp_enqueue_style('tengfei-tougao-widget', get_stylesheet_directory_uri() . '/widgets/css/tengfei_tougao.css', array(), '1.0.0');

    // 注册小工具
    add_action('widgets_init', function () {
        register_widget('tengfei_tougao_widget');
    });

    class tengfei_tougao_widget extends WP_Widget
    {

        function __construct()
        {
            parent::__construct(
                'tengfei_tougao_widget',
                __('ZibTF-投稿交流小工具', 'tengfei'),
                array('description' => __('首页侧边栏-投稿交流小工具', 'tengfei'))
            );
        }

        // 前台展示
        public function widget($args, $instance)
        {
            $title = !empty($instance['title']) ? $instance['title'] : '腾飞博客';
            $post_url = !empty($instance['post_url']) ? $instance['post_url'] : '/newposts';
            $qq_url = !empty($instance['qq_url']) ? $instance['qq_url'] : '';

            echo $args['before_widget'];
?>
            <div class="tengfei-tougao-widget" style="background-color: var(--main-bg-color);border-radius: 8px;">
                <div class="index-news-tool-container" style="padding-top: 22px;">
                    <a href="<?php echo esc_url($post_url); ?>" class="noad" target="_blank">我要投稿</a>
                    <a href="<?php echo esc_url($qq_url); ?>" target="_blank" class="mytg">加入QQ群</a>
                    <fieldset>
                        <legend><?php echo esc_html($title); ?></legend>
                    </fieldset>
                    <ul class="tequan" style="padding-bottom: 22px;">
                        <li class="clearfix" style="margin-top: 0px;">
                            <div>
                                <i style="background-position: center -389px;"></i>
                                <span>按时更新</span>
                            </div>
                            <div class="liright">
                                <i style="background-position: center -360px;"></i>
                                <span>资源丰富</span>
                            </div>
                        </li>
                        <li class="clearfix">
                            <div>
                                <i style="background-position: center -101px;"></i>
                                <span>纯净无广</span>
                            </div>
                            <div class="liright">
                                <i style="background-position: center -263px;"></i>
                                <span>精选资源</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        <?php
            echo $args['after_widget'];
        }

        // 后台表单
        public function form($instance)
        {
            $title = !empty($instance['title']) ? $instance['title'] : '腾飞博客';
            $post_url = !empty($instance['post_url']) ? $instance['post_url'] : '/newposts';
            $qq_url = !empty($instance['qq_url']) ? $instance['qq_url'] : '';
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">标题：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('post_url'); ?>">投稿链接：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('post_url'); ?>" name="<?php echo $this->get_field_name('post_url'); ?>" type="text" value="<?php echo esc_attr($post_url); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('qq_url'); ?>">QQ群链接：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('qq_url'); ?>" name="<?php echo $this->get_field_name('qq_url'); ?>" type="text" value="<?php echo esc_attr($qq_url); ?>">
            </p>
<?php
        }

        // 保存设置
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
            $instance['post_url'] = !empty($new_instance['post_url']) ? esc_url_raw($new_instance['post_url']) : '';
            $instance['qq_url'] = !empty($new_instance['qq_url']) ? esc_url_raw($new_instance['qq_url']) : '';
            return $instance;
        }
    }
?>