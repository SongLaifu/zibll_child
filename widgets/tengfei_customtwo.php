<?php
    wp_enqueue_style('tengfei-customtwo-widget-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_customtwo.css', array(), '1.0.0');
    add_action('widgets_init', 'tengfei_customtwo_homepage_widget');

    function tengfei_customtwo_homepage_widget()
    {
        register_widget('Customtwo_Homepage_Widget');
    }

    class Customtwo_Homepage_Widget extends WP_Widget
    {

        public function __construct()
        {
            parent::__construct(
                'customtwo_homepage_widget',
                __('ZibTF 首页推荐卡片（第二版）', 'text_domain'),
                array('description' => __('自定义首页推荐卡片，包括标题、分类按钮和特定文章。', 'text_domain'))
            );

            add_action('template_redirect', array($this, 'random_postlite'));
        }

        public function random_postlite()
        {
            if (!isset($_GET['random'])) return;

            global $wpdb;
            $query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'post' AND post_password = '' AND post_status = 'publish' ORDER BY RAND() LIMIT 1";
            if (isset($_GET['random_cat_id'])) {
                $random_cat_id = (int) $_GET['random_cat_id'];
                $query = "SELECT DISTINCT ID FROM $wpdb->posts AS p INNER JOIN $wpdb->term_relationships AS tr ON (p.ID = tr.object_id AND tr.term_taxonomy_id = $random_cat_id) INNER JOIN $wpdb->term_taxonomy AS tt ON(tr.term_taxonomy_id = tt.term_taxonomy_id AND taxonomy = 'category') WHERE post_type = 'post' AND post_password = '' AND post_status = 'publish' ORDER BY RAND() LIMIT 1";
            }
            if (isset($_GET['random_post_type'])) {
                $post_type = preg_replace('|[^a-z]|i', '', $_GET['random_post_type']);
                $query = "SELECT ID FROM $wpdb->posts WHERE post_type = '$post_type' AND post_password = '' AND post_status = 'publish' ORDER BY RAND() LIMIT 1";
            }
            $random_id = $wpdb->get_var($query);
            wp_redirect(get_permalink($random_id));
            exit;
        }

        public function widget($args, $instance)
        {
            if (!function_exists('zib_widget_is_show') || !zib_widget_is_show($instance)) {
                return;
            }
?>
            <div id="home_top">
                <div class="recent-post-top" id="recent-post-top" style="padding-bottom:10px">
                    <div id="bannerGroup">
                        <div id="banners">
                            <div class="banners-title">
                                <div class="banners-title-big"><?php echo esc_html($instance['title_line1']); ?></div>
                                <div class="banners-title-big"><?php echo esc_html($instance['title_line2']); ?></div>
                                <div class="banners-title-small"><?php echo esc_html($instance['subtitle']); ?></div>
                            </div>
                            <div class="tags-group-all">
                                <div class="tags-group-wrapper">
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#989bf8"><img title="AfterEffects" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/20239df3f66615b532ce571eac6d14ff21cf072602.png!cover">
                                        </div>
                                        <div class="tags-group-icon" style="background:#fff"><img src="https://p.zhheo.com/2023e0ded7b724a39f12d59c3dc8fbdc7cbe074202.png!cover" title="Sketch" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;">
                                        </div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#57b6e6"><img title="Docker" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/20231108a540b2862d26f8850172e4ea58ed075102.png!cover">
                                        </div>
                                        <div class="tags-group-icon" style="background:#4082c3"><img src="https://p.zhheo.com/2023e4058a91608ea41751c4f102b131f267075902.png!cover" title="Photoshop" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;">
                                        </div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#fff"><img src="https://p.zhheo.com/20233e777652412247dd57fd9b48cf997c01070702.png!cover" title="FinalCutPro" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" data-ll-status="loading"></div>
                                        <div class="tags-group-icon" style="background:#fff"><img src="https://p.zhheo.com/20235c0731cd4c0c95fc136a8db961fdf963071502.png!cover" title="Python" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;">
                                        </div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#eb6840"><img title="Swift" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" src="https://p.zhheo.com/202328bbee0b314297917b327df4a704db5c072402.png!cover" data-ll-status="loading"></div>
                                        <div class="tags-group-icon" style="background:#8f55ba"><img title="Principle" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/2023f76570d2770c8e84801f7e107cd911b5073202.png!cover">
                                        </div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#f29e39"><img title="illustrator" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" src="https://p.zhheo.com/20237359d71b45ab77829cee5972e36f8c30073902.png!cover" data-ll-status="loading"></div>
                                        <div class="tags-group-icon" style="background:#2c51db"><img src="https://p.zhheo.com/20237c548846044a20dad68a13c0f0e1502f074602.png!cover" title="CSS3" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" data-ll-status="loading"></div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#f7cb4f"><img title="JS" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" src="https://cloud-image-host.oss-cn-beijing.aliyuncs.com/img/banners/git.webp" data-ll-status="loading"></div>
                                        <div class="tags-group-icon" style="background:#e9572b"><img title="HTML" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" src="https://p.zhheo.com/202372b4d760fd8a497d442140c295655426070302.png!cover" data-ll-status="loading"></div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#df5b40"><img title="Git" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" src="https://p.zhheo.com/2023ffa5707c4e25b6beb3e6a3d286ede4c6071102.png!cover" data-ll-status="loading"></div>
                                        <div class="tags-group-icon" style="background:#1f1f1f"><img title="Rhino" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" src="https://p.zhheo.com/20231ca53fa0b09a3ff1df89acd7515e9516173302.png!cover" data-ll-status="loading"></div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#989bf8"><img title="AfterEffects" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/20239df3f66615b532ce571eac6d14ff21cf072602.png!cover">
                                        </div>
                                        <div class="tags-group-icon" style="background:#fff"><img title="Sketch" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/2023e0ded7b724a39f12d59c3dc8fbdc7cbe074202.png!cover">
                                        </div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#57b6e6"><img title="Docker" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/20231108a540b2862d26f8850172e4ea58ed075102.png!cover">
                                        </div>
                                        <div class="tags-group-icon" style="background:#4082c3"><img title="Photoshop" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/2023e4058a91608ea41751c4f102b131f267075902.png!cover">
                                        </div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#fff"><img title="FinalCutPro" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/20233e777652412247dd57fd9b48cf997c01070702.png!cover">
                                        </div>
                                        <div class="tags-group-icon" style="background:#fff"><img title="Python" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/20235c0731cd4c0c95fc136a8db961fdf963071502.png!cover">
                                        </div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#eb6840"><img title="Swift" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/202328bbee0b314297917b327df4a704db5c072402.png!cover">
                                        </div>
                                        <div class="tags-group-icon" style="background:#8f55ba"><img title="Principle" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/2023f76570d2770c8e84801f7e107cd911b5073202.png!cover">
                                        </div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#f29e39"><img title="illustrator" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/20237359d71b45ab77829cee5972e36f8c30073902.png!cover">
                                        </div>
                                        <div class="tags-group-icon" style="background:#2c51db"><img title="CSS3" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;" class="entered exited" src="https://p.zhheo.com/20237c548846044a20dad68a13c0f0e1502f074602.png!cover">
                                        </div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#f7cb4f"><img src="https://p.zhheo.com/2023786e7fc488f453d5fb2be760c96185c0075502.png!cover" title="JS" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;">
                                        </div>
                                        <div class="tags-group-icon" style="background:#e9572b"><img src="https://p.zhheo.com/202372b4d760fd8a497d442140c295655426070302.png!cover" title="HTML" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;">
                                        </div>
                                    </div>
                                    <div class="tags-group-icon-pair">
                                        <div class="tags-group-icon" style="background:#df5b40"><img src="https://p.zhheo.com/2023ffa5707c4e25b6beb3e6a3d286ede4c6071102.png!cover" title="Git" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;">
                                        </div>
                                        <div class="tags-group-icon" style="background:#1f1f1f"><img src="https://cloud-image-host.oss-cn-beijing.aliyuncs.com/img/banners/Java.webp" title="Rhino" onerror="this.onerror=null,this.src=&quot;https://bu.dusays.com/2023/03/03/6401a79030db5.png&quot;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $this->render_tags_group(); ?>
                            <a id="banner-hover" href="<?php echo esc_url(add_query_arg('random', '1', home_url())); ?>">
                                <i class="icon-right"></i>
                                <span class="bannerText">随便逛逛<use xlink:href="#icon-xiangyou2"></use><svg class="icon" aria-hidden="true">
                                        <use xlink:href="#icon-xiangyou2"></use>
                                    </svg></span>
                            </a>
                        </div>
                        <div class="categoryGroup">
                            <?php
                            $this->render_category_button($instance, 1);
                            $this->render_category_button($instance, 2);
                            $this->render_category_button($instance, 3);
                            ?>
                        </div>
                    </div>
                    <div class="topGroup">
                        <?php $this->render_recent_posts($instance); ?>
                        <?php $this->render_today_card($instance); ?>
                    </div>
                </div>
            </div>
            <script src="//at.alicdn.com/t/c/font_3977018_lplr589idei.js"></script>
            <script>
                var bywind = {
                    hideTodayCard: function() {
                        document.getElementById("todayCard") && document.getElementById("todayCard").classList.add("hide")
                    }
                }
                jQuery(".topGroup").hover(function() {}, function() {
                    document.getElementById("todayCard").classList.remove("hide");
                    document.getElementById("todayCard").style.zIndex = 1;
                });
            </script>
        <?php
        }

        private function render_tags_group() {}

        private function render_category_button($instance, $num)
        {
            $text = !empty($instance['category_text_' . $num]) ? $instance['category_text_' . $num] : '';
            $category_id = !empty($instance['category_id_' . $num]) ? $instance['category_id_' . $num] : 0;
            $link = $category_id ? get_category_link($category_id) : '#';
            $shadow = $num == 1 ? 'var(--heo-shadow-blue)' : ($num == 2 ? 'var(--heo-shadow-red)' : 'var(--heo-shadow-green)');
            $class = $num == 1 ? 'heo_one' : ($num == 2 ? 'heo_two' : 'heo_three');
            $icon = $num == 1 ? 'icon-star-smile-fill' : ($num == 2 ? 'icon-fire-fill' : 'icon-book-mark-fill');
            echo '<div class="categoryItem" style="box-shadow:' . esc_attr($shadow) . '">';
            echo '<a class="categoryButton ' . esc_attr($class) . '" href="' . esc_url($link) . '">';
            echo '<span class="categoryButtonText">' . esc_html($text) . '</span>';
            echo '<i class="heofont ' . esc_attr($icon) . '"></i>';
            echo '</a>';
            echo '</div>';
        }

        private function render_recent_posts($instance)
        {
            $post_ids = !empty($instance['post_ids']) ? explode(',', $instance['post_ids']) : array();
            $post_ids = array_map('trim', $post_ids);
            $post_ids = array_filter($post_ids);

            $total_posts = 6;
            $specified_posts_count = count($post_ids);

            if ($specified_posts_count < $total_posts) {
                $args = array(
                    'post__not_in' => $post_ids,
                    'posts_per_page' => $total_posts - $specified_posts_count,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post_status' => 'publish'
                );
                $recent_posts = new WP_Query($args);

                if ($recent_posts->have_posts()) :
                    while ($recent_posts->have_posts()) : $recent_posts->the_post();
                        $this->render_post_item($recent_posts->current_post);
                    endwhile;
                endif;
                wp_reset_postdata();
            }

            if (!empty($post_ids)) {
                $args = array(
                    'post__in' => $post_ids,
                    'orderby' => 'post__in',
                    'posts_per_page' => count($post_ids),
                    'post_status' => 'publish'
                );
                $specified_posts = new WP_Query($args);

                if ($specified_posts->have_posts()) :
                    while ($specified_posts->have_posts()) : $specified_posts->the_post();
                        $this->render_post_item($specified_posts->current_post + ($total_posts - $specified_posts_count));
                    endwhile;
                endif;
                wp_reset_postdata();
            }
        }

        private function render_post_item($counter)
        {
            $cover_class = $counter % 2 == 0 ? 'left_radius' : 'right_radius';
            $thumbnail_url = $this->get_post_thumbnail_url(get_the_ID());
            $default_img_url = !empty($this->instance['default_post_img']) ? esc_url($this->instance['default_post_img']) : '';

            if ($thumbnail_url) {
                $img_url = esc_url($thumbnail_url);
            } elseif ($default_img_url) {
                $img_url = esc_url($default_img_url);
            } else {
                $img_url = esc_url(get_template_directory_uri() . '/img/tengfei/default.jpg');
            }

        ?>
            <div class="recent-post-item">
                <div class="post_cover <?php echo esc_attr($cover_class); ?>">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <span class="recent-post-top-text">荐</span>
                        <img class="post_bg" src="<?php echo $img_url; ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    </a>
                </div>
                <div class="recent-post-info">
                    <a class="article-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_title(); ?>
                    </a>
                </div>
            </div>
        <?php
        }

        private function get_post_thumbnail_url($post_id)
        {
            if (has_post_thumbnail($post_id)) {
                $thumbnail_id = get_post_thumbnail_id($post_id);
                $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'full');
                return $thumbnail_url[0];
            } else {
                $post = get_post($post_id);
                $first_img = '';
                if ($post) {
                    preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
                    if (!empty($matches[1][0])) {
                        $first_img = $matches[1][0];
                    }
                }
                return $first_img ? $first_img : false;
            }
        }

        private function render_today_card($instance)
        {
            $about_image = !empty($instance['about_image']) ? esc_url($instance['about_image']) : get_stylesheet_directory_uri() .  '/widgets/img/O1CN01xXWU4f1QbIiiLjltL_!!2210123621994.jpg';
            $about_text = !empty($instance['about_text']) ? esc_html($instance['about_text']) : '致力于分享优质互联网资源';
        ?>
            <div class="todayCard" id="todayCard" onclick="pjax.loadUrl('/p/671f98c8.html')" style="z-index:1">
                <div class="todayCard-info">
                    <div class="todayCard-title" style="color: #ffffff;"><?php echo $about_text; ?></div>
                </div>
                <div class="todayCard-cover" style="background:url(<?php echo $about_image; ?>) no-repeat center /cover"></div>
                <canvas id="bubble_canvas" style="position:absolute; bottom:0; height:200px;"></canvas>
                <script src="<?php get_stylesheet_directory_uri() . '/widgets/js/bubble.js' ?>"></script>
                <div class="banner-button-group">
                    <a class="banner-button" onclick="event.stopPropagation(); bywind.hideTodayCard()">
                        <span class="banner-button-text" style="color: #ffffff;">更多推荐</span>
                    </a>
                </div>
            </div>
        <?php
        }

        public function form($instance)
        {
            $title_line1 = !empty($instance['title_line1']) ? esc_attr($instance['title_line1']) : '分享设计';
            $title_line2 = !empty($instance['title_line2']) ? esc_attr($instance['title_line2']) : '与科技生活';
            $subtitle = !empty($instance['subtitle']) ? esc_attr($instance['subtitle']) : 'TFBKW.COM';
            $post_ids = !empty($instance['post_ids']) ? esc_attr($instance['post_ids']) : '';
            $about_image = !empty($instance['about_image']) ? esc_attr($instance['about_image']) : '';
            $about_text = !empty($instance['about_text']) ? esc_attr($instance['about_text']) : '致力于分享优质互联网资源';

            if (function_exists('zib_get_widget_show_type_input')) {
                echo zib_get_widget_show_type_input($instance, $this->get_field_name('show_type'));
            }

        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title_line1'); ?>"><?php _e('标题第一行:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title_line1'); ?>" name="<?php echo $this->get_field_name('title_line1'); ?>" type="text" value="<?php echo $title_line1; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('title_line2'); ?>"><?php _e('标题第二行:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title_line2'); ?>" name="<?php echo $this->get_field_name('title_line2'); ?>" type="text" value="<?php echo $title_line2; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('副标题:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo $subtitle; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('post_ids'); ?>"><?php _e('右侧文章输入文章ID即可，最多6篇文章 (用逗号分隔):'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('post_ids'); ?>" name="<?php echo $this->get_field_name('post_ids'); ?>" type="text" value="<?php echo $post_ids; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('about_image'); ?>"><?php _e('右侧背景图片URL:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('about_image'); ?>" name="<?php echo $this->get_field_name('about_image'); ?>" type="text" value="<?php echo $about_image; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('about_text'); ?>"><?php _e('右侧标题文字:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('about_text'); ?>" name="<?php echo $this->get_field_name('about_text'); ?>" type="text" value="<?php echo $about_text; ?>">
            </p>
            <?php
            for ($i = 1; $i <= 3; $i++) {
                $category_text = !empty($instance['category_text_' . $i]) ? esc_attr($instance['category_text_' . $i]) : '';
                $category_id = !empty($instance['category_id_' . $i]) ? esc_attr($instance['category_id_' . $i]) : '';
            ?>
                <p>
                    <label for="<?php echo $this->get_field_id('category_text_' . $i); ?>"><?php _e('分类' . $i . '文本:'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('category_text_' . $i); ?>" name="<?php echo $this->get_field_name('category_text_' . $i); ?>" type="text" value="<?php echo $category_text; ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('category_id_' . $i); ?>"><?php _e('分类' . $i . 'ID:'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('category_id_' . $i); ?>" name="<?php echo $this->get_field_name('category_id_' . $i); ?>" type="text" value="<?php echo $category_id; ?>">
                </p>
<?php
            }
        }

        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title_line1'] = (!empty($new_instance['title_line1'])) ? sanitize_text_field($new_instance['title_line1']) : '';
            $instance['title_line2'] = (!empty($new_instance['title_line2'])) ? sanitize_text_field($new_instance['title_line2']) : '';
            $instance['subtitle'] = (!empty($new_instance['subtitle'])) ? sanitize_text_field($new_instance['subtitle']) : '';
            $instance['post_ids'] = (!empty($new_instance['post_ids'])) ? sanitize_text_field($new_instance['post_ids']) : '';
            $instance['about_image'] = (!empty($new_instance['about_image'])) ? esc_url_raw($new_instance['about_image']) : '';
            $instance['about_text'] = (!empty($new_instance['about_text'])) ? sanitize_text_field($new_instance['about_text']) : '致力于分享优质互联网资源';
            $instance['default_post_img'] = (!empty($new_instance['default_post_img'])) ? esc_url_raw($new_instance['default_post_img']) : '';
            $instance['show_type'] = (!empty($new_instance['show_type'])) ? sanitize_text_field($new_instance['show_type']) : ''; // 新增保存show_type

            for ($i = 1; $i <= 3; $i++) {
                $instance['category_text_' . $i] = (!empty($new_instance['category_text_' . $i])) ? sanitize_text_field($new_instance['category_text_' . $i]) : '';
                $instance['category_id_' . $i] = (!empty($new_instance['category_id_' . $i])) ? sanitize_text_field($new_instance['category_id_' . $i]) : '';
            }

            return $instance;
        }
    }
