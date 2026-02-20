<?php
    class TFBK_Site_Stat_Widget extends WP_Widget
    {
        public function __construct()
        {
            parent::__construct(
                'tfbk_site_stat_widget',
                'ZibTF-虚拟浮动在线统计小工具',
                array('description' => '自然浮动在线统计小工具')
            );
            add_action('wp_ajax_nopriv_tfbk_site_stat', [$this, 'ajax_data']);
            add_action('wp_ajax_tfbk_site_stat',      [$this, 'ajax_data']);
        }

        public function widget($args, $instance)
        {
            $this->refresh_active_status();

            $welcome = !empty($instance['welcome']) ? $instance['welcome'] : '';
            $user_add    = isset($instance['online_users_add'])   ? intval($instance['online_users_add']) : '';
            $guest_base  = isset($instance['online_guests_base']) ? intval($instance['online_guests_base']) : 0;
            $guest_float = isset($instance['online_guests_float']) ? intval($instance['online_guests_float']) : 5;
            $reg_user    = isset($instance['reg_user']) ? intval($instance['reg_user']) : '';
            $ajax_data = [
                'online_users_add'   => $user_add,
                'online_guests_base' => $guest_base,
                'guest_float'        => $guest_float,
                'reg_user'           => $reg_user,
            ];
?>
            <div class="zib-widget widget_online_users_widget">
                <!-- <h3>网站数据统计</h3> -->
                <div class="online-users-container online-users-widget modern-card-style"
                    id="tfbk-site-stat" data-config='<?php echo esc_attr(json_encode($ajax_data)); ?>'>
                    <h3><?php echo esc_html($welcome); ?></h3>
                    <div class="tfbk-info-wg-main">
                        <div class="tfbk-info-item">
                            <span class="tfbk-i-num" id="online-users-count">--</span>
                            <span class="frame-bg">在线用户</span>
                        </div>
                        <div class="tfbk-info-item">
                            <span class="tfbk-i-num" id="online-guests-count">--</span>
                            <span class="frame-bg">在线游客</span>
                        </div>
                        <div class="tfbk-info-item">
                            <span class="tfbk-i-num" id="total-online-count">--</span>
                            <span class="frame-bg">总在线</span>
                        </div>
                        <div class="tfbk-info-item stat-item">
                            <span class="tfbk-i-num" id="post-count"><?php echo wp_count_posts('post')->publish; ?></span>
                            <span class="frame-bg">文章总数</span>
                        </div>
                        <div class="tfbk-info-item stat-item">
                            <span class="tfbk-i-num" id="run-days"><?php echo $this->get_run_days(); ?></span>
                            <span class="frame-bg">运行时间</span>
                        </div>
                        <div class="tfbk-info-item stat-item">
                            <span class="tfbk-i-num" id="user-count">--</span>
                            <span class="frame-bg">注册用户</span>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                <?php echo $this->style_css(); ?>
            </style>
            <script>
                function animateNum(id, target) {
                    var elem = document.getElementById(id);
                    if (!elem) return;
                    var currentText = elem.innerText.replace(/,/g, '');
                    var current = parseInt(currentText, 10);
                    if (isNaN(current) || elem.innerText == '--') current = 0;
                    target = Number(target);

                    if (current === target) {
                        elem.innerText = target;
                        return;
                    }

                    var fps = 60,
                        duration = 600,
                        totalFrames = Math.round(fps * (duration / 1000)),
                        easeOutQuad = function(t) {
                            return t * (2 - t);
                        },
                        start = current,
                        diff = target - current,
                        frame = 0;

                    function animate() {
                        frame++;
                        var progress = frame / totalFrames;
                        var value = Math.round(start + diff * easeOutQuad(progress));
                        elem.innerText = value;
                        if (frame < totalFrames) {
                            requestAnimationFrame(animate);
                        } else {
                            elem.innerText = target;
                        }
                    }
                    animate();
                }

                document.addEventListener("DOMContentLoaded", function() {
                    var form = document.getElementById('tfbk-site-stat');
                    if (!form) return;
                    var config = JSON.parse(form.getAttribute('data-config') || '{}');
                    var state = {
                        online_users: 0,
                        online_guests_base: 0,
                        guests_float: Number(config.guest_float || 5),
                        user_count: 0,
                        total_online: 0,
                        online_guests_show: 0
                    };

                    function setNextFloat() {
                        var interval = 3000 + Math.random() * 4000;
                        setTimeout(function() {
                            var change = [-1, 0, 1][Math.floor(Math.random() * 3)];
                            var base = state.online_guests_base;
                            var min = Math.max(0, base - state.guests_float);
                            var max = base + state.guests_float;
                            var now = typeof state.online_guests_show === 'number' ? state.online_guests_show : base;
                            var val = now + change;
                            if (val < min) val = min;
                            if (val > max) val = max;
                            state.online_guests_show = val;
                            animateNum('online-guests-count', val);
                            animateNum('total-online-count', state.online_users + val);
                            setNextFloat();
                        }, interval);
                    }

                    function updateReal() {
                        var payload = Object.assign({}, config, {
                            action: 'tfbk_site_stat'
                        });
                        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: Object.keys(payload).map(k => encodeURIComponent(k) + '=' + encodeURIComponent(payload[k])).join('&')
                            })
                            .then(resp => resp.json())
                            .then(function(r) {
                                if (!r) return;
                                state.online_users = Number(r.online_users);
                                state.online_guests_base = Number(r.online_guests);
                                state.user_count = Number(r.user_count);
                                animateNum('online-users-count', state.online_users);
                                animateNum('user-count', state.user_count);
                                state.online_guests_show = state.online_guests_base;
                                animateNum('online-guests-count', state.online_guests_show);
                                animateNum('total-online-count', state.online_users + state.online_guests_show);
                            });
                    }
                    animateNum('post-count', <?php echo wp_count_posts('post')->publish; ?>);
                    animateNum('run-days', <?php echo $this->get_run_days(); ?>);

                    updateReal();
                    setNextFloat();
                    setInterval(updateReal, 30000);
                });
            </script>
        <?php
        }

        public function form($instance)
        {
            $welcome = !empty($instance['welcome']) ? $instance['welcome'] : '';
            $online_users_add   = isset($instance['online_users_add']) ? intval($instance['online_users_add']) : '';
            $online_guests_base = isset($instance['online_guests_base']) ? intval($instance['online_guests_base']) : 0;
            $online_guests_float = isset($instance['online_guests_float']) ? intval($instance['online_guests_float']) : 5;
            $reg_user           = isset($instance['reg_user']) ? intval($instance['reg_user']) : '';
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('welcome'); ?>">欢迎语：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('welcome'); ?>"
                    name="<?php echo $this->get_field_name('welcome'); ?>" type="text"
                    value="<?php echo esc_attr($welcome); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('online_users_add'); ?>">在线用户加数：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('online_users_add'); ?>"
                    name="<?php echo $this->get_field_name('online_users_add'); ?>" type="number"
                    value="<?php echo esc_attr($online_users_add); ?>" />
                <small>你可以设置一个额外增加的人数，统计结果=实际在线用户数+你设置的数字。不填写就是显示实际在线用户。</small>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('online_guests_base'); ?>">在线游客基数：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('online_guests_base'); ?>"
                    name="<?php echo $this->get_field_name('online_guests_base'); ?>" type="number"
                    value="<?php echo esc_attr($online_guests_base); ?>" />
                <small>你可以为游客人数额外增加一个基础数值，统计结果=实际游客数+你设置的基数。不填写就是实际游客人数。</small>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('online_guests_float'); ?>">游客浮动幅度：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('online_guests_float'); ?>"
                    name="<?php echo $this->get_field_name('online_guests_float'); ?>" type="number"
                    value="<?php echo esc_attr($online_guests_float); ?>" />
                <small>页面上的游客人数会在基数+-这个数字的范围内小幅浮动，腾飞建议填写3~10。</small>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('reg_user'); ?>">注册用户（自定义，留空为真实）：</label>
                <input class="widefat" id="<?php echo $this->get_field_id('reg_user'); ?>"
                    name="<?php echo $this->get_field_name('reg_user'); ?>" type="number"
                    value="<?php echo esc_attr($reg_user); ?>" />
            </p>
<?php
        }

        public function update($new_instance, $old_instance)
        {
            $instance = [];
            $instance['welcome'] = sanitize_text_field($new_instance['welcome']);
            $instance['online_users_add'] = ($new_instance['online_users_add'] !== '' && is_numeric($new_instance['online_users_add'])) ? intval($new_instance['online_users_add']) : '';
            $instance['online_guests_base'] = ($new_instance['online_guests_base'] !== '' && is_numeric($new_instance['online_guests_base'])) ? intval($new_instance['online_guests_base']) : 0;
            $instance['online_guests_float'] = ($new_instance['online_guests_float'] !== '' && is_numeric($new_instance['online_guests_float'])) ? intval($new_instance['online_guests_float']) : 5;
            $instance['reg_user']           = ($new_instance['reg_user'] !== '' && is_numeric($new_instance['reg_user'])) ? intval($new_instance['reg_user']) : '';
            return $instance;
        }

        private function refresh_active_status()
        {
            $option_name = 'tfbk_online_user_ids';
            $timeout = 15 * 60;
            $now = time();

            $current_user_id = get_current_user_id();
            $users = get_transient($option_name);
            if (!is_array($users)) $users = array();
            if ($current_user_id) {
                $users[$current_user_id] = $now;
            }
            foreach ($users as $uid => $timestamp) {
                if ($now - $timestamp > $timeout) unset($users[$uid]);
            }
            set_transient($option_name, $users, $timeout);

            if (!session_id()) {
                if (headers_sent() == false) @session_start();
            }
            $transient_key = 'tfbk_online_guests_ids';
            $sess_id = isset($_COOKIE[session_name()]) ? $_COOKIE[session_name()] : session_id();
            $guests = get_transient($transient_key);
            if (!is_array($guests)) $guests = array();
            if (!is_user_logged_in() && $sess_id) {
                $guests[$sess_id] = $now;
            }
            foreach ($guests as $sid => $timestamp) {
                if ($now - $timestamp > $timeout) unset($guests[$sid]);
            }
            set_transient($transient_key, $guests, $timeout);
        }

        public function ajax_data()
        {
            $this->refresh_active_status();
            header('Content-Type: application/json; charset=utf-8');
            $user_add   = isset($_POST['online_users_add']) ? intval($_POST['online_users_add']) : '';
            $guest_base = isset($_POST['online_guests_base']) ? intval($_POST['online_guests_base']) : 0;
            $reg_user   = isset($_POST['reg_user']) ? intval($_POST['reg_user']) : '';

            $online_user_real  = $this->get_online_users();
            $online_guest_real = $this->get_online_guests();
            $online_users = $user_add !== '' ? ($online_user_real + $user_add) : $online_user_real;
            $online_users = max(0, $online_users);

            $online_guests = $online_guest_real + $guest_base;
            $online_guests = max(0, $online_guests);

            $user_count = $reg_user ? $reg_user : $this->get_user_count();
            $total_online = $online_users + $online_guests;

            echo json_encode([
                'online_users'  => intval($online_users),
                'online_guests' => intval($online_guests),
                'total_online'  => intval($total_online),
                'user_count'    => $user_count
            ]);
            exit;
        }

        private function get_online_users()
        {
            $option_name = 'tfbk_online_user_ids';
            $timeout = 15 * 60;
            $now = time();
            $users = get_transient($option_name);
            if (!is_array($users)) $users = [];
            foreach ($users as $uid => $timestamp) {
                if ($now - $timestamp > $timeout) unset($users[$uid]);
            }
            set_transient($option_name, $users, $timeout);
            return is_array($users) ? count($users) : 0;
        }
        private function get_online_guests()
        {
            if (!session_id()) if (headers_sent() == false) @session_start();
            $timeout = 15 * 60;
            $transient_key = 'tfbk_online_guests_ids';
            $now = time();
            $guests = get_transient($transient_key);
            if (!is_array($guests)) $guests = [];
            foreach ($guests as $sid => $timestamp) {
                if ($now - $timestamp > $timeout) unset($guests[$sid]);
            }
            set_transient($transient_key, $guests, $timeout);
            return is_array($guests) ? count($guests) : 0;
        }
        private function get_run_days()
        {
            $start_date = '2023-06-01';
            $seconds = time() - strtotime($start_date);
            return max(1, floor($seconds / (24 * 3600)));
        }
        private function get_user_count()
        {
            $user_count = count_users();
            return $user_count['total_users'];
        }
        private function style_css()
        {
            return <<<CSS
.online-users-container {
    color: #333333;
    padding: 20px;
    border-radius: 12px;
    margin-top: -40px;
    margin-bottom: -20px;
    margin-left: -20px;
    margin-right: -20px;
}
.online-users-container h3 {
    font-size: 18px;
    margin-bottom: 15px;
    color: var(--focus-color);
    text-align: center;
    font-weight: 600;
}
.tfbk-info-item {
    background-color: var(--main-border-color);
    border-radius: 8px;
    padding: 10px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    flex: 1 1 calc(20% - 10px);
    min-width: 100px;
}
.tfbk-info-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.tfbk-info-wg-main {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 10px;
}
.tfbk-i-num {font-size: 1.2em; font-weight: bold; color: var(--focus-color); margin-bottom: 5px; display: block;}
.frame-bg {color: var(--header-color);font-size: 0.8em;text-transform: uppercase;letter-spacing: 0.5px;}
CSS;
        }
    }
    add_action('widgets_init', function () {
        register_widget('TFBK_Site_Stat_Widget');
    });
