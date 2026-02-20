<?php
    add_action('widgets_init', 'widget_renqizuoze');

    function widget_renqizuoze()
    {
        register_widget('widget_renqizuoze_listsents');
    }

    class widget_renqizuoze_listsents extends WP_Widget
    {
        public function __construct()
        {
            $widget_options = array(
                'w_id'        => 'widget_renqizuoze_listsents',
                'w_name'      => __('Zibll 首页人气作者'),
                'classname'   => '',
                'description' => '首页显示人气作者.',
            );
            parent::__construct($widget_options['w_id'], $widget_options['w_name'], $widget_options);
        }

        public function widget($args, $instance)
        {


            echo '
    <style>
    
              div#rqph {
    padding: 0px;
}
              
              
              
              </style>';

?>

            <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . "/widgets/css/zuoz.css" ?>">


            <div class="home-authors" id="Onecad-tuijian">
                <div id="rqph" class="container">

                    <div class="part-content">
                        <div class="items author-items">
                            <?php
                            $allusers = get_users([
                                'has_published_posts' => ['post'], //post 文章类型，还可以追加 page 以及自定义文章类型
                                //  'exclude' => array(1)
                            ]);


                            $newArrays = array();
                            foreach ($allusers as $alluser) {

                                $newArraya = array('name' => $alluser->display_name, 'renqi' => get_user_posts_meta_count($alluser->ID, 'views'), 'userid' => $alluser->ID);
                                array_push($newArrays, $newArraya);
                            }
                            function compareUserId($a, $b)
                            {
                                if ($a['userid'] == $b['userid']) {
                                    return 0;
                                } elseif ($a['userid'] < $b['userid']) {
                                    return -1; // 如果a的ID小于b的ID，a应该排在前面  
                                } else {
                                    return 1;
                                }
                            }

                            usort($newArrays, "compareUserId"); // 调用 usort() 函数按照ID进行排序

                            $count = 0;
                            $bgnum = 0;
                            foreach ($newArrays as $newArray) {

                            ?>

                                <div class="item item-author">
                                    <div class="item-wrap">
                                        <div class="item-bg">
                                            <i class="thumb thumb-<?php echo ++$bgnum; ?>"></i>
                                        </div>
                                        <div class="item-top">

                                            <div class="author-avatar"><?php echo zib_get_data_avatar($newArray['userid']); ?><?php echo zib_get_avatar_badge($newArray['userid']); ?></div>
                                            <div class="author-main">
                                                <p class="author-name">
                                                    <?php echo zib_get_user_name('id=' . $newArray['userid'] . '&class=flex1 flex ac&follow=true'); ?> </p>
                                                <p class="author-meta">
                                                    <span>人气 <?php echo $newArray['renqi']; ?></span>
                                                    <span>文章 <?php echo (int) count_user_posts($newArray['userid'], 'post', true); ?></span>
                                                </p>
                                            </div>

                                            <div class="author-info">
                                                <p><i class="ico icon-article"></i><?php echo get_user_desc($newArray['userid']); ?></p>
                                            </div>


                                            <div class="author-btn">
                                                <div class="looo">
                                                    <div class="user-s-follow jitheme-button">
                                                        <?php echo zib_get_author_header_btns($newArray['userid']); ?>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="item-bottom">
                                            <p class="item-bottom-title">最近更新</p>
                                            <div class="item-bottom-cont">
                                                <div class="items">

                                                    <?php
                                                    $lzj = new WP_Query(array(
                                                        'posts_per_page' => 2, //每页返回2个
                                                        'post_type' => 'post',
                                                        'post_status' => 'publish',
                                                        'author' => $newArray['userid'],
                                                        'orderby' => 'views',
                                                    ));

                                                    while ($lzj->have_posts()) : $lzj->the_post();
                                                        $category  = get_the_category($post->id);
                                                    ?>


                                                        <div class="ap-item">
                                                            <div class="ap-item-wrap has-thumb">
                                                                <div class="ap-item-thumb">
                                                                    <a href="<?php esc_url(the_permalink()); ?>" target=_blank><?php echo zib_post_thumbnail(); ?></a>
                                                                </div>
                                                                <div class="ap-item-main">
                                                                    <p class="ap-item-title"><a href="<?php esc_url(the_permalink()); ?>" target=_blank><?php the_title(); ?></a></p>
                                                                    <p class="ap-item-meta"><span class="but c-blue"><i class="fa fa-folder-open-o" aria-hidden="true"></i><a href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>" target=_blank><?php echo  $category[0]->cat_name; ?></a></span></p>
                                                                </div>
                                                            </div>
                                                        </div>




                                                    <?php endwhile; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            <?php if (++$count > 2) {

                                    break; // 达到指定数量后跳出循环
                                }
                            }
                            ?>

                            <div class="item item-tobe-author">
                                <div class="tobe-wrap" data-eq-height=".item-author" style="height:390px;">
                                    <div class="item-wrap">
                                        <div class="tobe-author-wrap">
                                            <div class="tobe-author">
                                                <p class="item-title"> <i class="fa fa-fw fa-pencil-square-o"></i> 人气作者榜 </p>
                                                <div class="item-cont">
                                                    <p>我饮人间二两酒，一饮无奈，一饮空。我借人间二两墨，一笔相思，一笔错。</p>



                                                    <p> <span class="meta-item meta-avatars">

                                                            <?php $count2 = 0;
                                                            foreach ($newArrays as $newArray) {

                                                                if ($count2 < 5) { // 判断计数器小于3时才输出
                                                                    echo zib_get_data_avatar($newArray['userid']);

                                                                    $count2++; // 每次输出后将计数器加1
                                                                } else {
                                                                    break; // 达到指定数量后跳出循环
                                                                }
                                                            }


                                                            ?>
                                                        </span> <span class="meta-item meta-views">人气作者</span></p>
                                                    <p class="count">
                                                        <strong><?php echo count($allusers); ?></strong>
                                                        <span>位作者加入</span>
                                                    </p>
                                                </div>
                                                <div class="item-btns">
                                                    <a href="/newposts" target="_blank" class="btn btn-orange">我要投稿</a>
                                                    <a href="/user" target="_blank" class="btn btn-orange-border">用户中心</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }


        public function form($instance)
        {
            $defaults = array(
                'title'        => '',
                'mini_title'   => '',
                'more_but'     => '<i class="fa fa-angle-right fa-fw"></i>更多',
                'more_but_url' => '',
                'number'       => 8,
                'hide_box'     => '',
            );

            $instance = wp_parse_args((array) $instance, $defaults);

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
            $page_input[] = array(
                //    'name'  => __('显示背景盒子', 'zib_language'),
                'id'    => $this->get_field_name('hide_box'),
                'std'   => $instance['hide_box'],
                'desc'  => '不显示背景盒子',
                'style' => 'margin: 10px auto;',
                'type'  => 'checkbox',
            );

            echo zib_get_widget_show_type_input($instance, $this->get_field_name('show_type'));

            echo zib_edit_input_construct($page_input);
        ?>

<?php
        }
    }

