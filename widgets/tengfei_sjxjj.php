<?php
    add_action('widgets_init', 'register_random_girl_widget');

    function register_random_girl_widget()
    {
        register_widget('Random_Girl_Widget');
    }

    class Random_Girl_Widget extends WP_Widget
    {

        function __construct()
        {
            parent::__construct(
                'random_girl_widget',
                __('ZibTF 随机小姐姐', 'text_domain'),
                array('description' => __('显示随机小姐姐视频的小工具', 'text_domain'),)
            );
        }

        public function widget($args, $instance)
        {
            if (!empty($instance['hide_box'])) {
                $args['before_widget'] = '<div style="margin-bottom:20px;">';
                $args['after_widget'] = '</div>';
            }

            echo $args['before_widget'];
            $api_url = !empty($instance['api_url']) ? $instance['api_url'] : 'https://api.yujn.cn/api/zzxjj.php?type=video'; // 视频接口
?>
            <section id="xiaojiejie">
                <div class="xiaojiejie">
                    <style>
                        #player {
                            margin: 1px auto;
                            max-width: 100%;
                            border-radius: 10px;
                            display: block;
                        }

                        #xjjsp {
                            display: none;
                        }

                        #ckxjj,
                        #gbxjj {
                            width: 100%;
                            height: 40px;
                            border: none;
                            background-color: #409eff;
                            color: #fff;
                            margin-top: 1px;
                            border-radius: 5px;
                            font-size: 18px;
                            cursor: pointer;
                            transition: 0.2s;
                        }

                        #ckxjj:hover,
                        #gbxjj:hover {
                            background-color: #9fbfee;
                        }

                        .kzsp {
                            width: 100%;
                            display: flex;
                            justify-content: space-between;
                        }

                        .kzsp>button {
                            border: none;
                            height: 40px;
                            padding: 0 30px;
                            font-size: 16px;
                            background-color: #409eff;
                            border-radius: 10px;
                            color: #fff;
                            transition: 0.3s;
                            cursor: pointer;
                        }

                        .kzsp>button:active {
                            background-color: #e25a00;
                        }
                    </style>
                    <button type="button" id="ckxjj">点我看小姐姐视频</button>
                    <div id="xjjsp">
                        <video id="player" src="<?php echo esc_url($api_url); ?>" controls="" alt="小姐姐视频"></video>
                        <div class="kzsp">
                            <button id="switch">连续: 开</button>
                            <button id="next">下一个</button>
                        </div>
                        <button type="button" id="gbxjj">关闭视频</button>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var ckxjj = document.getElementById('ckxjj');
                            var xjjsp = document.getElementById('xjjsp');
                            var gbxjj = document.getElementById('gbxjj');
                            var player = document.getElementById('player');
                            var switchBtn = document.getElementById('switch');
                            var nextBtn = document.getElementById('next');
                            var isContinuous = true;

                            ckxjj.addEventListener('click', function() {
                                ckxjj.style.display = 'none';
                                xjjsp.style.display = 'block';
                                player.play();
                            });

                            gbxjj.addEventListener('click', function() {
                                xjjsp.style.display = 'none';
                                ckxjj.style.display = 'block';
                                player.pause();
                            });

                            switchBtn.addEventListener('click', function() {
                                isContinuous = !isContinuous;
                                switchBtn.textContent = '连续: ' + (isContinuous ? '开' : '关');
                            });

                            nextBtn.addEventListener('click', function() {
                                player.src = '<?php echo esc_url($api_url); ?>';
                                player.play();
                            });

                            player.addEventListener('ended', function() {
                                if (isContinuous) {
                                    player.src = '<?php echo esc_url($api_url); ?>';
                                    player.play();
                                }
                            });
                        });
                    </script>

                </div>
            </section>
        <?php
            echo $args['after_widget'];
        }

        public function form($instance)
        {
            $api_url = !empty($instance['api_url']) ? $instance['api_url'] : 'https://api.yujn.cn/api/zzxjj.php?type=video'; // 视频接口
            $hide_box = !empty($instance['hide_box']) ? '1' : '0';
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('api_url'); ?>">API 链接:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('api_url'); ?>" name="<?php echo $this->get_field_name('api_url'); ?>" type="text" value="<?php echo esc_attr($api_url); ?>">
            </p>
            <p>
                <input class="checkbox" type="checkbox" <?php checked($hide_box, '1'); ?> id="<?php echo $this->get_field_id('hide_box'); ?>" name="<?php echo $this->get_field_name('hide_box'); ?>" />
                <label for="<?php echo $this->get_field_id('hide_box'); ?>">隐藏背景盒子并保留空白边距</label>
            </p>
<?php
        }

        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['api_url'] = (!empty($new_instance['api_url'])) ? strip_tags($new_instance['api_url']) : '';
            $instance['hide_box'] = !empty($new_instance['hide_box']) ? '1' : '0';
            return $instance;
        }
    }

