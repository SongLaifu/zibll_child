<?php
    wp_enqueue_style('tengfei-cs-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_sale.css', array(), '1.0.0');

    class Custom_Countdown_Widget extends WP_Widget
    {
        function __construct()
        {
            parent::__construct(
                'custom_countdown_widget',
                __('ZibTF-限时优惠倒计时', 'text_domain'),
                array('description' => __('带倒计时和自定义色彩的促销小工具', 'text_domain'))
            );
            add_action('admin_enqueue_scripts', function ($hook) {
                if ($hook === 'widgets.php' || $hook === 'customize.php') {
                    wp_enqueue_style('wp-color-picker');
                    wp_enqueue_script('wp-color-picker');
                    wp_add_inline_script('wp-color-picker', "
                    (function($){
                        function initColorPicker(widget){
                            widget.find('.color-picker').not('.wp-color-picker').each(function(){
                                var input = $(this);
                                input.wpColorPicker({
                                    change: function(event, ui){
                                        input.val(ui.color.toString());
                                        input.trigger('change');
                                    },
                                    clear: function(event, ui){
                                        input.trigger('change');
                                    }
                                });
                                input.on('input', function(){
                                    input.trigger('change');
                                });
                            });
                        }
                        function onFormUpdate(event, widget){
                            initColorPicker(widget);
                        }
                        $(document).on('widget-added widget-updated', function(e, widget){
                            initColorPicker(widget);
                        });
                        $('.widget:has(.color-picker)').each(function(){
                            initColorPicker($(this));
                        });
                    })(jQuery);
                ");
                }
            });
        }

        public function widget($args, $instance)
        {
            $title = isset($instance['title']) ? $instance['title'] : '';
            $desc = isset($instance['desc']) ? $instance['desc'] : '';
            $image = isset($instance['image']) ? $instance['image'] : '';
            $endtime = isset($instance['endtime']) ? $instance['endtime'] : '';
            $origin_price = (isset($instance['origin_price']) && $instance['origin_price'] !== '') ? $instance['origin_price'] : '199';
            $discount_price = (isset($instance['discount_price']) && $instance['discount_price'] !== '') ? $instance['discount_price'] : '99';
            $btn_link = isset($instance['btn_link']) ? $instance['btn_link'] : '#';
            $bgcolor = isset($instance['bgcolor']) ? $instance['bgcolor'] : '#43a047';
            $uid = uniqid('cdw_');
?>
            <div id="<?php echo $uid; ?>">
                <div class="countdown-panel" style="--cd-bg:<?php echo esc_attr($bgcolor); ?>">
                    <div class="countdown-decoration"></div>
                    <?php if ($image): ?>
                        <img class="promotion-image" src="<?php echo esc_url($image); ?>" alt="">
                    <?php endif; ?>
                    <div class="promotion-header">
                        <div class="promotion-title"><?php echo esc_html($title); ?></div>
                        <?php if ($desc): ?>
                            <div class="promotion-desc"><?php echo esc_html($desc); ?></div>
                        <?php endif; ?>
                        <div class="countdown-display">
                            <div class="time-block">
                                <div class="time-value" id="<?php echo $uid; ?>_hours">00</div>
                                <div class="time-label">小时</div>
                            </div>
                            <div class="time-block">
                                <div class="time-value" id="<?php echo $uid; ?>_minutes">00</div>
                                <div class="time-label">分钟</div>
                            </div>
                            <div class="time-block">
                                <div class="time-value" id="<?php echo $uid; ?>_seconds">00</div>
                                <div class="time-label">秒</div>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-info">
                        <div class="original-price">原价: ¥<?php echo esc_html($origin_price); ?>元</div>
                        <div class="discount-price"><?php echo esc_html($discount_price); ?></div>
                    </div>
                    <a href="<?php echo esc_url($btn_link); ?>" class="buy-button" target="_blank">立即抢购</a>
                </div>
            </div>
            <script>
                (function() {
                    function updateCountdown_<?php echo $uid; ?>() {
                        var end = new Date('<?php echo esc_js($endtime); ?>'.replace(/-/g, '/'));
                        var now = new Date();
                        var left = end.getTime() - now.getTime();
                        if (left < 0) left = 0;
                        var h = Math.floor(left / 1000 / 60 / 60);
                        var m = Math.floor(left / 1000 / 60) % 60;
                        var s = Math.floor(left / 1000) % 60;
                        document.getElementById('<?php echo $uid; ?>_hours').innerText = ('0' + h).slice(-2);
                        document.getElementById('<?php echo $uid; ?>_minutes').innerText = ('0' + m).slice(-2);
                        document.getElementById('<?php echo $uid; ?>_seconds').innerText = ('0' + s).slice(-2);
                    }
                    updateCountdown_<?php echo $uid; ?>();
                    setInterval(updateCountdown_<?php echo $uid; ?>, 1000);
                })();
            </script>
        <?php
        }

        public function form($instance)
        {
            $title = isset($instance['title']) ? $instance['title'] : '包月VIP限时优惠还剩';
            $desc = isset($instance['desc']) ? $instance['desc'] : '';
            $image = isset($instance['image']) ? $instance['image'] : '';
            $origin_price = isset($instance['origin_price']) ? $instance['origin_price'] : '199';
            $discount_price = isset($instance['discount_price']) ? $instance['discount_price'] : '99';
            $btn_link = isset($instance['btn_link']) ? $instance['btn_link'] : '#';
            $bgcolor = isset($instance['bgcolor']) ? $instance['bgcolor'] : '#43a047';

            if (!empty($instance['endtime'])) {
                $endtime = $instance['endtime'];
                $dt = strtotime($endtime);
                $endtime_local = $dt ? date('Y-m-d\TH:i', $dt) : date('Y-m-d\TH:i', strtotime('+1 day'));
            } else {
                $endtime_local = date('Y-m-d\TH:i', strtotime('+1 day'));
            }
        ?>
            <p>
                <label>标题：</label>
                <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label>描述：</label>
                <input class="widefat" name="<?php echo $this->get_field_name('desc'); ?>" type="text" value="<?php echo esc_attr($desc); ?>">
            </p>
            <p>
                <label>图片链接（可选）：</label>
                <input class="widefat" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo esc_attr($image); ?>">
            </p>
            <p>
                <label>倒计时截止时间：</label>
                <input class="widefat" name="<?php echo $this->get_field_name('endtime'); ?>" type="datetime-local" value="<?php echo esc_attr($endtime_local); ?>">
                <small>请选择日期和时间</small>
            </p>
            <p>
                <label>原价：</label>
                <input class="widefat" name="<?php echo $this->get_field_name('origin_price'); ?>" type="text" value="<?php echo esc_attr($origin_price); ?>">
            </p>
            <p>
                <label>特价：</label>
                <input class="widefat" name="<?php echo $this->get_field_name('discount_price'); ?>" type="text" value="<?php echo esc_attr($discount_price); ?>">
            </p>
            <p>
                <label>按钮链接：</label>
                <input class="widefat" name="<?php echo $this->get_field_name('btn_link'); ?>" type="text" value="<?php echo esc_attr($btn_link); ?>">
            </p>
            <p>
                <label>背景色：</label>
                <input class="widefat color-picker" name="<?php echo $this->get_field_name('bgcolor'); ?>" type="text" value="<?php echo esc_attr($bgcolor); ?>">
            </p>
<?php
        }

        public function update($new, $old)
        {
            $instance = array();
            $instance['title'] = isset($new['title']) ? strip_tags($new['title']) : '';
            $instance['desc'] = isset($new['desc']) ? strip_tags($new['desc']) : '';
            $instance['image'] = isset($new['image']) ? strip_tags($new['image']) : '';
            if (!empty($new['endtime'])) {
                $dt = strtotime($new['endtime']);
                $instance['endtime'] = $dt ? date('Y-m-d H:i:s', $dt) : '';
            } else {
                $instance['endtime'] = '';
            }
            $instance['origin_price'] = isset($new['origin_price']) ? trim($new['origin_price']) : '';
            $instance['discount_price'] = isset($new['discount_price']) ? trim($new['discount_price']) : '';
            $instance['btn_link'] = isset($new['btn_link']) ? strip_tags($new['btn_link']) : '#';
            $instance['bgcolor'] = isset($new['bgcolor']) ? strip_tags($new['bgcolor']) : '#43a047';
            return $instance;
        }
    }
    add_action('widgets_init', function () {
        register_widget('Custom_Countdown_Widget');
    });
?>