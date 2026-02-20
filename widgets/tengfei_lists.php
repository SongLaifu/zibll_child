<?php
    add_action('widgets_init', 'tengfei_lists_posts_widget');

    function tengfei_lists_posts_widget()
    {
        register_widget('widget_tengfei_lists_posts');
    }

    class widget_tengfei_lists_posts extends WP_Widget
    {
        public function __construct()
        {
            $widget = array(
                'w_id'        => 'widget_tengfei_lists_posts',
                'w_name'      => _('ZibTF 文章列表'),
                'classname'   => '',
                'description' => '核心的文章列表功能',
            );
            parent::__construct($widget['w_id'], $widget['w_name'], $widget);
        }

        public function widget($args, $instance)
        {

            wp_enqueue_style('tengfei-ceshi-widget-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_singleposts.css', array(), '1.0.0');

            if (!zib_widget_is_show($instance)) {
                return;
            }
            extract($args);

            $defaults = array(
                'title'        => '',
                'mini_title'   => '',
                'more_but'     => '<i class="fa fa-angle-right fa-fw"></i>更多',
                'more_but_url' => '',
                'type'         => 'auto',
                'limit'        => 6,
                'limit_day' => '',
                'cat'          => '',
                'topics'       => '',
                'orderby'      => 'views',
            );

            $instance = wp_parse_args((array) $instance, $defaults);
            $orderby  = $instance['orderby'];

            $mini_title = $instance['mini_title'];
            if ($mini_title) {
                $mini_title = '<small class="ml10">' . $mini_title . '</small>';
            }
            $title = $instance['title'];
            $class = ' nobottom';
            if ($instance['type'] == 'card') {
                $class = '';
            }
            $more_but = '';
            if ($instance['more_but'] && $instance['more_but_url']) {
                $more_but = '<div class="header__btn-wrapper"><a href="' . $instance['more_but_url'] . '"  type="button" class="button---AUM5ZP text---pn4pHz medium---OGt5iw header__btn">' . $instance['more_but'] . ' <span class="ke-icon---zeGrGg kc-icon---X2pFLQ">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.636 20.435a1 1 0 0 0 1.414 0l4.95-4.95a4 4 0 0 0 0-5.656l-4.95-4.95a1 1 0 0 0-1.414 1.414l4.95 4.95a2 2 0 0 1 0 2.828l-4.95 4.95a1 1 0 0 0 0 1.414Z" fill="currentColor"></path>
                        </svg>
                    </span></a></div>';
            }
            $mini_title .= $more_but;

            if ($title) {
                $title = '<section class="sec-wrapper index-center-block training-camp__wrapper">
        <div id="' . get_category($instance['cat'])->slug . '" class="training-camp__header">
            <div class="header__title-wrapper">' . $title . ' </div>
                <span class="title__sub-name"></span>' . $mini_title . '
            </div>';
            }

            echo '<div class="theme-box">';
            echo $title;

            $args = array(
                'cat'                 => str_replace('，', ',', $instance['cat']),
                'order'               => 'DESC',
                'showposts'           => $instance['limit'],
                'ignore_sticky_posts' => 1,
            );

            if ($orderby !== 'views' && $orderby !== 'favorite' && $orderby !== 'like') {
                $args['orderby'] = $orderby;
            } else {
                $args['orderby']    = 'meta_value_num';
                $args['meta_query'] = array(
                    array(
                        'key'   => $orderby,
                        'order' => 'DESC',
                    ),
                );
            }
            if ($instance['topics']) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'topics',
                        'terms'    => preg_split("/,|，|\s|\n/", $instance['topics']),
                    ),
                );
            }
            if ($instance['limit_day'] > 0) {
                $args['date_query'] = array(
                    array(
                        'after'     => date('Y-m-d H:i:s', strtotime("-" . $instance['limit_day'] . " day")),
                        'before'    => date('Y-m-d H:i:s'),
                        'inclusive' => true,
                    ),
                );
            }

            $list_args = array(
                'type' => $instance['type'],
            );

            $the_query = new WP_Query($args);
            echo '<div class="sec-bd">';
            zib_posts_list($list_args, $the_query);
            echo '</div>';
            echo '</section></div>';
        }

        public function form($instance)
        {
            $defaults = array(
                'title'        => '',
                'mini_title'   => '',
                'more_but'     => '<i class="fa fa-angle-right fa-fw"></i>更多',
                'more_but_url' => '',
                'limit'        => 6,
                'limit_day' => '',
                'type'         => 'auto',
                'topics'       => '',
                'cat'          => '',
                'orderby'      => 'views',
            );
            $instance     = wp_parse_args((array) $instance, $defaults);
            $page_input[] = array(
                'name'  => __('标题：', 'zib_language'),
                'id'    => $this->get_field_name('title'),
                'std'   => $instance['title'],
                'style' => 'margin: 10px auto;',
                'type'  => 'text',
            );
            $page_input[] = array(
                'name'  => __('副标题：', 'zib_language'),
                'id'    => $this->get_field_name('mini_title'),
                'std'   => $instance['mini_title'],
                'style' => 'margin: 10px auto;',
                'type'  => 'text',
            );
            $page_input[] = array(
                'name'  => __('标题右侧按钮->文案：', 'zib_language'),
                'id'    => $this->get_field_name('more_but'),
                'std'   => $instance['more_but'],
                'style' => 'margin: 10px auto;',
                'type'  => 'text',
            );
            $page_input[] = array(
                'name'  => __('标题右侧按钮->链接：', 'zib_language'),
                'id'    => $this->get_field_name('more_but_url'),
                'std'   => $instance['more_but_url'],
                'desc'  => '设置为任意链接',
                'style' => 'margin: 10px auto;',
                'type'  => 'text',
            );
            echo zib_get_widget_show_type_input($instance, $this->get_field_name('show_type'));
            echo zib_edit_input_construct($page_input);
?>
            <p>
                <label>
                    <i style="width:100%;font-size: 12px;">核心的文章列表功能，不建议设置在侧边栏。如果要设置在全宽度位置，请确保显示模式一致，不要选择自动模式</i>
                </label>
            </p>

            <p>
                <?php zib_cat_help() ?>
                <input style="width:100%;" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="text" value="<?php echo str_replace('，', ',', $instance['cat']); ?>" size="24" />
            </p>
            <p>
                <?php zib_topics_help() ?>
                <input style="width:100%;" id="<?php echo $this->get_field_id('topics'); ?>" name="<?php echo $this->get_field_name('topics'); ?>" type="text" value="<?php echo $instance['topics']; ?>" size="24" />
            </p>
            <p>
                <label>
                    显示数目：
                    <input style="width:100%;" name="<?php echo $this->get_field_name('limit') ?>" type="number" value="<?php echo $instance['limit'] ?>" size="24" />
                </label>
            </p>
            <p>
                <label>
                    限制时间（最近X天）：
                    <input style="width:100%;" name="<?php echo $this->get_field_name('limit_day') ?>" type="number" value="<?php echo $instance['limit_day'] ?>" size="24" />
                </label>
            </p>

            <p>
                <label>
                    列表显示模式：
                    <select style="width:100%;" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
                        <option value="auto" <?php selected('auto', $instance['type']); ?>>默认（自动跟随主题设置)</option>
                        <option value="card" <?php selected('card', $instance['type']); ?>>卡片模式</option>
                        <option value="no_thumb" <?php selected('no_thumb', $instance['type']); ?>>无缩略图列表</option>
                        <option value="mult_thumb" <?php selected('mult_thumb', $instance['type']); ?>>多图模式</option>
                    </select>
                </label>
            </p>
            <p>
                <label>
                    排序：
                    <select style="width:100%;" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                        <option value="comment_count" <?php selected('comment_count', $instance['orderby']); ?>>评论数</option>
                        <option value="views" <?php selected('views', $instance['orderby']); ?>>浏览量</option>
                        <option value="like" <?php selected('like', $instance['orderby']); ?>>点赞数</option>
                        <option value="favorite" <?php selected('favorite', $instance['orderby']); ?>>收藏数</option>
                        <option value="date" <?php selected('date', $instance['orderby']); ?>>发布时间</option>
                        <option value="modified" <?php selected('modified', $instance['orderby']); ?>>更新时间</option>
                        <option value="rand" <?php selected('rand', $instance['orderby']); ?>>随机排序</option>
                    </select>
                </label>
            </p>
<?php
        }
    }
?>