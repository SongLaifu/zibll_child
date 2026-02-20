<?php
    add_action('widgets_init', 'register_vip_card_widget');

    function register_vip_card_widget()
    {
        register_widget('tengfe_vipcard_Widget');
    }

    class tengfe_vipcard_Widget extends WP_Widget
    {

        function __construct()
        {
            parent::__construct(
                'tengfe_vipcard_Widget',
                __('ZibTF VIP卡片小工具（第一版）', 'text_domain'),
                array('description' => __('显示会员尊享权益信息', 'text_domain'))
            );
            // 引入 CSS 样式
            add_action('wp_enqueue_scripts', function () {
                wp_enqueue_style('tengfei-vipcard-widget-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_vips.css', array(), '1.0.0');
            });
        }

        public function widget($args, $instance)
        {
            // 获取小工具配置信息
            $plans = [];
            for ($i = 1; $i <= 4; $i++) {
                // 处理下载数量
                $downloads = !empty($instance["downloads_$i"]) ? $instance["downloads_$i"] : '无限';
                if (is_numeric($downloads)) {
                    $downloads .= '个'; // 如果是数字，加上“个”
                }

                // 处理有效期限
                $validity = !empty($instance["validity_$i"]) ? $instance["validity_$i"] : '终生';
                if (is_numeric($validity)) {
                    $validity .= '天'; // 如果是数字，加上“天”
                }

                $plans[] = [
                    'id' => "onecad-id-$i",
                    'price' => !empty($instance["price_$i"]) ? $instance["price_$i"] : '0',
                    'duration' => !empty($instance["duration_$i"]) ? $instance["duration_$i"] : '会员',
                    'duration_desc' => !empty($instance["duration_desc_$i"]) ? $instance["duration_desc_$i"] : '描述内容',
                    'downloads' => $downloads,
                    'validity' => $validity,
                    'service' => !empty($instance["service_$i"]),
                    'assistance' => !empty($instance["assistance_$i"]),
                    'icon' => !empty($instance["icon_$i"]) ? esc_url($instance["icon_$i"]) : get_stylesheet_directory_uri() . '/widgets/img/heizuan.svg',
                    'highlight' => $i === 4, // 高亮显示最后一个
                ];
            }

            // 直接输出小工具的内容
?>
            <div class="wapnone">
                <div id="home-row-vip" class="mobile-hidden home_row home_row_10 module-html">
                    <div style="width:100%;">
                        <div class="home-row-left content-area">
                            <div id="html-box-vip" class="html-box" style="margin-top: 20px;margin-bottom: 20px">
                                <div class="one-home-title">
                                    <span>会员尊享权益</span>
                                    <p>成为我们的VIP会员，享受全站上百TB资源免费下载学习！</p>
                                </div>
                                <div id="Onecad_vips">
                                    <div class="one-home-homevip">
                                        <div class="one-container wrapper">
                                            <div class="one-home-homevip-box one-grid-ceosmls one-grid">
                                                <?php
                                                foreach ($plans as $i => $plan) {
                                                ?>
                                                    <div id="<?php echo $plan['id']; ?>" class="one-width-1-1 one-width-1">
                                                        <div class="home-homevip-boxmk one-dongtai one-background-default b2-radius<?php echo $plan['highlight'] ? ' highlight' : ''; ?>" style="<?php echo $plan['highlight'] ? 'border: 2px solid red;' : ''; ?>">
                                                            <?php if ($plan['highlight']) : ?>
                                                                <div class="vip_tj">VIP</div>
                                                            <?php endif; ?>
                                                            <div class="">
                                                                <img src="<?php echo $plan['icon']; ?>">
                                                            </div>
                                                            <div class="home-homevip-boxmktitle b-b">
                                                                <div class="price">¥<strong><?php echo $plan['price']; ?></strong>/ <?php echo $plan['duration']; ?></div>
                                                                <p><?php echo $plan['duration_desc']; ?></p>
                                                            </div>
                                                            <div class="home-homevip-boxmks">
                                                                <div class="onecad_vips_title">会员权益:</div>
                                                                <li>全站资源免费下载:<em><span><i class="fa fa-check"></i></span></em></li>
                                                                <li>每日下载:<em><span><?php echo $plan['downloads']; ?></span></em></li>
                                                                <li>会员期限:<em><span><?php echo $plan['validity']; ?></span></em></li>
                                                                <li>7*24小时服务:<em><span><?php echo $plan['service'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>'; ?></span></em></li>
                                                                <li>远程协助:<em><span><?php echo $plan['assistance'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>'; ?></span></em></li>
                                                            </div>
                                                            <a href="javascript:;" data-plan="vip_1" class="float-btn pay-vip my-custom-class-name">立刻加入</a>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            // echo $args['after_widget']; 不再使用，保持原样
        }

        public function form($instance)
        {
            for ($i = 1; $i <= 4; $i++) {
            ?>
                <h3>会员卡片 <?php echo $i; ?></h3>
                <p>
                    <label for="<?php echo $this->get_field_id("price_$i"); ?>">价格:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id("price_$i"); ?>" name="<?php echo $this->get_field_name("price_$i"); ?>" type="text" value="<?php echo esc_attr(!empty($instance["price_$i"]) ? $instance["price_$i"] : ''); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id("duration_$i"); ?>">/后面的文字<sup>（月、季、年、终身）</sup></label>
                    <input class="widefat" id="<?php echo $this->get_field_id("duration_$i"); ?>" name="<?php echo $this->get_field_name("duration_$i"); ?>" type="text" value="<?php echo esc_attr(!empty($instance["duration_$i"]) ? $instance["duration_$i"] : ''); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id("duration_desc_$i"); ?>">会员描述<sup>（月卡会员、季卡会员、年卡会员、终身会员）</sup></label>
                    <input class="widefat" id="<?php echo $this->get_field_id("duration_desc_$i"); ?>" name="<?php echo $this->get_field_name("duration_desc_$i"); ?>" type="text" value="<?php echo esc_attr(!empty($instance["duration_desc_$i"]) ? $instance["duration_desc_$i"] : ''); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id("icon_$i"); ?>">会员图标链接:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id("icon_$i"); ?>" name="<?php echo $this->get_field_name("icon_$i"); ?>" type="text" value="<?php echo esc_attr(!empty($instance["icon_$i"]) ? $instance["icon_$i"] : ''); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id("downloads_$i"); ?>">每日下载:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id("downloads_$i"); ?>" name="<?php echo $this->get_field_name("downloads_$i"); ?>" type="text" value="<?php echo esc_attr(!empty($instance["downloads_$i"]) ? $instance["downloads_$i"] : ''); ?>">
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id("validity_$i"); ?>">会员有效期限:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id("validity_$i"); ?>" name="<?php echo $this->get_field_name("validity_$i"); ?>" type="text" value="<?php echo esc_attr(!empty($instance["validity_$i"]) ? $instance["validity_$i"] : ''); ?>">
                </p>
                <p>
                    <input class="checkbox" type="checkbox" <?php checked(!empty($instance["service_$i"])); ?> id="<?php echo $this->get_field_id("service_$i"); ?>" name="<?php echo $this->get_field_name("service_$i"); ?>" />
                    <label for="<?php echo $this->get_field_id("service_$i"); ?>">7*24小时服务</label>
                </p>
                <p>
                    <input class="checkbox" type="checkbox" <?php checked(!empty($instance["assistance_$i"])); ?> id="<?php echo $this->get_field_id("assistance_$i"); ?>" name="<?php echo $this->get_field_name("assistance_$i"); ?>" />
                    <label for="<?php echo $this->get_field_id("assistance_$i"); ?>">远程协助</label>
                </p>
<?php
            }
        }

        public function update($new_instance, $old_instance)
        {
            $instance = [];
            for ($i = 1; $i <= 4; $i++) {
                $instance["price_$i"] = strip_tags($new_instance["price_$i"]);
                $instance["duration_$i"] = strip_tags($new_instance["duration_$i"]);
                $instance["duration_desc_$i"] = strip_tags($new_instance["duration_desc_$i"]);
                $instance["icon_$i"] = esc_url_raw($new_instance["icon_$i"]);
                $instance["downloads_$i"] = strip_tags($new_instance["downloads_$i"]);
                $instance["validity_$i"] = strip_tags($new_instance["validity_$i"]);
                $instance["service_$i"] = !empty($new_instance["service_$i"]);
                $instance["assistance_$i"] = !empty($new_instance["assistance_$i"]);
            }
            return $instance;
        }
    }
?>