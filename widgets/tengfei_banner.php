<?php
    wp_enqueue_style('tengfei-banner-widget-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_banner.css');

    class Homepage_Banner_Widget extends WP_Widget
    {
        // 构造函数，初始化小部件
        public function __construct()
        {
            parent::__construct(
                'homepage_banner_widget',
                __('ZibTF 首页推荐卡片（第三版）', 'text_domain'),
                array('description' => __('第二版首页推荐卡片，包括标题、分类按钮和特定文章', 'text_domain'))
            );
        }

        // 生成小部件的配置表单
        public function form($instance)
        {
            // 从实例中获取数据，如果不存在则使用默认值
            $post_ids = !empty($instance['post_ids']) ? $instance['post_ids'] : '';
            $title_1 = !empty($instance['title_1']) ? $instance['title_1'] : '分享设计';
            $title_2 = !empty($instance['title_2']) ? $instance['title_2'] : '与科技生活';
            $title_3 = !empty($instance['title_3']) ? $instance['title_3'] : '产品、交互、设计、开发';
            $link_1_text = !empty($instance['link_1_text']) ? $instance['link_1_text'] : '运维';
            $link_1_url = !empty($instance['link_1_url']) ? $instance['link_1_url'] : '/network';
            $link_2_text = !empty($instance['link_2_text']) ? $instance['link_2_text'] : '技术';
            $link_2_url = !empty($instance['link_2_url']) ? $instance['link_2_url'] : '/tech';
            $today_card_tips = !empty($instance['today_card_tips']) ? $instance['today_card_tips'] : '新功能';
            $today_card_title = !empty($instance['today_card_title']) ? $instance['today_card_title'] : '热爱可抵漫长岁月！';
            $today_card_cover_url = !empty($instance['today_card_cover_url']) ? $instance['today_card_cover_url'] : get_stylesheet_directory_uri() . '/widgets/img/O1CN01xXWU4f1QbIiiLjltL_!!2210123621994.jpg';
?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('post_ids')); ?>">
                    <?php _e('文章ID (用逗号分隔):', 'text_domain'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('post_ids')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('post_ids')); ?>"
                    type="text" value="<?php echo esc_attr($post_ids); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title_1')); ?>">
                    <?php _e('标题1', 'text_domain'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title_1')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title_1')); ?>"
                    type="text" value="<?php echo esc_attr($title_1); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title_2')); ?>">
                    <?php _e('标题2', 'text_domain'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title_2')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title_2')); ?>"
                    type="text" value="<?php echo esc_attr($title_2); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title_3')); ?>">
                    <?php _e('描述', 'text_domain'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title_3')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title_3')); ?>"
                    type="text" value="<?php echo esc_attr($title_3); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('link_1_text')); ?>">
                    <?php _e('左侧第一个按钮文本(建议两个字即可)', 'text_domain'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('link_1_text')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('link_1_text')); ?>"
                    type="text" value="<?php echo esc_attr($link_1_text); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('link_1_url')); ?>">
                    <?php _e('左侧第一个按钮跳转链接', 'text_domain'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('link_1_url')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('link_1_url')); ?>"
                    type="text" value="<?php echo esc_attr($link_1_url); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('link_2_text')); ?>">
                    <?php _e('左侧第二个按钮文本(建议两个字即可)', 'text_domain'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('link_2_text')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('link_2_text')); ?>"
                    type="text" value="<?php echo esc_attr($link_2_text); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('link_2_url')); ?>">
                    <?php _e('左侧第二个按钮跳转链接', 'text_domain'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('link_2_url')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('link_2_url')); ?>"
                    type="text" value="<?php echo esc_attr($link_2_url); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('today_card_tips')); ?>">
                    <?php _e('右侧第一个标题', 'text_domain'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('today_card_tips')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('today_card_tips')); ?>"
                    type="text" value="<?php echo esc_attr($today_card_tips); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('today_card_tips')); ?>">
                    <?php _e('右侧第二个描述', 'text_domain'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('today_card_title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('today_card_title')); ?>"
                    type="text" value="<?php echo esc_attr($today_card_title); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('today_card_cover_url'); ?>"><?php _e('右侧背景图片URL:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('today_card_cover_url'); ?>" name="<?php echo $this->get_field_name('today_card_cover_url'); ?>" type="text" value="<?php echo esc_attr($today_card_cover_url); ?>">
            </p>
        <?php
        }

        // 更新小部件配置表单提交后的数据
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['post_ids'] = (!empty($new_instance['post_ids'])) ? strip_tags($new_instance['post_ids']) : '';
            $instance['title_1'] = (!empty($new_instance['title_1'])) ? strip_tags($new_instance['title_1']) : '分享设计';
            $instance['title_2'] = (!empty($new_instance['title_2'])) ? strip_tags($new_instance['title_2']) : '与科技生活';
            $instance['title_3'] = (!empty($new_instance['title_3'])) ? strip_tags($new_instance['title_3']) : '产品、交互、设计、开发';
            $instance['link_1_text'] = (!empty($new_instance['link_1_text'])) ? strip_tags($new_instance['link_1_text']) : '运维';
            $instance['link_1_url'] = (!empty($new_instance['link_1_url'])) ? esc_url_raw($new_instance['link_1_url']) : '/network';
            $instance['link_2_text'] = (!empty($new_instance['link_2_text'])) ? strip_tags($new_instance['link_2_text']) : '技术';
            $instance['link_2_url'] = (!empty($new_instance['link_2_url'])) ? esc_url_raw($new_instance['link_2_url']) : '/tech';
            $instance['today_card_tips'] = (!empty($new_instance['today_card_tips'])) ? strip_tags($new_instance['today_card_tips']) : '新功能';
            $instance['today_card_title'] = (!empty($new_instance['today_card_title'])) ? strip_tags($new_instance['today_card_title']) : '热爱可抵漫长岁月';
            $instance['today_card_cover_url'] = (!empty($new_instance['today_card_cover_url'])) ? esc_url_raw($new_instance['today_card_cover_url']) : get_stylesheet_directory_uri() . 'widgets/img/O1CN01xXWU4f1QbIiiLjltL_!!2210123621994.jpg';
            return $instance;
        }

        // 根据文章 ID 获取文章列表，如果不足 6 篇，补充随机文章
        public function get_posts($post_ids)
        {
            $posts = array();
            if (!empty($post_ids)) {
                $ids = array_map('intval', explode(',', $post_ids));
                $query = new WP_Query(array(
                    'post_type' => 'post',
                    'post__in' => $ids,
                    'orderby' => 'post__in',
                ));
                $posts = $query->posts;
            }
            if (count($posts) < 6) {
                $random_query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 6 - count($posts),
                    'post__not_in' => wp_list_pluck($posts, 'ID'),
                ));
                $posts = array_merge($posts, $random_query->posts);
            }
            return $posts;
        }

        // 渲染文章卡片
        public function render_cards($posts)
        {
            ob_start();
        ?>
            <div class="recent-post-group">
                <?php foreach ($posts as $post) :
                    $title = get_the_title($post);
                    $link = get_permalink($post);
                    $content = apply_filters('the_content', get_post_field('post_content', $post->ID));
                    // 从文章内容中查找图片，如果没有则使用默认图片
                    preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches);
                    $thumbnail = !empty($matches[1]) ? $matches[1] : esc_url(get_stylesheet_directory_uri() . '/widgets/img/default.jpg');
                ?>
                    <div class="recent-post-item">
                        <div class="post_cover right_radius">
                            <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                                <span class="recent-post-top-text">荐</span>
                                <img class="post_bg" src="<?php echo esc_url($thumbnail); ?>">
                            </a>
                        </div>
                        <div class="recent-post-info">
                            <a class="article-title" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                                <?php echo esc_html($title); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php
            return ob_get_clean();
        }

        // 渲染小部件在前端页面显示的内容
        public function widget($args, $instance)
        {
            $post_ids = !empty($instance['post_ids']) ? $instance['post_ids'] : '';
            $title_1 = !empty($instance['title_1']) ? $instance['title_1'] : '分享设计';
            $title_2 = !empty($instance['title_2']) ? $instance['title_2'] : '与科技生活';
            $title_3 = !empty($instance['title_3']) ? $instance['title_3'] : '产品、交互、设计、开发';
            $link_1_text = !empty($instance['link_1_text']) ? $instance['link_1_text'] : '运维';
            $link_1_url = !empty($instance['link_1_url']) ? $instance['link_1_url'] : '/network';
            $link_2_text = !empty($instance['link_2_text']) ? $instance['link_2_text'] : '技术';
            $link_2_url = !empty($instance['link_2_url']) ? $instance['link_2_url'] : '/tech';
            $today_card_tips = !empty($instance['today_card_tips']) ? $instance['today_card_tips'] : '新功能';
            $today_card_title = !empty($instance['today_card_title']) ? $instance['today_card_title'] : '热爱可抵漫长岁月';
            $today_card_cover_url = !empty($instance['today_card_cover_url']) ? $instance['today_card_cover_url'] : get_stylesheet_directory_uri() . '/widgets/img/O1CN01xXWU4f1QbIiiLjltL_!!2210123621994.jpg';
            $posts = $this->get_posts($post_ids);
        ?>
            <div class="homePage page" id="body-wrap">
                <div id="home_top">
                    <div class="recent-top-post-group" id="recent-top-post-group">
                        <div class="recent-post-top" id="recent-post-top">
                            <div id="home_top_iconsCard">
                                <div id="home_top_iconsCard_content">
                                    <div class="tags-group-all">
                                        <div class="tags-group-wrapper">
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#d0dbcf"><img
                                                        src="https://p.zhheo.com/8XZNzy22890281708008208742.png!cover"
                                                        title="StableDiffusion"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        data-ll-status="loading" class="entered"></div>
                                                <div class="tags-group-icon" style="background:#4aa181"><img
                                                        src="https://p.zhheo.com/fOjV3C21190281708007111463.png!cover"
                                                        title="ChatGPT"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        data-ll-status="loading" class="entered"></div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#A0E6CF"><img
                                                        src="https://p.zhheo.com/JXjDIW24290281708008342959.png!cover"
                                                        title="Lottie"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        data-ll-status="loading" class="entered"></div>
                                                <div class="tags-group-icon" style="background:#515151"><img
                                                        src="https://p.zhheo.com/HwKb2o22790281708008567704.png!cover"
                                                        title="Procreate"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        data-ll-status="loading" class="entered"></div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#989bf8"><img
                                                        src="https://p.zhheo.com/20239df3f66615b532ce571eac6d14ff21cf072602.png!cover"
                                                        title="AfterEffects"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        data-ll-status="loading" class="entered"></div>
                                                <div class="tags-group-icon" style="background:#ffffff"><img
                                                        src="https://p.zhheo.com/2023e0ded7b724a39f12d59c3dc8fbdc7cbe074202.png!cover"
                                                        title="Sketch"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        data-ll-status="loading" class="entered"></div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#57b6e6"><img title="Docker"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered"
                                                        src="https://p.zhheo.com/20231108a540b2862d26f8850172e4ea58ed075102.png!cover"
                                                        data-ll-status="loading"></div>
                                                <div class="tags-group-icon" style="background:#4082c3"><img title="Photoshop"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered"
                                                        src="https://p.zhheo.com/2023e4058a91608ea41751c4f102b131f267075902.png!cover"
                                                        data-ll-status="loading"></div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#ffffff"><img title="FinalCutPro"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered"
                                                        src="https://p.zhheo.com/20233e777652412247dd57fd9b48cf997c01070702.png!cover"
                                                        data-ll-status="loading"></div>
                                                <div class="tags-group-icon" style="background:#ffffff"><img title="Python"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered"
                                                        src="https://p.zhheo.com/20235c0731cd4c0c95fc136a8db961fdf963071502.png!cover"
                                                        data-ll-status="loading"></div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#eb6840"><img title="Swift"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered exited"
                                                        src="https://p.zhheo.com/202328bbee0b314297917b327df4a704db5c072402.png!cover">
                                                </div>
                                                <div class="tags-group-icon" style="background:#8f55ba"><img title="Principle"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered exited"
                                                        src="https://p.zhheo.com/2023f76570d2770c8e84801f7e107cd911b5073202.png!cover">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#f29e39"><img title="illustrator"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered exited"
                                                        src="https://p.zhheo.com/20237359d71b45ab77829cee5972e36f8c30073902.png!cover">
                                                </div>
                                                <div class="tags-group-icon" style="background:#2c51db"><img title="CSS3"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered exited"
                                                        src="https://p.zhheo.com/20237c548846044a20dad68a13c0f0e1502f074602.png!cover">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#f7cb4f"><img title="JS"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered exited"
                                                        src="https://p.zhheo.com/2023786e7fc488f453d5fb2be760c96185c0075502.png!cover">
                                                </div>
                                                <div class="tags-group-icon" style="background:#e9572b"><img title="HTML"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered exited"
                                                        src="https://p.zhheo.com/202372b4d760fd8a497d442140c295655426070302.png!cover">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#df5b40"><img title="Git"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                                        class="entered exited"
                                                        src="https://p.zhheo.com/2023ffa5707c4e25b6beb3e6a3d286ede4c6071102.png!cover">
                                                </div>
                                                <div class="tags-group-icon" style="background:#1f1f1f"><img
                                                        src="https://p.zhheo.com/20231ca53fa0b09a3ff1df89acd7515e9516173302.png!cover"
                                                        title="Rhino"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#d0dbcf"><img
                                                        src="https://p.zhheo.com/8XZNzy22890281708008208742.png!cover"
                                                        title="StableDiffusion"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                                <div class="tags-group-icon" style="background:#4aa181"><img
                                                        src="https://p.zhheo.com/fOjV3C21190281708007111463.png!cover"
                                                        title="ChatGPT"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#A0E6CF"><img
                                                        src="https://p.zhheo.com/JXjDIW24290281708008342959.png!cover"
                                                        title="Lottie"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                                <div class="tags-group-icon" style="background:#515151"><img
                                                        src="https://p.zhheo.com/HwKb2o22790281708008567704.png!cover"
                                                        title="Procreate"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#989bf8"><img
                                                        src="https://p.zhheo.com/20239df3f66615b532ce571eac6d14ff21cf072602.png!cover"
                                                        title="AfterEffects"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                                <div class="tags-group-icon" style="background:#ffffff"><img
                                                        src="https://p.zhheo.com/2023e0ded7b724a39f12d59c3dc8fbdc7cbe074202.png!cover"
                                                        title="Sketch"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#57b6e6"><img
                                                        src="https://p.zhheo.com/20231108a540b2862d26f8850172e4ea58ed075102.png!cover"
                                                        title="Docker"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                                <div class="tags-group-icon" style="background:#4082c3"><img
                                                        src="https://p.zhheo.com/2023e4058a91608ea41751c4f102b131f267075902.png!cover"
                                                        title="Photoshop"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#ffffff"><img
                                                        src="https://p.zhheo.com/20233e777652412247dd57fd9b48cf997c01070702.png!cover"
                                                        title="FinalCutPro"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                                <div class="tags-group-icon" style="background:#ffffff"><img
                                                        src="https://p.zhheo.com/20235c0731cd4c0c95fc136a8db961fdf963071502.png!cover"
                                                        title="Python"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#eb6840"><img
                                                        src="https://p.zhheo.com/202328bbee0b314297917b327df4a704db5c072402.png!cover"
                                                        title="Swift"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                                <div class="tags-group-icon" style="background:#8f55ba"><img
                                                        src="https://p.zhheo.com/2023f76570d2770c8e84801f7e107cd911b5073202.png!cover"
                                                        title="Principle"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#f29e39"><img
                                                        src="https://p.zhheo.com/20237359d71b45ab77829cee5972e36f8c30073902.png!cover"
                                                        title="illustrator"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                                <div class="tags-group-icon" style="background:#2c51db"><img
                                                        src="https://p.zhheo.com/20237c548846044a20dad68a13c0f0e1502f074602.png!cover"
                                                        title="CSS3"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#f7cb4f"><img
                                                        src="https://p.zhheo.com/2023786e7fc488f453d5fb2be760c96185c0075502.png!cover"
                                                        title="JS"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                                <div class="tags-group-icon" style="background:#e9572b"><img
                                                        src="https://p.zhheo.com/202372b4d760fd8a497d442140c295655426070302.png!cover"
                                                        title="HTML"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                            </div>
                                            <div class="tags-group-icon-pair">
                                                <div class="tags-group-icon" style="background:#df5b40"><img
                                                        src="https://p.zhheo.com/2023ffa5707c4e25b6beb3e6a3d286ede4c6071102.png!cover"
                                                        title="Git"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                                <div class="tags-group-icon" style="background:#1f1f1f"><img
                                                        src="https://p.zhheo.com/20231ca53fa0b09a3ff1df89acd7515e9516173302.png!cover"
                                                        title="Rhino"
                                                        onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="banners-content">
                                        <div class="banners-title">
                                            <div class="banners-title-big"><?php echo esc_html($title_1); ?></div>
                                            <div class="banners-title-big"><?php echo esc_html($title_2); ?></div>
                                            <div class="banners-title-small"><?php echo esc_html($title_3); ?></div>
                                        </div>
                                        <div class="banners-link">
                                            <a class="banners-link-btn blb-hot" href="<?php echo esc_url($link_1_url); ?>"><i
                                                    class="heoblogIcon icon-fire-fill"></i>
                                                <div class="banners-link-title"><?php echo esc_html($link_1_text); ?></div>
                                            </a>
                                            <a class="banners-link-btn blb-top" href="<?php echo esc_url($link_2_url); ?>"><i
                                                    class="heoblogIcon icon-star-smile-fill"></i>
                                                <div class="banners-link-title"><?php echo esc_html($link_2_text); ?></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="topGroup" id="topGroup">
                                <?php echo $this->render_cards($posts); ?>
                                <div class="todayCard" id="todayCard">
                                    <canvas id="bubble_canvas"
                                        style="position:absolute; bottom:0; height:200px;"></canvas>
                                    <script src="<?php echo get_stylesheet_directory_uri() . "/widgets/js/bubble.js" ?>"></script>
                                    <div class="todayCard-info">
                                        <div class="todayCard-tips"><?php echo esc_html($today_card_tips); ?></div>
                                        <div class="todayCard-title"><?php echo esc_html($today_card_title); ?></div>
                                    </div>
                                    <div class="todayCard-cover"
                                        style="background: url(<?php echo esc_url($today_card_cover_url); ?>) no-repeat center /cover">
                                    </div>
                                    <div class="banner-button-group">
                                        <a class="banner-button" id="bannerButton"><i
                                                class="heoblogIcon icon-add-circle-fill"></i><span
                                                class="banner-button-text">更多文章</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const bannerButton = document.getElementById('bannerButton');
                    const todayCard = document.getElementById('todayCard');
                    const topGroup = document.getElementById('topGroup');
                    bannerButton.addEventListener('click', function(event) {
                        event.preventDefault();
                        if (todayCard.style.opacity === '0') {
                            todayCard.style.opacity = '1';
                            todayCard.style.visibility = 'visible';
                            todayCard.classList.remove('zoom-out');
                        } else {
                            todayCard.style.opacity = '0';
                            todayCard.style.visibility = 'hidden';
                            todayCard.classList.add('zoom-out');
                        }
                    });
                    topGroup.addEventListener('mouseleave', function() {
                        todayCard.style.opacity = '1';
                        todayCard.style.visibility = 'visible';
                        todayCard.classList.remove('zoom-out');
                    });
                });
            </script>
<?php
        }
    }
    // 注册小部件
    add_action('widgets_init', function () {
        register_widget('Homepage_Banner_Widget');
    });

