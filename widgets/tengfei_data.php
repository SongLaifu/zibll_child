<?php
    add_action('widgets_init', 'tengfei_data_widget');

    function tengfei_data_widget()
    {
        register_widget('tengfei_data_Widget');
    }

    class tengfei_data_Widget extends WP_Widget
    {

        function __construct()
        {
            parent::__construct(
                'tengfei_data_widget',
                __('ZibTF 侧边倒计时小工具', 'text_domain'),
                array('description' => __('显示距离节日的倒计时', 'text_domain'))
            );
        }

        public function widget($args, $instance)
        {
            echo $args['before_widget'];

            $festival_date = !empty($instance['festival_date']) ? esc_attr($instance['festival_date']) : '2025-01-29';

?>
            <div class="count-down s-card weidgets">
                <div class="count-left">
                    <span class="text">距离</span>
                    <span class="name">春节</span>
                    <span class="time"></span>
                    <span class="date"></span>
                </div>
                <div class="count-right">
                    <div class="count-item">
                        <div class="item-name">今日</div>
                        <div class="item-progress">
                            <div class="progress-bar" style="width: 0%;"></div>
                            <span class="percentage many">0%</span>
                            <span class="remaining many"></span>
                        </div>
                    </div>
                    <div class="count-item">
                        <div class="item-name">本周</div>
                        <div class="item-progress">
                            <div class="progress-bar" style="width: 0%;"></div>
                            <span class="percentage many">0%</span>
                            <span class="remaining many"></span>
                        </div>
                    </div>
                    <div class="count-item">
                        <div class="item-name">本月</div>
                        <div class="item-progress">
                            <div class="progress-bar" style="width: 0%;"></div>
                            <span class="percentage many">0%</span>
                            <span class="remaining many"></span>
                        </div>
                    </div>
                    <div class="count-item">
                        <div class="item-name">本年</div>
                        <div class="item-progress">
                            <div class="progress-bar" style="width: 0%;"></div>
                            <span class="percentage many">0%</span>
                            <span class="remaining many"></span>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const festivalDate = new Date("<?php echo $festival_date; ?>");
                    const now = new Date();

                    // 更新左侧春节的倒计时 腾飞博客- - www.tfbkw.com
                    const timeElement = document.querySelector('.count-left .time');
                    const dateElement = document.querySelector('.count-left .date');
                    const countdownTime = Math.ceil((festivalDate - now) / (1000 * 3600 * 24));
                    timeElement.innerText = countdownTime + " 天"; // 添加单位
                    dateElement.innerText = festivalDate.toISOString().split('T')[0];

                    const countItems = document.querySelectorAll('.count-item');

                    function calculateProgress() {
                        const currentTime = new Date();

                        // 今日的开始时间
                        const startOfToday = new Date(currentTime.getFullYear(), currentTime.getMonth(), currentTime.getDate());
                        const totalHoursToday = 24;

                        // 计算已过的小时
                        const hoursPassedToday = (currentTime - startOfToday) / (1000 * 3600);

                        // 更新今日进度
                        const todayPercent = (hoursPassedToday / totalHoursToday) * 100;
                        updateProgress(countItems[0], todayPercent, totalHoursToday - Math.floor(hoursPassedToday), '小时');

                        // 本周进度
                        const startOfWeek = new Date(currentTime);
                        startOfWeek.setDate(currentTime.getDate() - currentTime.getDay());
                        const totalDaysThisWeek = 7;
                        const daysPassedThisWeek = Math.floor((currentTime - startOfWeek) / (1000 * 3600 * 24));

                        // 更新本周进度
                        const weekPercent = (daysPassedThisWeek / totalDaysThisWeek) * 100;
                        updateProgress(countItems[1], weekPercent, totalDaysThisWeek - daysPassedThisWeek, '天');

                        // 本月进度
                        const startOfMonth = new Date(currentTime.getFullYear(), currentTime.getMonth(), 1);
                        const totalDaysThisMonth = new Date(currentTime.getFullYear(), currentTime.getMonth() + 1, 0).getDate();
                        const daysPassedThisMonth = Math.floor((currentTime - startOfMonth) / (1000 * 3600 * 24));

                        // 更新本月进度
                        const monthPercent = (daysPassedThisMonth / totalDaysThisMonth) * 100;
                        updateProgress(countItems[2], monthPercent, totalDaysThisMonth - daysPassedThisMonth, '天');

                        // 本年进度
                        const startOfYear = new Date(currentTime.getFullYear(), 0, 1);
                        const totalDaysThisYear = 365 + (isLeapYear(currentTime.getFullYear()) ? 1 : 0);
                        const daysPassedThisYear = Math.floor((currentTime - startOfYear) / (1000 * 3600 * 24));

                        // 更新本年进度
                        const yearPercent = (daysPassedThisYear / totalDaysThisYear) * 100;
                        updateProgress(countItems[3], yearPercent, totalDaysThisYear - daysPassedThisYear, '天');
                    }

                    function updateProgress(item, percent, remaining, unit) {
                        const progressBar = item.querySelector('.progress-bar');
                        const percentageText = item.querySelector('.percentage');
                        const remainingText = item.querySelector('.remaining');

                        progressBar.style.width = `${percent.toFixed(2)}%`;
                        percentageText.innerText = `${percent.toFixed(2)}%`;
                        remainingText.innerText = `还剩 ${remaining} ${unit}`;
                    }

                    function isLeapYear(year) {
                        return (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
                    }

                    calculateProgress();

                    // 鼠标悬停事件
                    document.querySelector('.count-down').addEventListener('mouseenter', calculateProgress);
                });
            </script>
        <?php

            echo $args['after_widget'];
        }

        public function form($instance)
        {
            $festival_date = !empty($instance['festival_date']) ? esc_attr($instance['festival_date']) : '2025-01-29';
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('festival_date'); ?>">过年日期:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('festival_date'); ?>" name="<?php echo $this->get_field_name('festival_date'); ?>" type="date" value="<?php echo $festival_date; ?>">
            </p>
<?php
        }

        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['festival_date'] = (!empty($new_instance['festival_date'])) ? strip_tags($new_instance['festival_date']) : '';
            return $instance;
        }
    }

    // 引入 CSS 样式
    add_action('wp_enqueue_scripts', function () {
        wp_enqueue_style('tengfei-data-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_data.css', array(), '1.0.0');
    });
?>