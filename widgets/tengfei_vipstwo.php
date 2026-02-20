<?php
    add_action('widgets_init', 'register_tf_vip_cardtwo_widget');

    function register_tf_vip_cardtwo_widget()
    {
        register_widget('TF_VIPCardtwo_Widget');
    }

    class TF_VIPCardtwo_Widget extends WP_Widget
    {

        function __construct()
        {
            parent::__construct(
                'tf_vipcardtwo_widget',
                __('ZibTF VIP卡片小工具（第二版）', 'text_domain'),
                array('description' => __('显示VIP会员权益信息', 'text_domain'))
            );
            // 引入 CSS 样式
            add_action('wp_enqueue_scripts', function () {
                wp_enqueue_style('tf-vipcard-widget-style', get_stylesheet_directory_uri() . '/widgets/css/tengfei_vipstwo.css');
            });
        }

        public function widget($args, $instance)
        {
            // 获取小工具配置信息
            $plans = [];
            $default_icons = [
                get_stylesheet_directory_uri() . '/widgets/img/O1CN01qjNTow1QbIkLPattl_!!2210123621994.png', // 第一个卡片
                get_stylesheet_directory_uri() . '/widgets/img/O1CN01Krijfa1QbIkGaD8UQ_!!2210123621994.png', // 第二个卡片
                get_stylesheet_directory_uri() . '/widgets/img/O1CN01bO1mmr1QbIkFoFgM1_!!2210123621994.png', // 第三个卡片
                get_stylesheet_directory_uri() . '/widgets/img/O1CN01o6T0f81QbIkFoGp2V_!!2210123621994.png'  // 第四个卡片
            ];

            for ($i = 1; $i <= 4; $i++) {
                // 判断特权期限输入是否为数字
                $validity = $instance["validity_$i"];
                if (is_numeric($validity)) {
                    $validity .= '天'; // 如果是数字，加上“天”
                }

                // 判断每日下载输入是否为数字
                $downloads = $instance["downloads_$i"];
                if (is_numeric($downloads)) {
                    $downloads .= '个'; // 如果是数字，加上“个”
                }

                $plans[] = [
                    'id' => "onecad-id-$i",
                    'price' => !empty($instance["price_$i"]) ? $instance["price_$i"] : '0',
                    'duration' => !empty($instance["duration_$i"]) ? $instance["duration_$i"] : '会员',
                    'name' => !empty($instance["name_$i"]) ? $instance["name_$i"] : '会员',
                    'downloads' => $downloads, // 使用处理后的每日下载
                    'validity' => $validity, // 使用处理后的特权期限
                    // 使用默认图标或用户提供的图标
                    'icon' => !empty($instance["icon_$i"]) ? esc_url($instance["icon_$i"]) : $default_icons[$i - 1],
                    'highlight' => $i === 4, // 高亮显示最后一个
                    'exclusive' => !empty($instance["exclusive_$i"]), // 专属会员标识
                    'forever_update' => !empty($instance["forever_update_$i"]), // 享受本站资源永久免费更新
                ];
            }

            // 直接输出小工具的内容
?>

            <div class="Onecad-vip2-qy">
                <div class="Onecad-container">
                    <div class="vip2-qy-title">
                        <h2 style="margin-top: 0px;">开通会员享专属权益</h2>
                        <p>加入VIP，尊享海量丰富资源和功能体验</p>
                    </div>
                    <div onecad-grid="" class="Onecad-grid-medium Onecad-grid">
                        <div class="vip-item">
                            <div class="vip2-tqyc-box box Onecad-background-default Onecad-dongtai b2-radius"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2024020509334351.png" ?>" alt="免费下载"> <span>免费下载</span>
                                <p>本站所有付费资源免费获取</p>
                            </div>
                        </div>
                        <div class="vip-item">
                            <div class="vip2-tqyc-box box Onecad-background-default Onecad-dongtai b2-radius"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2024020509334047.png" ?>" alt="更新及时"> <span>更新及时</span>
                                <p>专人上传每天更新</p>
                            </div>
                        </div>
                        <div class="vip-item">
                            <div class="vip2-tqyc-box box Onecad-background-default Onecad-dongtai b2-radius"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2024020509334464.png" ?>" alt="网盘资源"> <span>网盘资源</span>
                                <p>主流网盘高速下载</p>
                            </div>
                        </div>
                        <div class="vip-item">
                            <div class="vip2-tqyc-box box Onecad-background-default Onecad-dongtai b2-radius"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2024020509333774.png" ?>" alt="会员标识"> <span>会员标识</span>
                                <p>优先售后</p>
                            </div>
                        </div>
                        <div class="vip-item">
                            <div class="vip2-tqyc-box box Onecad-background-default Onecad-dongtai b2-radius"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2024020509333935.png" ?>" alt="终生售后"> <span>终生售后</span>
                                <p>VIP享终生售后</p>
                            </div>
                        </div>
                        <div class="vip-item">
                            <div class="vip2-tqyc-box box Onecad-background-default Onecad-dongtai b2-radius"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2024020509334264.png" ?>" alt="尊享特权"> <span>尊享特权</span>
                                <p>VIP专属特权</p>
                            </div>
                        </div>
                        <div class="vip-item">
                            <div class="vip2-tqyc-box box Onecad-background-default Onecad-dongtai b2-radius"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2024020509334192.png" ?>" alt="永久有效"> <span>永久有效</span>
                                <p>VIP终生有效</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wapnone">
                <div class="tf-one-home-homevip" style="background-image: url('<?php echo get_stylesheet_directory_uri() . "/widgets/img/O1CN01t5O9fB1QbIkIodHN5_!!2210123621994.png" ?>')">
                    <div class=" one-container wrapper">
                        <div class=" tf-one-home-title">
                            <span>会员尊享权益圈子</span>
                            <p>成为我们的VIP会员，尊享无限免费下载使用，更享受全面的服务与福利</p>
                        </div>
                        <div class="tf-one-home-homevip-box one-grid-ceosmls one-grid">
                            <?php
                            foreach ($plans as $i => $plan) {
                            ?>
                                <div id="<?php echo $plan['id']; ?>" class="tf-one-width-1-1 tf-one-width-1 b2-radius">
                                    <div class="tf-home-homevip-boxmk tf-one-dongtai tf-one-background-default b2-radius <?php echo $plan['highlight'] ? 'highlight' : ''; ?>">
                                        <div class="">
                                            <?php if ($plan['highlight']) : ?>
                                                <div class="tf-vip_tj">推荐购买</div>
                                            <?php endif; ?>
                                            <img src="<?php echo $plan['icon']; ?>">
                                        </div>
                                        <div class="tf-home-homevip-boxmktitle b-b">
                                            <div class="price">¥<strong><?php echo $plan['price']; ?></strong>/ <?php echo $plan['duration']; ?></div>
                                            <p><?php echo $plan['name']; ?></p>
                                        </div>
                                        <div class="tf-home-homevip-boxmks">
                                            <div class="tf-Onecad_vips_title">
                                                <span>会员权益</span>
                                            </div>
                                            <li>每天可下载资源:<em><span><?php echo $plan['downloads']; ?></span></em></li>
                                            <li>会员享特权期限:<em><span><?php echo $plan['validity']; ?></span></em></li>
                                            <li>全站资源免费下载:<em><span><i class="fa fa-check"></i></span></em></li>
                                            <li>专属会员标识:<em><span><i class="<?php echo $plan['exclusive'] ? 'fa fa-check' : 'fa fa-close'; ?>"></i></span></em></li>
                                            <li>享受本站资源永久免费更新:<em><span><i class="<?php echo $plan['forever_update'] ? 'fa fa-check' : 'fa fa-close'; ?>"></i></span></em></li>
                                        </div>
                                        <!--<a href="/vips" class="tf-jitheme-jb-btn">更多权益</a>-->
                                        <a href="javascript:;" data-plan="vip_1" class="float-btn pay-vip my-custom-class-name" style="position: relative;
                                display: inline-block;
                                font-size: 14px;
                                line-height: 32px;
                                color: #fff;
                                text-align: center;
                                padding: 5px 10px;
                                background-color: var(--b2color);
                                width: 100%;
                                border-radius: 4px;
                                text-transform: uppercase;
                                z-index: 1;">立刻加入</a>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="zyx-home-spread zyx-background-default zyxss">
                <div class="zyx-container">
                    <div class="vip2-qy-title">
                        <h2 style="margin-top: 40px;">常见问题</h2>
                        <p>为您解决烦忧，我们势在必行！</p>
                    </div>
                    <div class="zyx-home-spread-box zyx-position-relative zyx-visible-toggle zyx-light zyx-slider zyx-slider-container" tabindex="-1" zyx-slider="">
                        <ul class="zyx-slider-items zyx-child-width-1-1 zyx-child-width-1-5@s zyx-grid" style="transform: translate3d(0px, 0px, 0px);">
                            <li>
                                <div class="home-spread-boxmk zyx-dongtai"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2021121300480885.png" ?>" alt="专业开发团队"><span>专业开发团队</span>
                                    <p>我们的团队成员均来自于互联网行业，并且有着多年的开发经验，熟悉网站的开发流程，对于WordPress插件设计开发有着丰富的经验</p>
                                </div>
                            </li>
                            <li>
                                <div class="home-spread-boxmk zyx-dongtai"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/202112130048171.png" ?>" alt="便捷设置管理"><span>便捷设置管理</span>
                                    <p>独立自主开发的WordPress后台插件设置面板，可以方便快捷的设置你的网站，即使不懂代码也可以随心所欲的修改插件自定义选项。</p>
                                </div>
                            </li>
                            <li>
                                <div class="home-spread-boxmk zyx-dongtai"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2021121300482379.png" ?>" alt="自动SEO优化"><span>自动SEO优化</span>
                                    <p>在开发过程中我们非常注重搜索引擎的优化，并借助WP平台的SEO优势，可以不需要任何插件即可实现自动提取生成页面关键词和描述。</p>
                                </div>
                            </li>
                            <li>
                                <div class="home-spread-boxmk zyx-dongtai"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2021121014363729.png" ?>" alt="前沿设计风格"><span>前沿设计风格</span>
                                    <p>我们时刻关注前沿设计风格，紧跟行业趋势，无论响应式还是扁平化，我们的WordPress插件都能轻松搞定！选择我们，让你的网站永不落伍！</p>
                                </div>
                            </li>
                            <li>
                                <div class="home-spread-boxmk zyx-dongtai"><img src="<?php echo get_stylesheet_directory_uri() . "/widgets/img/2021121014350367.png" ?>" alt="永久免费使用"><span>永久免费使用</span>
                                    <p>购买任意插件都可获得永久免费使用权，即一次付费后可以一直使用，摆脱传统建站按年收费的方式，避免网站因续费问题无法访问的尴尬。</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
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
                    <label for="<?php echo $this->get_field_id("name_$i"); ?>">会员描述<sup>（月卡会员、季卡会员、年卡会员、终身会员）</sup></label>
                    <input class="widefat" id="<?php echo $this->get_field_id("name_$i"); ?>" name="<?php echo $this->get_field_name("name_$i"); ?>" type="text" value="<?php echo esc_attr(!empty($instance["name_$i"]) ? $instance["name_$i"] : ''); ?>">
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
                    <label for="<?php echo $this->get_field_id("exclusive_$i"); ?>">专属会员标识:</label>
                    <input class="checkbox" id="<?php echo $this->get_field_id("exclusive_$i"); ?>" name="<?php echo $this->get_field_name("exclusive_$i"); ?>" type="checkbox" <?php checked(!empty($instance["exclusive_$i"]), true); ?> />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id("forever_update_$i"); ?>">享受本站资源永久免费更新:</label>
                    <input class="checkbox" id="<?php echo $this->get_field_id("forever_update_$i"); ?>" name="<?php echo $this->get_field_name("forever_update_$i"); ?>" type="checkbox" <?php checked(!empty($instance["forever_update_$i"]), true); ?> />
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
                $instance["name_$i"] = strip_tags($new_instance["name_$i"]);
                $instance["icon_$i"] = esc_url_raw($new_instance["icon_$i"]);
                $instance["downloads_$i"] = strip_tags($new_instance["downloads_$i"]);
                $instance["validity_$i"] = strip_tags($new_instance["validity_$i"]);
                $instance["exclusive_$i"] = !empty($new_instance["exclusive_$i"]); // 专属会员标识
                $instance["forever_update_$i"] = !empty($new_instance["forever_update_$i"]); // 享受本站资源永久免费更新
            }
            return $instance;
        }
    }
?>