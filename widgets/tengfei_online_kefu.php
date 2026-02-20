<?php
  // 注册小工具
  add_action('widgets_init', function () {
    register_widget('TFBK_Customer_Service_Widget');
  });

  class TFBK_Customer_Service_Widget extends WP_Widget
  {

    function __construct()
    {
      parent::__construct(
        'tfbk_customer_service_widget',
        __('ZibTF 右下角联系客服浮窗小工具', 'tfbk'),
        array('description' => __('右下角联系客服浮窗，可自定义显示规则、客服电话、邮箱、微信等', 'tfbk'))
      );
    }

    public function widget($args, $instance)
    {
      if (!tfbk_widget_is_show($instance)) {
        return;
      }
      $rand = esc_attr($this->number);

      $tel      = !empty($instance['tel']) ? esc_html($instance['tel']) : '086-15555-888-744';
      $email    = !empty($instance['email']) ? esc_html($instance['email']) : '12345678910@163.com';
      $weixin   = !empty($instance['weixin']) ? esc_html($instance['weixin']) : '12345678910';
      $activity = !empty($instance['activity']) ? esc_html($instance['activity']) : '新用户立减50元';
      $admin_uid = 1; // 目标私信管理员用户ID

      echo $args['before_widget'];
?>
      <style>
        .tfbk-float-box {
          position: fixed;
          right: 32px;
          bottom: 32px;
          z-index: 9999;
          max-width: 290px;
          font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        }

        .tfbk-kefu {
          background: #fff;
          border-radius: 12px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
          overflow: hidden;
          width: 290px;
          transition: all 0.3s ease;
        }

        .tfbk-kefu-head {
          background: #007bff;
          color: #fff;
          padding: 18px 20px;
          cursor: pointer;
          font-weight: bold;
          display: flex;
          align-items: center;
          justify-content: space-between;
          border-radius: 12px 12px 0 0;
          transition: background 0.3s ease;
        }

        .tfbk-kefu-head:hover {
          background: #0069d9;
        }

        .tfbk-kefu-cont {
          background: #fff;
          padding: 0 20px;
          max-height: 0;
          overflow: hidden;
          transition: max-height 0.5s cubic-bezier(0.34, 1.56, 0.64, 1), padding 0.5s ease;
        }

        .tfbk-kefu:not(.closed) .tfbk-kefu-cont {
          max-height: 400px;
          padding: 18px 20px 10px;
        }

        .tfbk-kefu-cont .tfbk-item {
          display: flex;
          align-items: center;
          margin-bottom: 14px;
          opacity: 0;
          transform: translateY(10px);
          transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .tfbk-kefu:not(.closed) .tfbk-item {
          opacity: 1;
          transform: translateY(0);
        }

        .tfbk-kefu:not(.closed) .tfbk-item:nth-child(1) {
          transition-delay: 0.1s;
        }

        .tfbk-kefu:not(.closed) .tfbk-item:nth-child(2) {
          transition-delay: 0.18s;
        }

        .tfbk-kefu:not(.closed) .tfbk-item:nth-child(3) {
          transition-delay: 0.26s;
        }

        .tfbk-kefu:not(.closed) .tfbk-item:nth-child(4) {
          transition-delay: 0.34s;
        }

        .tfbk-kefu-cont .tfbk-avatar {
          width: 38px;
          height: 38px;
          border-radius: 50%;
          background: #e3f0fd;
          display: flex;
          align-items: center;
          justify-content: center;
          color: #007bff;
          font-size: 18px;
          margin-right: 12px;
        }

        .tfbk-kefu-cont .tfbk-info {
          font-size: 15px;
          color: #666;
        }

        .tfbk-kefu-cont .tfbk-info b {
          display: block;
          color: #333;
        }

        .tfbk-kefu-cont .tfbk-action {
          margin-top: 10px;
          border-top: 1px solid #f1f1f1;
          padding-top: 18px;
          opacity: 0;
          transform: translateY(10px);
          transition: opacity 0.3s ease 0.3s, transform 0.3s ease 0.3s;
        }

        .tfbk-kefu:not(.closed) .tfbk-action {
          opacity: 1;
          transform: translateY(0);
        }

        .tfbk-kefu-cont .tfbk-btn,
        .tfbk-kefu-cont .service-pm-btn {
          display: block;
          width: 100%;
          background: #007bff;
          color: #fff;
          text-align: center;
          padding: 10px 0;
          border-radius: 6px;
          text-decoration: none;
          font-weight: 500;
          margin-top: 10px;
          transition: all 0.3s ease;
          box-sizing: border-box;
          border: none;
          cursor: pointer;
        }

        .tfbk-kefu-cont .tfbk-btn:hover,
        .tfbk-kefu-cont .service-pm-btn:hover {
          background: #0069d9;
          transform: translateY(-2px);
          box-shadow: 0 3px 8px rgba(0, 123, 255, 0.2);
        }

        .tfbk-kefu-cont .tfbk-activity {
          font-size: 15px;
          color: #007bff;
        }

        .tfbk-kefu-cont .tfbk-time {
          font-size: 13px;
          color: #888;
          margin-top: 4px;
        }

        .tfbk-kefu .fa-chevron-down {
          transition: transform 0.4s ease;
          transform-origin: center;
        }

        .tfbk-kefu.closed .fa-chevron-down {
          transform: rotate(-180deg);
        }

        @media (max-width: 768px) {
          .tfbk-float-box {
            right: 8px;
            bottom: 80px;
            max-width: 230px;
          }

          .tfbk-kefu {
            width: 230px;
            max-width: calc(100% - 16px);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
          }

          .tfbk-kefu-head {
            padding: 16px 18px;
            font-size: 15px;
          }

          .tfbk-kefu-cont {
            padding: 0 16px;
          }

          .tfbk-kefu:not(.closed) .tfbk-kefu-cont {
            padding: 16px 16px 14px;
          }

          .tfbk-kefu-cont .tfbk-avatar {
            width: 34px;
            height: 34px;
            font-size: 16px;
            margin-right: 10px;
          }

          .tfbk-kefu-cont .tfbk-item {
            margin-bottom: 16px;
          }

          .tfbk-kefu-cont .tfbk-info {
            font-size: 13px;
          }

          .tfbk-kefu-cont .tfbk-info b {
            font-size: 14px;
            margin-bottom: 3px;
          }

          .tfbk-kefu-cont .tfbk-action {
            padding-top: 16px;
            margin-top: 12px;
          }

          .tfbk-kefu-cont .tfbk-time {
            font-size: 12px;
            margin-top: 5px;
          }

          .tfbk-kefu-cont .tfbk-btn,
          .tfbk-kefu-cont .service-pm-btn {
            padding: 11px 0;
            font-size: 14px;
            margin-top: 12px;
            border-radius: 5px;
          }

          .tfbk-kefu-cont .tfbk-activity {
            font-size: 13px;
          }
        }

        @media (max-width: 320px) {
          .tfbk-float-box {
            bottom: 70px;
          }

          .tfbk-kefu {
            width: 220px;
          }
        }
      </style>

      <div class="tfbk-float-box">
        <div class="tfbk-kefu closed" id="kefuBox-widget-<?php echo $rand; ?>">
          <div class="tfbk-kefu-head" id="kefuHead-widget-<?php echo $rand; ?>">
            <span>在线客服</span>
            <i class="fa fa-chevron-down"></i>
          </div>
          <div class="tfbk-kefu-cont" id="kefuContent-widget-<?php echo $rand; ?>">
            <div class="tfbk-item">
              <div class="tfbk-avatar"><i class="fa fa-phone"></i></div>
              <div class="tfbk-info">
                <b>客服电话</b>
                <?php echo $tel; ?>
              </div>
            </div>
            <div class="tfbk-item">
              <div class="tfbk-avatar"><i class="fa fa-envelope"></i></div>
              <div class="tfbk-info">
                <b>邮箱</b>
                <?php echo $email; ?>
              </div>
            </div>
            <div class="tfbk-item">
              <div class="tfbk-avatar"><i class="fa fa-weixin"></i></div>
              <div class="tfbk-info">
                <b>微信</b>
                <?php echo $weixin; ?>
              </div>
            </div>
            <div class="tfbk-item">
              <div class="tfbk-avatar"><i class="fa fa-calendar"></i></div>
              <div class="tfbk-info">
                <b>最新活动</b>
                <span class="tfbk-activity"><?php echo $activity; ?></span>
              </div>
            </div>
            <div class="tfbk-action">
              <div class="tfbk-time">工作时间：24小时 · 7×24小时技术支持</div>
              <button
                type="button"
                data-height="550"
                data-remote="/wp-admin/admin-ajax.php?action=private_window_modal&amp;receive_user=<?php echo $admin_uid; ?>"
                class="tfbk-btn service-pm-btn"
                data-toggle="RefreshModal"
                id="kefuPmBtn-widget-<?php echo $rand; ?>">
                <i class="fa fa-paper-plane mr-2"></i>
                <span>在线咨询</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <script>
        (function() {
          var box = document.getElementById('kefuBox-widget-<?php echo $rand; ?>');
          var head = document.getElementById('kefuHead-widget-<?php echo $rand; ?>');
          var pmBtn = document.getElementById('kefuPmBtn-widget-<?php echo $rand; ?>');
          head.onclick = function() {
            box.classList.toggle('closed');
            box.style.transform = 'scale(0.97)';
            setTimeout(function() {
              box.style.transform = 'scale(1)';
            }, 15);
          };
          window.addEventListener('resize', function() {
            box.style.transform = 'none';
          });
          if (pmBtn) {
            pmBtn.addEventListener('click', function() {
              if (window.innerWidth <= 1024) {
                box.classList.add('closed');
              }
            });
          }
        })();
      </script>
    <?php
      echo $args['after_widget'];
    }

    public function form($instance)
    {
      $show_type = !empty($instance['show_type']) ? $instance['show_type'] : 'all';
      $tel      = !empty($instance['tel']) ? esc_attr($instance['tel']) : '086-15555-888-744';
      $email    = !empty($instance['email']) ? esc_attr($instance['email']) : '12345678910@163.com';
      $weixin   = !empty($instance['weixin']) ? esc_attr($instance['weixin']) : '12345678910';
      $activity = !empty($instance['activity']) ? esc_attr($instance['activity']) : '新用户立减50元';
    ?>
      <p>
        <b style="display:block;">显示规则</b>
        <label>
          <input type="radio" name="<?php echo $this->get_field_name('show_type'); ?>" value="all" <?php checked($show_type, 'all'); ?>>
          PC端/移动端均显示
        </label>
        <br>
        <label>
          <input type="radio" name="<?php echo $this->get_field_name('show_type'); ?>" value="pc" <?php checked($show_type, 'pc'); ?>>
          仅在PC端显示
        </label>
        <br>
        <label>
          <input type="radio" name="<?php echo $this->get_field_name('show_type'); ?>" value="mobile" <?php checked($show_type, 'mobile'); ?>>
          仅在移动端显示
        </label>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('tel'); ?>">客服电话：</label>
        <input class="widefat" id="<?php echo $this->get_field_id('tel'); ?>" name="<?php echo $this->get_field_name('tel'); ?>" type="text" value="<?php echo $tel; ?>">
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('email'); ?>">邮箱：</label>
        <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>">
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('weixin'); ?>">微信号：</label>
        <input class="widefat" id="<?php echo $this->get_field_id('weixin'); ?>" name="<?php echo $this->get_field_name('weixin'); ?>" type="text" value="<?php echo $weixin; ?>">
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('activity'); ?>">最新活动：</label>
        <input class="widefat" id="<?php echo $this->get_field_id('activity'); ?>" name="<?php echo $this->get_field_name('activity'); ?>" type="text" value="<?php echo $activity; ?>">
      </p>
      <p>小工具原创：<a href="https://www.tfbkw.com" target="_blank">腾飞博客</a></p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
      $instance = array();
      $instance['show_type'] = isset($new_instance['show_type']) ? $new_instance['show_type'] : 'all';
      $instance['tel']      = (!empty($new_instance['tel']))      ? strip_tags($new_instance['tel'])      : '';
      $instance['email']    = (!empty($new_instance['email']))    ? strip_tags($new_instance['email'])    : '';
      $instance['weixin']   = (!empty($new_instance['weixin']))   ? strip_tags($new_instance['weixin'])   : '';
      $instance['activity'] = (!empty($new_instance['activity'])) ? strip_tags($new_instance['activity']) : '';
      return $instance;
    }
  }

  if (!function_exists('tfbk_widget_is_show')) {
    function tfbk_widget_is_show($instance)
    {
      $show_type = !empty($instance['show_type']) ? $instance['show_type'] : 'all';
      if ($show_type === 'all') {
        return true;
      } elseif ($show_type === 'pc') {
        return !tfbk_is_mobile();
      } elseif ($show_type === 'mobile') {
        return tfbk_is_mobile();
      }
      return true;
    }
  }
  if (!function_exists('tfbk_is_mobile')) {
    function tfbk_is_mobile()
    {
      if (function_exists('wp_is_mobile')) return wp_is_mobile();
      $ua = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
      return preg_match('/iphone|android|mobile|windows phone|opera mini|blackberry|webos|ucweb|micromessenger|nexus|samsung/i', $ua);
    }
  }
?>