<?php
    add_action('widgets_init', 'tengfei_tran_stats_widget');
    function tengfei_tran_stats_widget()
    {
        register_widget('tengfei_tran_stats_widget');
    }

    class tengfei_tran_stats_widget extends WP_Widget
    {
        // 存储统计数据
        private $stats = array();

        function __construct()
        {
            parent::__construct(
                'custom_stats_cards',
                __('ZibTF 横向数据统计卡片', 'custom'),
                array('description' => __('显示网站统计数据的卡片组件', 'custom'))
            );
            // 初始化统计数据
            $this->init_stats();
        }

        // 初始化统计数据
        private function init_stats()
        {
            global $wpdb;

            // 获取保存的建站时间，如果没有设置则使用默认值
            $start_date = get_option('custom_stats_start_date', '2024-04-29');

            // 检查日期格式是否有效
            if ($this->is_valid_date($start_date)) {
                // 用户总数
                $users = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
                // 文章总数
                $count_posts = wp_count_posts();
                $published_posts = $count_posts->publish;
                // 运营天数 - 使用用户设置的日期
                $wdyx_time = floor((time() - strtotime($start_date)) / 86400);
                // 今日文章数
                $today = getdate();
                $query = new WP_Query('year=' . $today["year"] . '&monthnum=' . $today["mon"] . '&day=' . $today["mday"]);
                $posts_24h = $query->found_posts;
                // 访问统计
                $count = 0;
                $views = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key='views'");
                foreach ($views as $key => $value) {
                    $meta_value = $value->meta_value;
                    if ($meta_value != ' ') {
                        $count += (int)$meta_value;
                    }
                }
                // 格式化访问数
                if ($count >= 100000) {
                    $formatted_count = round($count / 10000, 1) . 'w';
                } else {
                    $formatted_count = $count;
                }
                $this->stats = array(
                    'users' => $users,
                    'posts' => $published_posts,
                    'days' => $wdyx_time,
                    'today_posts' => $posts_24h,
                    'views' => $formatted_count
                );
            } else {
                // 日期格式错误处理
                error_log("Invalid start date format: " . $start_date);
            }
        }

        // 检查日期格式是否有效
        private function is_valid_date($date)
        {
            $d = DateTime::createFromFormat('Y-m-d', $date);
            return $d && $d->format('Y-m-d') === $date;
        }

        public function widget($args, $instance)
        {
            // 引入 CSS
            wp_enqueue_style('tengfei_tran_stats_styles', get_stylesheet_directory_uri() . '/widgets/css/tengfei_tran.css');
            // 输出时钟 JS
            echo '<script>
            var mytime = setInterval(function () {
                getTime();
            }, 1000);
            function getTime() {
                var d = new Date();
                var t = d.toLocaleTimeString();
                document.getElementById("ptime").innerHTML = t;
            }
        </script>';
            // 定义默认文本
            $default_texts = array(
                '会员总数',
                '资源总量',
                '运营天数',
                '今日发布',
                '访问人数',
                '系统时间'
            );
            // 定义卡片配置
            $cards = array(
                array('class' => 'oil', 'value' => $this->stats['users'], 'unit' => '人'),
                array('class' => 'tree', 'value' => $this->stats['posts'], 'unit' => '个'),
                array('class' => 'water', 'value' => $this->stats['days'], 'unit' => '天'),
                array('class' => 'oil1', 'value' => $this->stats['today_posts'], 'unit' => '篇'),
                array('class' => 'tree2', 'value' => $this->stats['views'], 'unit' => ''),
                array('class' => 'water3', 'value' => '', 'unit' => '')
            );
            echo '<section class="cards pcbdmapss">';
            for ($i = 1; $i <= 6; $i++) {
                $icon = !empty($instance['icon_' . $i]) ? $instance['icon_' . $i] : get_stylesheet_directory_uri() . '/widgets/img/pic/' . $i . '.png';
                $text = !empty($instance['text_' . $i]) ? $instance['text_' . $i] : $default_texts[$i - 1];
                $card = $cards[$i - 1];
                echo '<div class="cardhu card--' . $card['class'] . '">
                <div class="card__svg-container">
                    <div class="card__svg-wrapper">';
                if ($i == 6) {
                    echo '<img style="animation: 10s linear 0s normal none infinite running fa-spin;" src="' . esc_url($icon) . '">';
                } else {
                    echo '<img src="' . esc_url($icon) . '">';
                }
                echo '</div>
                </div>
                <div class="card__count-container">
                    <div class="card__count-text">
                        <span class="card__count-text--big">';
                if ($i == 6) {
                    echo '<p id="ptime"></p>';
                } else {
                    echo '<strong>' . ($i == 5 ? '+' : '') . $card['value'] . '</strong>';
                    if ($card['unit']) {
                        echo '<span class="unit">' . $card['unit'] . '</span>';
                    }
                }
                echo '</span>
                    </div>
                </div>
                <div class="card__stuff-container">
                    <div class="card__stuff-text">' . esc_html($text) . '</div>
                </div>
            </div>';
            }
            echo '</section>';
        }

        public function form($instance)
        {
            $default_texts = array('会员总数', '资源总量', '运营天数', '今日发布', '访问人数', '系统时间');
            // 显示输入框，允许用户输入日期
            $start_date = get_option('custom_stats_start_date', '2024-04-29');
?>
            <p>
                <label for="<?php echo $this->get_field_id('start_date'); ?>"><?php _e('建站日期:', 'custom'); ?></label>
                <input class="widefat" type="text"
                    id="<?php echo $this->get_field_id('start_date'); ?>"
                    name="<?php echo $this->get_field_name('start_date'); ?>"
                    value="<?php echo esc_attr($start_date); ?>">
            </p>
            <hr style="margin: 15px 0;">
            <?php
            // 原有的图标和文本设置
            for ($i = 1; $i <= 6; $i++) {
                $icon = !empty($instance['icon_' . $i]) ? $instance['icon_' . $i] : get_stylesheet_directory_uri() . '/widgets/img/pic/' . $i . '.png';
                $text = !empty($instance['text_' . $i]) ? $instance['text_' . $i] : $default_texts[$i - 1];
            ?>
                <p>
                    <label for="<?php echo $this->get_field_id('icon_' . $i); ?>"><?php echo sprintf(__('卡片 %d 图标 URL:', 'custom'), $i); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('icon_' . $i); ?>"
                        name="<?php echo $this->get_field_name('icon_' . $i); ?>" type="text"
                        value="<?php echo esc_attr($icon); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('text_' . $i); ?>"><?php echo sprintf(__('卡片 %d 文本:', 'custom'), $i); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('text_' . $i); ?>"
                        name="<?php echo $this->get_field_name('text_' . $i); ?>" type="text"
                        value="<?php echo esc_attr($text); ?>">
                </p>
<?php
            }
        }

        public function update($new_instance, $old_instance)
        {
            // 保存用户输入的日期
            $start_date = !empty($new_instance['start_date']) ? $new_instance['start_date'] : '2024-04-29';
            // 详细日志记录
            error_log("Updating start_date: " . $start_date);
            update_option('custom_stats_start_date', strip_tags($start_date));
            // 保存其他设置
            $instance = array();
            for ($i = 1; $i <= 6; $i++) {
                $instance['icon_' . $i] = !empty($new_instance['icon_' . $i]) ? strip_tags($new_instance['icon_' . $i]) : '';
                $instance['text_' . $i] = !empty($new_instance['text_' . $i]) ? strip_tags($new_instance['text_' . $i]) : '';
            }
            return $instance;
        }
    }
?>