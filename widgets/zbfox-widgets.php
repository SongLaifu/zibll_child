<?php
/*
 * @Author: foxccs
 * @Url: foxccs.com
 * @Date: 2024-03-06 18:34:52
 * @LastEditTime: 2024-03-06 18:34:52
*/
    //当前文章读者开始
    class zxm_readingUsers_Widget extends WP_Widget
    {
        public function __construct()
        {
            $widget = array(
                'w_id'        => 'zxm_readingUsers_Widget',
                'w_name'      => _name('访客小工具'),
                'classname'   => '',
                'description' => '显示当前文章阅读者的小工具',
            );
            parent::__construct($widget['w_id'], $widget['w_name'], $widget);
            $this->check_and_create_table();
        }

        public function form($instance)
        {
            $defaults = array('limit' => 10);
            $instance = wp_parse_args((array) $instance, $defaults);
?>
            <p>
                <label for="<?php echo $this->get_field_id('limit'); ?>">请设置最多显示多少个最近阅读者:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" min="1" max="10" value="<?php echo $instance['limit']; ?>" />
            </p>
<?php
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['limit'] = (!empty($new_instance['limit'])) ? strip_tags($new_instance['limit']) : 10;
            return $instance;
        }

        private function check_and_create_table()
        {
            global $wpdb;

            $table_name = $wpdb->prefix . 'zxm_reading_history';
            if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
                $sql = "CREATE TABLE $table_name (  
                id bigint(20) unsigned NOT NULL AUTO_INCREMENT,  
                user_id bigint(20) unsigned NOT NULL,  
                post_id bigint(20) unsigned NOT NULL,  
                read_time datetime NOT NULL,  
                PRIMARY KEY  (id),  
                KEY user_id (user_id),  
                KEY post_id (post_id),  
                KEY read_time (read_time)  
            );";

                require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
                dbDelta($sql);
            }
        }

        public function record_read($post_id)
        {
            global $wpdb, $current_user;
            get_currentuserinfo();

            $user_id = $current_user->ID;
            if (!$user_id) {
                return; // 如果用户未登录，则不记录  
            }

            $read_time = current_time('mysql');

            // 检查用户是否已阅读过这篇文章  
            $existing_record = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT id FROM {$wpdb->prefix}zxm_reading_history WHERE user_id = %d AND post_id = %d LIMIT 1",
                    $user_id,
                    $post_id
                )
            );

            if ($existing_record) {
                // 如果记录存在，更新read_time  
                $wpdb->update(
                    $wpdb->prefix . 'zxm_reading_history',
                    array(
                        'read_time' => $read_time
                    ),
                    array(
                        'id' => $existing_record
                    ),
                    array(
                        '%s'
                    ),
                    array(
                        '%d'
                    )
                );
            } else {
                // 如果记录不存在，插入新记录  
                $wpdb->insert(
                    $wpdb->prefix . 'zxm_reading_history',
                    array(
                        'user_id' => $user_id,
                        'post_id' => $post_id,
                        'read_time' => $read_time
                    ),
                    array(
                        '%d',
                        '%d',
                        '%s'
                    )
                );
            }
        }

        public function get_reading_users($post_id, $limit)
        {
            global $wpdb;
            // 获取按阅读时间降序排列的前10条记录  
            $users_desc = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT u.ID, u.display_name, u.user_email    
                FROM {$wpdb->users} u    
                JOIN {$wpdb->prefix}zxm_reading_history rh ON u.ID = rh.user_id    
                WHERE rh.post_id = %d    
                ORDER BY rh.read_time DESC    
                LIMIT %d",
                    $post_id,
                    $limit
                ),
                ARRAY_A
            );
            // 反转数组以得到升序排列的后10条记录  
            $users = array_reverse($users_desc);

            return $users;
        }

        public function widget($args, $instance)
        {
            // echo $args['before_widget'];
            $limit = $instance['limit'];
            if (is_singular()) {
                $current_post_id = get_the_ID();

                // 记录当前用户的阅读活动  
                $this->record_read($current_post_id);

                // 获取阅读者列表  
                $users = $this->get_reading_users($current_post_id, $limit);
                if (!empty($users)) {
                    $readers = '<div class="zxm-recent-visitors-widget">
                    <span class="zxm-subscript">最近访客</span>';
                    foreach ($users as $user) {
                        $readers .= '<a href="/author/' . $user["ID"] . '">
                        <div class="zxm-visitor-avatar">
                        ' . zib_get_data_avatar($user["ID"]) . ' </div>
                        <div class="zxm-visitor-nickname">' . $user["display_name"] . '</div></a>';
                    }
                    $readers .= '</div><style>
                    .zxm-recent-visitors-widget {
                        display: flex;
                        height: 130px;
                        justify-content: center;
                        clear: both;
                        background: var(--main-bg-color);
                        padding: 15px;
                        box-shadow: 0 0 10px var(--main-shadow);
                        border-radius: var(--main-radius);
                        margin-top:0px;
                        margin-bottom: 20px;
                        position: relative;
                        overflow: hidden;
                    }
        
                    .zxm-recent-visitors-widget a {
                        text-decoration: none;
                        color: #333;
                        margin-left: 10px;
                    }
        
                    .zxm-recent-visitors-widget .zxm-visitor-avatar {
                        width: 78px;
                        height: 78px;
                        border-radius: 50%;
                        overflow: hidden;
                        margin-right: 5px;
                    }
        
                    .zxm-recent-visitors-widget .zxm-visitor-nickname {
                        color: var(--main-color);
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        width: 78px;
                        text-align: center;
                    }
                    span.zxm-subscript {
                        position: absolute;
                        top: 10px;
                        left: -50px;
                        z-index: 1;
                        width: 140px;
                        height: 20px;
                        background: #2997f7;
                        color: #fff;
                        line-height: 20px;
                        -webkit-transform: rotate(45deg);
                        transform: rotate(315deg);
                        text-align: center;
                        font-size: 12px;
                    }
                    </style>';
                    echo $readers;
                }
            }

            // echo $args['after_widget'];  
        }
    }
    //当前文章阅读者结束

    // 注册小工具  
    function register_zuoxm_widgets()
    {
        $widgets_to_register = array(
            'zxm_readingUsers_Widget' => 'zxm_ReadingUsers_Widget',
        );

        // 遍历数组，检查每个类是否存在，并注册对应的小工具  
        foreach ($widgets_to_register as $widget_name => $widget_class) {
            if (class_exists($widget_class)) {
                register_widget($widget_name);
            }
        }
    }

    add_action('widgets_init', 'register_zuoxm_widgets');
?>