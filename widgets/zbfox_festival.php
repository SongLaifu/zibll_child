<?php
    add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
    function my_theme_enqueue_styles()
    {
        wp_enqueue_style('zbfox-festival-widget-style', get_stylesheet_directory_uri() . '/widgets/css/zbfox-festival.css', array(), '1.0.0');
    }

    class Festival_Widget extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'festival_widget',
                __('Zbfox 节日提醒', 'text_domain'),
                array('description' => __('显示下一个节日的信息', 'text_domain'),)
            );
        }

        public function widget($args, $instance)
        {
            extract($args);
            echo $before_widget;
            $nextFestival = get_next_festival();

            $in_affix = $instance['in_affix'] ? ' data-affix="true"' : '';
            $class = !$instance['hide_box'] ? ' zib-widget' : '';

            $title    = $instance['title'];
            if ($title) {
                if ($instance['mini_title']) {
                    $xbt = '<small class="ml10">' . $instance['mini_title'] . '</small>';
                }
                echo '<h2 class="zbfox-widget-title">' . $instance['title'] . '' . $xbt . '</h2>';
            }

            echo '<div class="zhankr-zx' . $class . '"' . $in_affix . '>';
            echo '<span>' . $nextFestival['name'] . '</span>';
            echo '<div class="zhankr-zx-n">';
            echo '<strong style="margin-bottom:1px;">' . $nextFestival['greetings'][0] . '</strong>';
            echo '<strong style="margin-top:1px;">' . $nextFestival['greetings'][1] . '</strong>';
            echo '</div></div>';
            echo '<div class="zhankr-zx-underline">';
            echo '<span>' . $nextFestival['date']->format('Y年m月d日') . '</span>';
            echo '</div>';
            echo $after_widget;
        }

        public function form($instance)
        {
            $defaults = array(
                'title'        => '',
                'mini_title'   => '',
                'hide_box'     => '',
                'in_affix'     => '',
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
                //    'name'  => __('显示背景盒子', 'zib_language'),
                'id'    => $this->get_field_name('hide_box'),
                'std'   => $instance['hide_box'],
                'desc'  => '不显示背景盒子',
                'style' => 'margin: 10px auto;',
                'type'  => 'checkbox',
            );

            echo zib_edit_input_construct($page_input);
?>

            <p>
                <label>
                    <input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked($instance['in_affix'], 'on'); ?> id="<?php echo $this->get_field_id('in_affix'); ?>" name="<?php echo $this->get_field_name('in_affix'); ?>"> 侧栏随动（仅在侧边栏有效）
                </label>
            </p>
<?php
            echo '<p>';
            echo zbfox_necessary();
            echo '</p>';
        }
    }

    function register_festival_widget()
    {
        register_widget('Festival_Widget');
    }
    add_action('widgets_init', 'register_festival_widget');

    function get_next_festival()
    {
        $today = new DateTime();

        $festivals = [
            '元旦节' => [
                'date' => '01-01',
                'greetings' => ['新年快乐', '万事如意'],
            ],
            '春节' => [
                'date' => '02-10',
                'greetings' => ['新春快乐', '合家团圆'],
            ],
            '元宵节' => [
                'date' => '02-26',
                'greetings' => ['元宵快乐', '团团圆圆'],
            ],
            '清明节' => [
                'date' => '04-04',
                'greetings' => ['清明安康', '敬佑先祖'],
            ],
            '劳动节' => [
                'date' => '05-01',
                'greetings' => ['劳动光荣', '幸福快乐'],
            ],
            '端午节' => [
                'date' => '06-14',
                'greetings' => ['端午安康', '粽香四溢'],
            ],
            '七夕节' => [
                'date' => '08-14',
                'greetings' => ['七夕快乐', '爱情甜蜜'],
            ],
            '中秋节' => [
                'date' => '09-19',
                'greetings' => ['中秋快乐', '月圆人圆'],
            ],
            '国庆节' => [
                'date' => '10-01',
                'greetings' => ['国庆快乐', '繁荣昌盛'],
            ],
            '重阳节' => [
                'date' => '10-28',
                'greetings' => ['重阳祭祖', '身体健康'],
            ],
            '新年' => [
                'date' => '12-31',
                'greetings' => ['新年快乐', '喜迎新年'],
            ],
        ];

        $nextFestival = null;
        $nextFestivalDate = null;

        foreach ($festivals as $name => $festival) {
            $festivalDate = DateTime::createFromFormat('Y-m-d', date('Y') . '-' . $festival['date']);
            if ($festivalDate < $today) {
                $festivalDate->modify('+1 year');
            }
            if ($nextFestivalDate === null || $festivalDate < $nextFestivalDate) {
                $nextFestival = $name;
                $nextFestivalDate = $festivalDate;
            }
        }

        return [
            'name' => $nextFestival,
            'date' => $nextFestivalDate,
            'greetings' => $festivals[$nextFestival]['greetings'],
        ];
    }
