<?php
    add_action('widgets_init', 'widget_register_ranklists');

    function widget_register_ranklists()
    {
        register_widget('TengfeiWidgetsRanklists');
    }

    class TengfeiWidgetsRanklists extends WP_Widget
    {

        public function __construct()
        {
            parent::__construct(
                'tengfei_widgets_ranklists',
                __('ZibTF 首页排行榜（新版）', 'text_domain'),
                array('description' => __('首页显示三个排行榜.', 'text_domain'))
            );
        }

        public function widget($args, $instance)
        {
            wp_enqueue_style('tengfei-ranking-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_ranklists.css');

            echo '<div class="tengfei-ranking-wrapper wapnone">';
            $this->render_ranking_section($instance);
            echo '</div>';
        }

        private function render_ranking_section($instance)
        {
?>
            <section class="bRank">
                <div class="bRBox cfx">
                    <?php
                    $boxes = array(
                        array('class' => 'bRBoxL', 'title' => '最新教程榜', 'orderby' => 'date'),
                        array('class' => 'bRBoxM', 'title' => '热门教程榜', 'orderby' => 'comment_count'),
                        array('class' => 'bRBoxR', 'title' => '推荐教程榜', 'orderby' => 'meta_value_num')
                    );

                    foreach ($boxes as $index => $box) {
                        $i = $index + 1;
                        $title = isset($instance["title_$i"]) ? $instance["title_$i"] : $box['title'];
                        $category_id = isset($instance["category_$i"]) ? intval($instance["category_$i"]) : 3;
                        $posts_per_page = isset($instance["posts_per_page_$i"]) ? intval($instance["posts_per_page_$i"]) : 5;
                        $orderby = isset($instance["orderby_$i"]) ? $instance["orderby_$i"] : $box['orderby'];

                        $this->render_ranking_box($title, $category_id, $posts_per_page, $orderby, $box['class']);
                    }
                    ?>
                </div>
            </section>
        <?php
        }

        private function render_ranking_box($title, $category_id, $posts_per_page, $orderby, $css_class)
        {
        ?>
            <div class="<?php echo esc_attr($css_class); ?>">
                <a><strong><?php echo esc_html($title); ?></strong></a>
                <?php $this->display_ranking_list($this->get_ranking_posts($category_id, $posts_per_page, $orderby)); ?>
                <a class="rMore" href="<?php echo esc_url(get_category_link($category_id)); ?>" target="_blank" title="<?php echo esc_attr($title); ?>">查看更多 →</a>
            </div>
            <?php
        }

        private function get_ranking_posts($category_id, $posts_per_page = 5, $orderby = 'date')
        {
            $args = array(
                'cat' => $category_id,
                'posts_per_page' => $posts_per_page,
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false
            );

            if ($orderby === 'views' || $orderby === 'favorite' || $orderby === 'like' || $orderby === 'meta_value_num') {
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = $orderby === 'meta_value_num' ? 'views' : $orderby;
            } elseif ($orderby === 'sales_volume') {
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = 'sales_volume';
            } else {
                $args['orderby'] = $orderby;
            }

            return new WP_Query($args);
        }

        private function display_ranking_list($query)
        {
            if ($query->have_posts()) :
                echo "<div class='ranking-list'>";
                while ($query->have_posts()) : $query->the_post();
            ?>
                    <li>
                        <a class="class-item js-rank" href="<?php echo esc_url(get_permalink()); ?>" target="_blank">
                            <?php
                            if (function_exists('zib_post_thumbnail')) {
                                echo zib_post_thumbnail();
                            } else {
                                the_post_thumbnail('thumbnail');
                            }
                            ?>
                            <div>
                                <p><?php the_title(); ?></p>
                                <h6><?php echo get_the_date('Y-m-d'); ?>更新</h6>
                            </div>
                            <i></i>
                        </a>
                    </li>
                <?php
                endwhile;
                echo "</div>";
            endif;
            wp_reset_postdata();
        }

        public function form($instance)
        {
            for ($i = 1; $i <= 3; $i++) {
                $title = isset($instance["title_$i"]) ? $instance["title_$i"] : "";
                $category = isset($instance["category_$i"]) ? intval($instance["category_$i"]) : 3;
                $posts_per_page = isset($instance["posts_per_page_$i"]) ? intval($instance["posts_per_page_$i"]) : 5;
                $orderby = isset($instance["orderby_$i"]) ? $instance["orderby_$i"] : 'date';
                ?>
                <div>
                    <p>
                        <strong>排行榜 <?php echo $i; ?></strong><br>
                        <label for="<?php echo $this->get_field_id("title_$i"); ?>">标题：</label>
                        <input class="widefat" id="<?php echo $this->get_field_id("title_$i"); ?>" name="<?php echo $this->get_field_name("title_$i"); ?>" type="text" value="<?php echo esc_attr($title); ?>">

                        <label for="<?php echo $this->get_field_id("category_$i"); ?>">分类ID：</label>
                        <input class="widefat" id="<?php echo $this->get_field_id("category_$i"); ?>" name="<?php echo $this->get_field_name("category_$i"); ?>" type="number" value="<?php echo esc_attr($category); ?>">

                        <label for="<?php echo $this->get_field_id("posts_per_page_$i"); ?>">显示文章数：</label>
                        <input class="widefat" id="<?php echo $this->get_field_id("posts_per_page_$i"); ?>" name="<?php echo $this->get_field_name("posts_per_page_$i"); ?>" type="number" value="<?php echo esc_attr($posts_per_page); ?>" min="1" max="8">
                        <small>最高只能8篇，建议5篇</small>

                        <label for="<?php echo $this->get_field_id("orderby_$i"); ?>">排序方式：</label>
                        <select class="widefat" id="<?php echo $this->get_field_id("orderby_$i"); ?>" name="<?php echo $this->get_field_name("orderby_$i"); ?>">
                            <option value="comment_count" <?php selected($orderby, 'comment_count'); ?>>评论数</option>
                            <option value="views" <?php selected($orderby, 'views'); ?>>浏览量</option>
                            <option value="like" <?php selected($orderby, 'like'); ?>>点赞数</option>
                            <option value="favorite" <?php selected($orderby, 'favorite'); ?>>收藏数</option>
                            <option value="sales_volume" <?php selected($orderby, 'sales_volume'); ?>>销售数量</option>
                            <option value="date" <?php selected($orderby, 'date'); ?>>发布时间</option>
                            <option value="modified" <?php selected($orderby, 'modified'); ?>>更新时间</option>
                            <option value="rand" <?php selected($orderby, 'rand'); ?>>随机排序</option>
                        </select>
                    </p>
                </div>
<?php
            }
        }

        public function update($new_instance, $old_instance)
        {
            $instance = array();

            for ($i = 1; $i <= 3; $i++) {
                $instance["title_$i"] = isset($new_instance["title_$i"]) ? sanitize_text_field($new_instance["title_$i"]) : "";
                $instance["category_$i"] = isset($new_instance["category_$i"]) ? intval($new_instance["category_$i"]) : 3;
                $instance["posts_per_page_$i"] = isset($new_instance["posts_per_page_$i"]) ? min(8, max(1, intval($new_instance["posts_per_page_$i"]))) : 5;
                $instance["orderby_$i"] = isset($new_instance["orderby_$i"]) ? sanitize_text_field($new_instance["orderby_$i"]) : 'date';
            }

            return $instance;
        }
    }
