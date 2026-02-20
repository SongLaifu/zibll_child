<?php
    add_action('widgets_init', 'register_tengfei_messcard_widget');

    function register_tengfei_messcard_widget()
    {
        register_widget('tengfei_messcard_Widget');
    }

    class tengfei_messcard_Widget extends WP_Widget
    {

        function __construct()
        {
            parent::__construct(
                'tengfei_messcard_widget',
                __('ZibTF 侧边信息卡片', 'text_domain'),
                array('description' => __('显示动态信息卡片，包含图片、描述和社交图标。', 'text_domain'))
            );
        }

        public function widget($args, $instance)
        {
            $qq_number = !empty($instance['qq_number']) ? $instance['qq_number'] : '';
            $avatar_url = !empty($instance['avatar_url']) ? $instance['avatar_url'] : get_stylesheet_directory_uri() . '/widgets/img/O1CN01A0q4xe1QbIjy5orab_!!2210123621994.png';
            $hidden_text = !empty($instance['hidden_text']) ? $instance['hidden_text'] : '默认隐藏文本';
            $info_title = !empty($instance['info_title']) ? $instance['info_title'] : '默认标题';
            $info_description = !empty($instance['info_description']) ? $instance['info_description'] : '默认描述';
            $popup_image = !empty($instance['popup_image']) ? $instance['popup_image'] : get_stylesheet_directory_uri() . '/widgets/img/65e935c4599c5.png';
            $custom_messages = !empty($instance['custom_messages']) ? $instance['custom_messages'] : '🔍 分享与热心帮助, 💢 壮汉人狠话不多, 🤝 专修交互与设计, 🏃 脚踏实地行动派, 🏠 智能家居小能手, 🔨 设计开发一条龙, 🧱 团队小组发动机, 🤖️ 数码科技爱好者';

            // 生成 QQ 链接
            $qq_link = !empty($qq_number) ? 'http://wpa.qq.com/msgrd?v=3&uin=' . esc_attr($qq_number) . '&site=qq&menu=yes' : '';

            // 直接输出小工具的HTML，不包裹额外的div
?>
            <style>
                .wniui_card {
                    position: relative;
                    width: 100%;
                    height: 300px;
                    background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
                    background-image: -webkit-linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
                    border-radius: 15px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    overflow: hidden;
                    cursor: pointer;
                    user-select: none
                }

                .wniui_cont {
                    position: absolute;
                    top: 20px;
                    width: 70%;
                    height: 30px;
                    background-color: rgba(255, 255, 255, .3);
                    text-align: center;
                    border-radius: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: background-color 0.2s ease, transform 0.2s ease;
                    z-index: 2;
                    color: #777777
                }

                .wniui_cont:hover {
                    background-color: rgba(255, 255, 255, .8);
                    transform: scale(1.05);
                    color: #333
                }

                .wniui_avatar {
                    position: absolute;
                    top: 150px;
                    left: 50%;
                    transform: translate(-50%, -50%) scale(1);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: transform 0.3s ease;
                    z-index: 1
                }

                .wniui_avatar img {
                    border: 5px #fff solid;
                    box-sizing: content-box;
                    width: 100%;
                    width: 70%;
                    border-radius: 50%;
                    transition: opacity 0.3s ease
                }

                .wniui_card:hover .wniui_avatar {
                    transform: translate(-50%, calc(-50% + 100px)) scale(0.7)
                }

                .wniui_card:hover .wniui_avatar img {
                    opacity: 0
                }

                .hidden_text {
                    position: absolute;
                    top: 150px;
                    left: 50%;
                    width: 80%;
                    font-size: 18px;
                    transform: translate(-50%, -50%);
                    display: flex;
                    justify-content: center;
                    color: #fff;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                    z-index: 2
                }

                .wniui_card:hover .hidden_text {
                    opacity: 1
                }

                .wniui_infor {
                    position: absolute;
                    left: 20px;
                    bottom: 0;
                    width: 100%;
                    color: #ffffff;
                    font-size: 15px;
                    z-index: 2
                }

                .wniui_infor span {
                    font-size: 18px;
                    font-weight: 550
                }

                .wniui_infor_qq,
                .wniui_infor_wx {
                    position: absolute;
                    z-index: 2;
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    bottom: 10px;
                    background-color: rgba(255, 255, 255, .3);
                    transition: transform 0.2s ease, background-color 0.2s ease
                }

                .wniui_infor_qq .icon,
                .wniui_infor_wx .icon {
                    color: #fff;
                    width: 100%;
                    font-size: 25px;
                    text-align: center;
                    margin: 8px 0;
                    transition: color 0.2s ease
                }

                .wniui_infor_qq:hover,
                .wniui_infor_wx:hover {
                    transform: scale(1.1);
                    background-color: rgba(255, 255, 255, 0.8)
                }

                .wniui_infor_qq:hover .icon,
                .wniui_infor_wx:hover .icon {
                    color: #333
                }

                .wniui_infor_qq {
                    right: 20px
                }

                .wniui_infor_wx {
                    right: 70px
                }

                /* 隐藏图片容器 */
                .popup_image {
                    display: none;
                    position: absolute;
                    bottom: 60px;
                    /* 调整弹出图片的位置 */
                    right: 70px;
                    z-index: 3;
                    width: 200px;
                    height: 200px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                }

                /* 悬停时显示图片 */
                .wniui_infor_wx:hover+.popup_image {
                    display: block;
                }
            </style>

            <div class="wniui_card" style="margin-bottom: 20px;">
                <div class="wniui_cont"><span>生活明朗 万物可爱</span></div>
                <div class="wniui_avatar"><img src="<?php echo esc_url($avatar_url); ?>" alt="avatar"></div>
                <div class="hidden_text">
                    <span><?php echo esc_html($hidden_text); ?></span>
                </div>
                <div class="wniui_infor"><span><?php echo esc_html($info_title); ?></span>
                    <p><?php echo esc_html($info_description); ?></p>
                </div>
                <div class="wniui_infor_qq">
                    <a href="<?php echo esc_url($qq_link); ?>" target="_blank" rel="noopener noreferrer">
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#icon-d-qq"></use>
                        </svg>
                    </a>
                </div>
                <div class="wniui_infor_wx">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-d-wechat"></use>
                    </svg>
                </div>
                <div class="popup_image">
                    <img src="<?php echo esc_url($popup_image); ?>" alt="WeChat QR Code" style="width: 100%; height: 100%; border-radius: 10px;">
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const contElement = document.querySelector('.wniui_cont');
                    const messages = "<?php echo esc_js($custom_messages); ?>".split(',').map(msg => msg.trim());
                    let currentIndex = 0;

                    contElement.addEventListener('click', function() {
                        currentIndex = (currentIndex + 1) % messages.length;
                        contElement.querySelector('span').textContent = messages[currentIndex];
                    });
                });
            </script>

        <?php
            // 不输出额外的 div 标签
        }

        public function form($instance)
        {
            $qq_number = !empty($instance['qq_number']) ? $instance['qq_number'] : '';
            $avatar_url = !empty($instance['avatar_url']) ? $instance['avatar_url'] : get_stylesheet_directory_uri() . '/widgets/img/O1CN01A0q4xe1QbIjy5orab_!!2210123621994.png';
            $hidden_text = !empty($instance['hidden_text']) ? $instance['hidden_text'] : '默认隐藏文本';
            $info_title = !empty($instance['info_title']) ? $instance['info_title'] : '默认标题';
            $info_description = !empty($instance['info_description']) ? $instance['info_description'] : '默认描述';
            $popup_image = !empty($instance['popup_image']) ? $instance['popup_image'] : get_stylesheet_directory_uri() . '/widgets/img/65e935c4599c5.png';
            $custom_messages = !empty($instance['custom_messages']) ? $instance['custom_messages'] : '🔍 分享与热心帮助, 💢 壮汉人狠话不多, 🤝 专修交互与设计, 🏃 脚踏实地行动派, 🏠 智能家居小能手, 🔨 设计开发一条龙,🧱 团队小组发动机, 🤖️ 数码科技爱好者';
        ?>

            <p>
                <label for="<?php echo $this->get_field_id('qq_number'); ?>"><?php _e('QQ 号码:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('qq_number'); ?>" name="<?php echo $this->get_field_name('qq_number'); ?>" type="text" value="<?php echo esc_attr($qq_number); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('avatar_url'); ?>"><?php _e('头像链接:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('avatar_url'); ?>" name="<?php echo $this->get_field_name('avatar_url'); ?>" type="text" value="<?php echo esc_attr($avatar_url); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('hidden_text'); ?>"><?php _e('隐藏文本:'); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('hidden_text'); ?>" name="<?php echo $this->get_field_name('hidden_text'); ?>"><?php echo esc_textarea($hidden_text); ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('info_title'); ?>"><?php _e('左下标题:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('info_title'); ?>" name="<?php echo $this->get_field_name('info_title'); ?>" type="text" value="<?php echo esc_attr($info_title); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('info_description'); ?>"><?php _e('左下描述:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('info_description'); ?>" name="<?php echo $this->get_field_name('info_description'); ?>" type="text" value="<?php echo esc_attr($info_description); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('popup_image'); ?>"><?php _e('弹出图片链接:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('popup_image'); ?>" name="<?php echo $this->get_field_name('popup_image'); ?>" type="text" value="<?php echo esc_attr($popup_image); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('custom_messages'); ?>"><?php _e('自定义消息（以 , 分割）'); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('custom_messages'); ?>" name="<?php echo $this->get_field_name('custom_messages'); ?>"><?php echo esc_textarea($custom_messages); ?></textarea>
            </p>

<?php
        }

        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['qq_number'] = (!empty($new_instance['qq_number'])) ? strip_tags($new_instance['qq_number']) : '';
            $instance['avatar_url'] = (!empty($new_instance['avatar_url'])) ? strip_tags($new_instance['avatar_url']) : get_stylesheet_directory_uri() . '/widgets/img/O1CN01A0q4xe1QbIjy5orab_!!2210123621994.png';
            $instance['hidden_text'] = (!empty($new_instance['hidden_text'])) ? strip_tags($new_instance['hidden_text']) : '';
            $instance['info_title'] = (!empty($new_instance['info_title'])) ? strip_tags($new_instance['info_title']) : '默认标题';
            $instance['info_description'] = (!empty($new_instance['info_description'])) ? strip_tags($new_instance['info_description']) : '默认描述';
            $instance['popup_image'] = (!empty($new_instance['popup_image'])) ? strip_tags($new_instance['popup_image']) : get_stylesheet_directory_uri() . '/widgets/img/65e935c4599c5.png';
            $instance['custom_messages'] = (!empty($new_instance['custom_messages'])) ? strip_tags($new_instance['custom_messages']) : '🔍 分享与热心帮助, 💢 壮汉人狠话不多, 🤝 专修交互与设计, 🏃 脚踏实地行动派, 🏠 智能家居小能手, 🔨 设计开发一条龙, 🧱 团队小组发动机, 🤖️ 数码科技爱好者';

            return $instance;
        }
    }

?>