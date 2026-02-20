<?php
    add_action('widgets_init', 'register_calendar_widget');
    function register_calendar_widget()
    {
        register_widget('Widget_Calendar');
    }

    class Widget_Calendar extends WP_Widget
    {
        public function __construct()
        {
            parent::__construct(
                'widget_calendar',
                __('Zbfox 日历小工具', 'text_domain'),
                array(
                    'description' => __('显示一个动态日历', 'text_domain'),
                )
            );
        }

        public function widget($args, $instance)
        {
            echo $before_widget;

?>
            <div class="huliku-next-calendar blue">
                <div class="calendar-header">
                    <div class="calendar-title">
                        日历
                    </div>
                    <div class="calendar-header-right">
                        <div class="calendar-month-week">
                            <div id="currentMonth"></div>
                            <div id="currentDayOfWeek"></div>
                        </div>
                        <div class="calendar-current-day" id="currentDay"></div>
                        <img class="img-calendar-header-1" src="<?php get_stylesheet_directory_uri() . "/widgets/img/calendar-header-1.svg" ?>">
                        <img class="img-calendar-header-2" src="<?php get_stylesheet_directory_uri() . "/widgets/img/calendar-header-2.svg" ?>">
                        <img class="img-calendar-header-3" src="<?php get_stylesheet_directory_uri() . "/widgets/img/calendar-header-3.svg" ?>">
                    </div>
                </div>
                <div class="calendar-main">
                    <div class="calendar-body-header">
                        <ul>
                            <li>一</li>
                            <li>二</li>
                            <li>三</li>
                            <li>四</li>
                            <li>五</li>
                            <li>六</li>
                            <li>日</li>
                        </ul>
                        <ul id="calendarDates"></ul>
                    </div>
                </div>
            </div>
<?php

            echo $after_widget;
        }

        public function form($instance)
        {
            echo '<p>';
            echo zbfox_necessary();
            echo '</p>';
        }
    }

    function load_calendar_widget_scripts()
    {
        wp_enqueue_style('calendar-widget-style', get_stylesheet_directory_uri() . '/widgets/css/zbfox_calendar.css');
        wp_enqueue_script('calendar-widget-script', get_stylesheet_directory_uri() . '/widgets/js/zbfox_calendar.js', array('jquery'), '1.0', true);
    }

    add_action('wp_enqueue_scripts', 'load_calendar_widget_scripts');
?>