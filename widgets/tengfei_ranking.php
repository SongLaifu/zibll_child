<?php
    add_action('widgets_init', 'widget_register_ranking');

    function widget_register_ranking()
    {
        register_widget('tengfei_widgets_ranking');
    }

    class tengfei_widgets_ranking extends WP_Widget
    {

        public function __construct()
        {
            parent::__construct(
                'tengfei_widgets_ranking',
                __('ZibTF 首页排行榜（旧版）', 'text_domain'),
                array('description' => __('首页显示可自定义的三个排行榜.', 'text_domain'))
            );
        }

        public function widget($args, $instance)
        {
            wp_enqueue_style('tengfei-ranking-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_ranking.css');

            echo '<div class="wapnone">';
            echo '<div id="syphb" class="container list clearfix">';

            for ($i = 1; $i <= 3; $i++) {
                $title = !empty($instance['title_' . $i]) ? $instance['title_' . $i] : '排行榜 ' . $i;
                $category = !empty($instance['category_' . $i]) ? $instance['category_' . $i] : '';
                $showposts = !empty($instance['showposts_' . $i]) ? $instance['showposts_' . $i] : 5;

                $this->render_ranking_item($title, $category, $i, $showposts);
            }

            echo '</div>';
            echo '</div>';
        }

        private function render_ranking_item($title, $category, $item_number, $showposts)
        {
            echo '<div class="ranking-item">';
            echo '<a class="top-icon js-rank-bottom' . $item_number . '">' . esc_html($title) . '</a>';
            echo '<div class="class-box">';

            $query_args = array(
                'cat' => $category,
                'posts_per_page' => $showposts,
                'orderby' => 'views',
                'no_found_rows' => true,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false
            );

            $query = new WP_Query($query_args);

            if ($query->have_posts()) {
                $phnum = 0;
                while ($query->have_posts()) {
                    $query->the_post();
                    $phnum++;
                    $this->render_post_item($phnum);
                }
                wp_reset_postdata();
            } else {
                echo '<p>No posts found</p>';
            }

            echo '</div>';
            echo '<a class="bottom-link js-rank-bottom" target="_blank" href="/tops" rel="noopener nofollow ugc">';
            echo '<span>查看完整榜单</span>';
            echo '<i class="imv2-chevrons-right"></i>';
            echo '</a>';
            echo '</div>';
        }

        private function render_post_item($phnum)
        {
            echo '<a class="class-item js-rank" href="' . esc_url(get_permalink()) . '" rel="external nofollow" target="_blank">';
            echo '<div class="num-icon num-icon' . $phnum . '"></div>';
            echo '<span class="syphimg">' . (function_exists('zib_post_thumbnail') ? zib_post_thumbnail() : '') . '</span>';
            echo '<div class="class-info">';
            echo '<div class="name">' . get_the_title() . '</div>';

            if (function_exists('get_post_view_count')) {
                echo '<span class="badg b-theme badg-sm" style="margin-left: 5px;">' . get_post_view_count('', '') . '热度值</span>';
            }
            if (function_exists('get_post_comment_count')) {
                echo '<span class="badg b-green badg-sm" style="margin-left: 5px;">' . get_post_comment_count('评论[', ']') . '</span>';
            }
            if (function_exists('get_post_favorite_count')) {
                echo '<span class="badg b-yellow badg-sm" style="margin-left: 5px;">' . get_post_favorite_count('收藏[', ']') . '</span>';
            }

            echo '</div>';
            echo '</a>';
        }

        public function form($instance)
        {
            for ($i = 1; $i <= 3; $i++) {
                $title = !empty($instance['title_' . $i]) ? $instance['title_' . $i] : '';
                $category = !empty($instance['category_' . $i]) ? $instance['category_' . $i] : '';
                $showposts = !empty($instance['showposts_' . $i]) ? $instance['showposts_' . $i] : 5;
?>
                <p>
                    <label for="<?php echo $this->get_field_id('title_' . $i); ?>"><?php echo '排行榜 ' . $i . ' 标题:'; ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('title_' . $i); ?>" name="<?php echo $this->get_field_name('title_' . $i); ?>" type="text" value="<?php echo esc_attr($title); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('category_' . $i); ?>"><?php echo '排行榜 ' . $i . ' 分类 ID:'; ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('category_' . $i); ?>" name="<?php echo $this->get_field_name('category_' . $i); ?>" type="number" value="<?php echo esc_attr($category); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('showposts_' . $i); ?>"><?php echo '排行榜 ' . $i . ' 显示文章数:'; ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('showposts_' . $i); ?>" name="<?php echo $this->get_field_name('showposts_' . $i); ?>" type="number" value="<?php echo esc_attr($showposts); ?>" min="1" max="20">
                </p>
<?php
            }
        }

        public function update($new_instance, $old_instance)
        {
            $instance = array();
            for ($i = 1; $i <= 3; $i++) {
                $instance['title_' . $i] = (!empty($new_instance['title_' . $i])) ? sanitize_text_field($new_instance['title_' . $i]) : '';
                $instance['category_' . $i] = (!empty($new_instance['category_' . $i])) ? absint($new_instance['category_' . $i]) : '';
                $instance['showposts_' . $i] = (!empty($new_instance['showposts_' . $i])) ? absint($new_instance['showposts_' . $i]) : 5;
            }
            return $instance;
        }
    }
