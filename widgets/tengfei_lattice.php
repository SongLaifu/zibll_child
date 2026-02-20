<?php
    // 注册小工具
    add_action('widgets_init', 'register_tengfe_lattice_widget');

    function register_tengfe_lattice_widget()
    {
        register_widget('Tengfe_Lattice_Widget');
    }

    // 定义小工具类
    class Tengfe_Lattice_Widget extends WP_Widget
    {

        // 构造函数
        function __construct()
        {
            parent::__construct(
                'tengfe_lattice_widget', // 小工具 ID
                __('ZibTF 首页顶部六小格', 'text_domain'), // 小工具名称
                array('description' => __('首页顶部六小格样式美化', 'text_domain')) // 描述
            );
        }

        // 前端显示小工具内容
        public function widget($args, $instance)
        {
            extract($args);

            // 引入自定义 CSS
            wp_enqueue_style('tengfei-lattice-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_lattice.css', array(), '1.0.0');

            // 自动隐藏背景盒子
            $hide_box = '1'; // 自动隐藏背景

            // 输出小工具内容
?>
            <main role="main" class="container" style="width: 145%; background: none; padding: 0;">
                <div class="banxin Mrxu-block" style="background: none;">
                    <div class="Mrxu-circulation">
                        <ul>
                            <?php
                            // 设置六个大格的内容
                            for ($i = 1; $i <= 6; $i++) {
                                $color_class = "color" . $i; # 颜色类名
                                $icon_class = "icon" . $i; # 图标类名
                                $title = isset($instance['title' . $i]) ? $instance['title' . $i] : '腾飞博客'; # 标题
                                $subtitle = isset($instance['subtitle' . $i]) ? $instance['subtitle' . $i] : '腾飞博客'; # 副标题
                                $links = isset($instance['links' . $i]) ? $instance['links' . $i] : 'javascript:void(0)'; # 链接

                                // 解析链接和文字
                                $link_items = explode("\n", $links);
                                $link_items = array_map(function ($item) {
                                    $parts = explode('|', $item, 2);
                                    return count($parts) === 2 ? $parts : ['https://www.tfbkw.com', '腾飞博客'];
                                }, $link_items);

                                // 如果不到4个链接项，则补充默认链接
                                while (count($link_items) < 4) {
                                    $link_items[] = ['https://www.tfbkw.com', '腾飞博客'];
                                }
                            ?>
                                <li class="<?php echo $color_class; ?>" style="z-index: <?php echo ($i < 5) ? 10 : 1; ?>;">
                                    <div class="Mrxu-content">
                                        <a class="Mrxu-top" href="<?php echo esc_url($instance['link' . $i]); ?>">
                                            <p class="Mrxu-name"><?php echo esc_html($title); ?></p>
                                            <p class="Mrxu-hint"><?php echo esc_html($subtitle); ?></p>
                                            <i class="<?php echo $icon_class; ?>"></i>
                                        </a>
                                        <div class="Mrxu-link">
                                            <?php foreach ($link_items as $link_item) { ?>
                                                <a href="<?php echo esc_url($link_item[0]); ?>"><?php echo esc_html($link_item[1]); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </main>
            <?php
        }

        // 后台表单
        public function form($instance)
        {
            for ($i = 1; $i <= 6; $i++) {
            ?>
                <p>
                    <label for="<?php echo $this->get_field_id('title' . $i); ?>"><?php _e('标题 ' . $i . ':'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('title' . $i); ?>" name="<?php echo $this->get_field_name('title' . $i); ?>" type="text" value="<?php echo esc_attr(isset($instance['title' . $i]) ? $instance['title' . $i] : ''); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('subtitle' . $i); ?>"><?php _e('副标题 ' . $i . ':'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('subtitle' . $i); ?>" name="<?php echo $this->get_field_name('subtitle' . $i); ?>" type="text" value="<?php echo esc_attr(isset($instance['subtitle' . $i]) ? $instance['subtitle' . $i] : ''); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('link' . $i); ?>"><?php _e('主链接 ' . $i . ':'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('link' . $i); ?>" name="<?php echo $this->get_field_name('link' . $i); ?>" type="text" value="<?php echo esc_url(isset($instance['link' . $i]) ? $instance['link' . $i] : ''); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('links' . $i); ?>"><?php _e('四个小格链接 ' . $i . '（格式：链接|文本，每行一个）：'); ?></label>
                    <textarea class="widefat" id="<?php echo $this->get_field_id('links' . $i); ?>" name="<?php echo $this->get_field_name('links' . $i); ?>" rows="4"><?php echo esc_textarea(isset($instance['links' . $i]) ? $instance['links' . $i] : ''); ?></textarea>
                    <small><?php _e('输入格式：链接1|文本1' . "\n" . '链接2|文本2' . "\n" . '...'); ?></small>
                </p>
<?php
            }
        }

        // 更新设置
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            for ($i = 1; $i <= 6; $i++) {
                $instance['title' . $i] = (!empty($new_instance['title' . $i])) ? strip_tags($new_instance['title' . $i]) : '';
                $instance['subtitle' . $i] = (!empty($new_instance['subtitle' . $i])) ? strip_tags($new_instance['subtitle' . $i]) : '';
                $instance['link' . $i] = (!empty($new_instance['link' . $i])) ? esc_url_raw($new_instance['link' . $i]) : '';
                $instance['links' . $i] = (!empty($new_instance['links' . $i])) ? sanitize_textarea_field($new_instance['links' . $i]) : '';
            }
            return $instance;
        }
    }
?>