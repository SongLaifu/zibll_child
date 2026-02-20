<?php
    add_action('widgets_init', 'hfw_register_custom_posts_widget');
    function hfw_register_custom_posts_widget()
    {
        register_widget('HFW_Custom_Widget_Posts');
    }

    class HFW_Custom_Widget_Posts extends WP_Widget
    {
        public function __construct()
        {
            $widget = array(
                'w_id'        => 'hfw_custom_widget_posts',
                'w_name'      => __('ZibTF 图片文章列表', 'text_domain'),
                'classname'   => '',
                'description' => '显示特定分类目录下的文章，并带有缩略图功能',
            );
            parent::__construct($widget['w_id'], $widget['w_name'], $widget);
        }

        public function widget($args, $instance)
        {

            wp_enqueue_style('hfw-custom-widget-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_custom_widget.css');

            $before_widget = '<div class="hfw-custom-widget">';
            $after_widget = '</div>';
            $before_title = '<div class="hfw-widget-title-wrapper"><h2 class="widget-title">';
            $after_title = '</h2>';

            $title = apply_filters('widget_title', $instance['title']);
            $limit = !empty($instance['limit']) ? absint($instance['limit']) : 10;
            $cat = !empty($instance['cat']) ? $instance['cat'] : '';
            $orderby = !empty($instance['orderby']) ? $instance['orderby'] : 'date';

            echo $before_widget;
            if (!empty($title)) {
                echo $before_title . $title . $after_title;
                if (!empty($cat)) {
                    echo '<a href="' . get_category_link($cat) . '" class="hfw-more-link but jb-blue radius" target="_blank">更多 <i class="fa fa-angle-right em12"></i></a>';
                }
                echo '</div>';
            }

            $query_args = array(
                'post_status'         => 'publish',
                'cat'                 => $cat,
                'orderby'             => $orderby,
                'order'               => 'DESC',
                'posts_per_page'      => $limit,
                'ignore_sticky_posts' => 1,
            );

            $the_query = new WP_Query($query_args);
            echo '<div class="hfw-posts-row">';
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $views = $this->format_views(get_post_meta(get_the_ID(), 'views', true));
                $images = $this->get_image_count();
                echo '<div class="hfw-post-list-item">';
                echo '<div class="hfw-item-in">';
                echo '<div class="hfw-post-module-thumb">';
                echo '<a class="hfw-thumb-link" href="' . get_permalink() . '" target="_blank" rel="nofollow noopener">';
                echo $this->get_post_thumbnail();
                echo '</a>';
                echo '<div class="hfw-post-meta">';
                echo '<div class="hfw-post-views"><i class="fa fa-eye"></i> ' . $views . '</div>';
                echo '<div class="hfw-post-images"><i class="fa fa-picture-o"></i> ' . $images . '</div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="hfw-post-info">';
                echo '<h2><a href="' . get_permalink() . '" target="_blank" rel="noopener">' . get_the_title() . '</a></h2>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            wp_reset_postdata();
            echo '</div>';
            echo $after_widget;
        }

        // 引入外部CSS文件


        public function form($instance)
        {
            $title = !empty($instance['title']) ? $instance['title'] : '';
            $limit = !empty($instance['limit']) ? $instance['limit'] : 10;
            $cat = !empty($instance['cat']) ? $instance['cat'] : '';
            $orderby = !empty($instance['orderby']) ? $instance['orderby'] : 'date';

?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('分类目录ID:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="text" value="<?php echo esc_attr($cat); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('排序方式:'); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                    <option value="date" <?php selected($orderby, 'date'); ?>><?php _e('发布时间'); ?></option>
                    <option value="comment_count" <?php selected($orderby, 'comment_count'); ?>><?php _e('评论数'); ?></option>
                    <option value="views" <?php selected($orderby, 'views'); ?>><?php _e('浏览量'); ?></option>
                    <option value="like" <?php selected($orderby, 'like'); ?>><?php _e('点赞数'); ?></option>
                    <option value="favorite" <?php selected($orderby, 'favorite'); ?>><?php _e('收藏数'); ?></option>
                    <option value="modified" <?php selected($orderby, 'modified'); ?>><?php _e('更新时间'); ?></option>
                    <option value="rand" <?php selected($orderby, 'rand'); ?>><?php _e('随机排序'); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('显示文章数量:'); ?></label>
                <input class="tiny-text" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($limit); ?>" size="3">
            </p>
<?php
        }



        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            $instance['cat'] = (!empty($new_instance['cat'])) ? strip_tags($new_instance['cat']) : '';
            $instance['orderby'] = (!empty($new_instance['orderby'])) ? strip_tags($new_instance['orderby']) : 'date';
            $instance['limit'] = (!empty($new_instance['limit'])) ? absint($new_instance['limit']) : 10;

            return $instance;
        }


        private function get_first_image()
        {
            global $post;
            $first_img = '';
            ob_start();
            ob_end_clean();
            $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
            if (isset($matches[1][0])) {
                $first_img = $matches[1][0];
            }
            return $first_img;
        }

        private function get_image_count()
        {
            global $post;
            $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
            $count = isset($matches[1]) ? count($matches[1]) : 0;

            $content = do_shortcode($post->post_content);
            $output = preg_match_all('/<a.*?href=[\'"]([^\'"]+\.(?:jpe?g|png|gif|bmp|webp))[\'"].*?>.*?<\/a>/i', $content, $matches);
            $count += isset($matches[1]) ? count($matches[1]) : 0;

            return $count;
        }

        private function format_views($views)
        {
            if ($views >= 10000) {
                return round($views / 10000, 2) . 'w';
            }
            return $views;
        }

        private function get_post_thumbnail()
        {
            global $post;
            $size = 'medium';
            $thumbnail_url = get_post_meta($post->ID, 'thumbnail_url', true);

            if (has_post_thumbnail($post->ID)) {
                return get_the_post_thumbnail($post->ID, $size, array('class' => 'hfw-post-thumb', 'alt' => get_the_title()));
            } elseif ($thumbnail_url) {
                return sprintf('<img src="%s" class="hfw-post-thumb" alt="%s">', $thumbnail_url, get_the_title());
            } else {
                $first_image = $this->get_first_image();
                if ($first_image) {
                    return sprintf('<img src="%s" class="hfw-post-thumb" alt="%s">', $first_image, get_the_title());
                } else {
                    $category = get_the_category();
                    foreach ($category as $cat) {
                        $cat_img_url = zib_get_taxonomy_img_url($cat->cat_ID, $size);
                        if ($cat_img_url) {
                            return sprintf('<img src="%s" class="hfw-post-thumb" alt="%s">', $cat_img_url, get_the_title());
                        }
                    }
                    return zib_get_lazy_thumb('default');
                }
            }
        }
    }
?>