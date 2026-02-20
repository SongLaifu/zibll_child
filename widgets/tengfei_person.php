<?php
// 注册小工具
add_action('widgets_init', 'tengfei_person_widget');
function tengfei_person_widget()
{
    register_widget('tengfei_person');
}

class tengfei_person extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'tengfei_person',
            __('ZibTF 个人信息展示小工具', 'text_domain'),
            array('description' => __('展示个人信息、文章统计及社交链接等', 'text_domain'))
        );
    }

    public function widget($args, $instance)
    {
        // 引入外部 CSS 文件
        wp_enqueue_style('tengfei-person-widget-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_person.css', array(), '1.0.0');

        // 从数据库中获取小工具设置的值
        $qq_number = !empty($instance['qq_number']) ? esc_attr($instance['qq_number']) : '2296945504';
        $author_name = !empty($instance['author_name']) ? esc_html($instance['author_name']) : '腾飞博客';
        $author_description = !empty($instance['author_description']) ? esc_html($instance['author_description']) : '"想做一件任何人都可以做的事情"';
        $github_link = !empty($instance['github_link']) ? esc_url($instance['github_link']) : 'https://github.com/ciui25';
        $gitee_link = !empty($instance['gitee_link']) ? esc_url($instance['gitee_link']) : 'https://gitee.com/ciui25';
        $bilibili_link = !empty($instance['bilibili_link']) ? esc_url($instance['bilibili_link']) : 'https://space.bilibili.com/1561621867';
        $wangyi_link = !empty($instance['wangyi_link']) ? esc_url($instance['wangyi_link']) : 'https://music.163.com/#/user/home?id=3401360482';
        $about_link = !empty($instance['about_link']) ? esc_url($instance['about_link']) : 'http://me.wniui.com';

        // 生成 QQ 头像的 URL
        $avatar_url = '';
        if ($qq_number) {
            $avatar_url = 'https://q1.qlogo.cn/g?b=qq&nk=' . $qq_number . '&s=640';
        }

        // 自动隐藏背景盒子并保留空白边距
        $args['before_widget'] = '<div style="margin-bottom:20px;">';
        $args['after_widget'] = '</div>';

        echo $args['before_widget'];
?>

        <script type="text/javascript">
            <?php
            // 获取文章数量
            $count_posts = wp_count_posts();
            $published_posts = $count_posts->publish;
            echo "var tj_rzzs = '$published_posts';";
            ?>
        </script>

        <script type="text/javascript">
            <?php
            // 获取标签数量
            $tag_count = wp_count_terms('post_tag');
            echo "var tj_tags = '$tag_count';";
            ?>
        </script>

        <script type="text/javascript">
            <?php
            // 获取分类数量
            $category_count = wp_count_terms('category');
            echo "var tj_categories = '$category_count';";
            ?>
        </script>

        <div class="wniui-card-info">
            <div class="wniui-is-center">
                <div class="wniui-avatar-img">
                    <img src="<?php echo $avatar_url; ?>" alt="avatar">
                </div>
                <div class="wniui-author-info__name"><?php echo $author_name; ?></div>
                <div class="wniui-author-info__description"><?php echo $author_description; ?></div>
            </div>
            <div class="wniui-card-info-data">
                <div class="wniui-card-info-data-item"><a href="#" data-pjax-state="">
                        <div class="wniui-headline">文章</div>
                        <div class="wniui-length-num"><span id="post-count">加载中...</span></div>
                    </a></div>
                <div class="wniui-card-info-data-item"><a href="#" data-pjax-state="">
                        <div class="wniui-headline">分类</div>
                        <div class="wniui-length-num"><span id="category-count">加载中...</span></div>
                    </a></div>
                <div class="wniui-card-info-data-item"><a href="#" data-pjax-state="">
                        <div class="wniui-headline">标签</div>
                        <div class="wniui-length-num"><span id="tag-count">加载中...</span></div>
                    </a></div>
            </div>
            <a id="wniui-card-info-btn" target="_blank" rel="noopener" href="<?php echo $about_link; ?>"><span>Follow
                    Me</span></a>


            <div class="wniui-card-info-social-icons">
                <a class="wniui-social-icon" href="<?php echo $github_link; ?>" target="_blank" title="github"><i
                        class="icon-github"></i></a>
                <a class="wniui-social-icon" href="<?php echo $gitee_link; ?>" target="_blank" title="Gitee"><i
                        class="icon-gitee"></i></a>
                <a class="wniui-social-icon" href="<?php echo $bilibili_link; ?>" target="_blank"
                    title="bilibili"><i class="icon-bilibili"></i></a>
                <a class="wniui-social-icon" href="<?php echo $wangyi_link; ?>" target="_blank"
                    title="网易云"><i class="icon-wangyi"></i></a>
                <a class="wniui-social-icon" href="<?php echo $about_link; ?>" target="_blank" title="关于我"><i
                        class="icon-about"></i></a>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof tj_rzzs !== 'undefined' && typeof tj_tags !== 'undefined' && typeof tj_categories !== 'undefined') {
                    document.getElementById('post-count').textContent = tj_rzzs;
                    document.getElementById('tag-count').textContent = tj_tags;
                    document.getElementById('category-count').textContent = tj_categories;
                } else {
                    console.error('统计数据未加载');
                }
            });
        </script>
    <?php
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $qq_number = !empty($instance['qq_number']) ? esc_attr($instance['qq_number']) : '12345678';
        $author_name = !empty($instance['author_name']) ? esc_attr($instance['author_name']) : '腾飞博客';
        $author_description = !empty($instance['author_description']) ? esc_attr($instance['author_description']) : '"想做一件任何人都可以做的事情"';
        $github_link = !empty($instance['github_link']) ? esc_attr($instance['github_link']) : 'https://github.com/ciui25';
        $gitee_link = !empty($instance['gitee_link']) ? esc_attr($instance['gitee_link']) : 'https://gitee.com/ciui25';
        $bilibili_link = !empty($instance['bilibili_link']) ? esc_attr($instance['bilibili_link']) : 'https://space.bilibili.com/1561621867';
        $wangyi_link = !empty($instance['wangyi_link']) ? esc_attr($instance['wangyi_link']) : 'https://music.163.com/#/user/home?id=3401360482';
        $about_link = !empty($instance['about_link']) ? esc_attr($instance['about_link']) : 'http://me.wniui.com';
    ?>
        <p>
            <label for="<?php echo $this->get_field_id('qq_number'); ?>">QQ 号:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('qq_number'); ?>" name="<?php echo $this->get_field_name('qq_number'); ?>" type="text" value="<?php echo $qq_number; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('author_name'); ?>">作者名字:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('author_name'); ?>" name="<?php echo $this->get_field_name('author_name'); ?>" type="text" value="<?php echo $author_name; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('author_description'); ?>">作者介绍:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('author_description'); ?>" name="<?php echo $this->get_field_name('author_description'); ?>" type="text" value="<?php echo $author_description; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('github_link'); ?>">GitHub 链接:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('github_link'); ?>" name="<?php echo $this->get_field_name('github_link'); ?>" type="text" value="<?php echo $github_link; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('gitee_link'); ?>">Gitee 链接:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('gitee_link'); ?>" name="<?php echo $this->get_field_name('gitee_link'); ?>" type="text" value="<?php echo $gitee_link; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('bilibili_link'); ?>">哔哩哔哩链接:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('bilibili_link'); ?>" name="<?php echo $this->get_field_name('bilibili_link'); ?>" type="text" value="<?php echo $bilibili_link; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('wangyi_link'); ?>">网易云链接:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('wangyi_link'); ?>" name="<?php echo $this->get_field_name('wangyi_link'); ?>" type="text" value="<?php echo $wangyi_link; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('about_link'); ?>">关于我链接:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('about_link'); ?>" name="<?php echo $this->get_field_name('about_link'); ?>" type="text" value="<?php echo $about_link; ?>">
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['qq_number'] = (!empty($new_instance['qq_number'])) ? strip_tags($new_instance['qq_number']) : '12345678';
        $instance['author_name'] = (!empty($new_instance['author_name'])) ? strip_tags($new_instance['author_name']) : '腾飞博客';
        $instance['author_description'] = (!empty($new_instance['author_description'])) ? strip_tags($new_instance['author_description']) : '"想做一件任何人都可以做的事情"';
        $instance['github_link'] = (!empty($new_instance['github_link'])) ? strip_tags($new_instance['github_link']) : 'https://github.com/xxxxxxxx';
        $instance['gitee_link'] = (!empty($new_instance['gitee_link'])) ? strip_tags($new_instance['gitee_link']) : 'https://gitee.com/xxxxxxxx';
        $instance['bilibili_link'] = (!empty($new_instance['bilibili_link'])) ? strip_tags($new_instance['bilibili_link']) : 'https://space.bilibili.com/xxxxxxxx';
        $instance['wangyi_link'] = (!empty($new_instance['wangyi_link'])) ? strip_tags($new_instance['wangyi_link']) : 'https://music.163.com/xxxxxxxx';
        $instance['about_link'] = (!empty($new_instance['about_link'])) ? strip_tags($new_instance['about_link']) : 'https://tfbkw.com';
        return $instance;
    }
}
