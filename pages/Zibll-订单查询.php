<?php

/**
 * Template name: Zibll-订单查询
 * Description:   search-order
 */

get_header(); ?>
    <style>
        .c-ok,
        .result-ok {
            color: #64d476;
        }

        .result-ok,
        .result-error {
            margin: 40px 0 10px;
            text-align: center;
        }

        .result-list {
            font-size: 13px;
            color: #888;
            background: var(--main-bg-color);
            padding: 10px;
            border-radius: 4px;
            width: 300px;
            margin: auto;
        }
    </style>

    <main class="container">
        <form class="text-center" style="top: 100px;">
            <div class="name">
                <h3 class="mb40">订单查询系统</h3>
            </div>
            <div class="form-group mt20" style="display: flex; justify-content: center; align-items: center;">
                <div style="width: 300px;">
                    <input type="text" class="form-control" id="order_num" name="order_num" placeholder="请输入订单号" style="height: 45px; font-size: 16px; background: var(--main-bg-color);">
                </div>
            </div>
            <span class="balance-charge-link user-auth-apply but jb-blue padding-lg btn-block mt10 submit-order" style="height:40px;width:300px">提交</span>
            <input type="hidden" name="action" value="search_order">
            <div class="result-box text-left"></div>
        </form>
    </main>

    <script>
        jQuery(document).ready(function($) {
            // 处理第二个 AJAX 请求
            $('.submit-order').on('click', function(e) {
                e.preventDefault();

                var orderNum = $('#order_num').val();

                // 添加加载提示
                notyf("加载中，请稍等...", "load", 2000, "result-box");

                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'search_order',
                        order_num: orderNum
                    },
                    beforeSend: function() {
                        $('.result-box').html(''); // 清空结果框
                    },
                    success: function(response) {
                        if (!response.error && response.type) {
                            $('.result-box').html(response.type);
                            notyf("请求成功", "success", 2000, "result-box");
                        } else {
                            $('.result-box').html('<div class="result-error"><svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3355"><path d="M512 512m-435.2 0a435.2 435.2 0 1 0 870.4 0 435.2 435.2 0 1 0-870.4 0Z" fill="#FE6D68" p-id="3356"></path><path d="M563.2 512l108.8-108.8c12.8-12.8 12.8-38.4 0-51.2-12.8-12.8-38.4-12.8-51.2 0L512 460.8 403.2 352c-12.8-12.8-38.4-12.8-51.2 0-12.8 12.8-12.8 38.4 0 51.2L460.8 512 352 620.8c-12.8 12.8-12.8 38.4 0 51.2 12.8 12.8 38.4 12.8 51.2 0L512 563.2l108.8 108.8c12.8 12.8 38.4 12.8 51.2 0 12.8-12.8 12.8-38.4 0-51.2L563.2 512z" fill="#FFFFFF" p-id="3357"></path></svg>未找到相关结果</div>');
                            notyf("请求失败: " + response.message, "error", 2000, "result-box");
                        }
                    },
                    error: function() {
                        $('.result-box').html('<div class="result-error">发生错误，请重试。</div>');
                        notyf("发生错误，请重试。", "error", 2000, "result-box");
                    }
                });
            });
        });
    </script>
<?php get_footer(); ?>