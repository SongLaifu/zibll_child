<?php

/**
 * Template name: Zibll-友情链接
 * Description:   sidebar page
 */

get_header();
/*友情链接检测
* 毕方资源网：www.bfbke.com
*/
    function xy_link()
    {
        global $wpdb;
        $links = $wpdb->prefix . 'links';
        $user_url = !empty($_REQUEST['user_url']) ? $_REQUEST['user_url'] : '';
        $xypro_url = esc_url(home_url());

        $url = get_plugin_url() . '/pages/api/urlApi.php?myurl=' . urlencode($xypro_url) . '&targeturl=' . urlencode($user_url);

        //初始化
        $response = wp_remote_get($url, array(
            'timeout' => 20,
            'sslverify' => false,
        ));
        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            error_log("HTTP request error: " . $error_message);
            zib_send_json_error(array('code' => -1, 'msg' => '请求数据错误: ' . $error_message));
            return;
        }
        $http_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);

        $deta = date("Y-m-d H:i:s", time() + 8 * 60 * 60);


        if ($body) {
            $data = json_decode($body, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log("JSON decode error: " . json_last_error_msg());
                zib_send_json_error(array('code' => -1, 'msg' => 'JSON解析错误: ' . json_last_error_msg()));
                return;
            }
            if ($data['code'] == 200 && isset($data['data']['message']) && $data['data']['message'] == '友情链接存在!') {
                $link_visible = 'Y';
                $msg = '检测友情链接正常！';
            } else {
                $link_visible = 'N';
                $msg = isset($data['data']['message']) ? $data['data']['message'] : '未获得URL相关数据，请重试！';
            }
        } else {
            $link_visible = 'N';
            $msg = '请求数据错误';
        }
        $link_con = array(
            'link_visible' => $link_visible,
            'link_updated' => $deta,
            'link_notes'   => $msg,
        );
        $wpdb->update($links, $link_con, array('link_url' => $user_url));
        zib_send_json_success(array('code' => 0, 'msg' => $msg));
    }
    add_action('wp_ajax_xy_link', 'xy_link');

    function xy_link_jc()
    {
        global $wpdb;
        $links = $wpdb->prefix . 'links';
        $deta = date("Y-m-d H:i:s", time() + 8 * 60 * 60);
        $link_YN = !empty($_REQUEST['link_id']) ? $_REQUEST['link_id'] : '';
        $link_yn = mb_substr($link_YN, 0, 1, 'utf-8');
        $link_id = substr_replace($link_YN, "", 0, 1);

        if ($link_yn == 'N') {
            $link_con = array(
                'link_visible' => 'N',
                'link_updated' => $deta,
                'link_notes'   => '请确认您已经添加本站的链接',
            );
            $wpdb->update($links, $link_con, array('link_id' => $link_id));
            zib_send_json_success(array('code' => -1, 'msg' => '已将链接隐藏'));
        } elseif ($link_yn == 'Y') {
            $link_con = array(
                'link_visible' => 'Y',
                'link_updated' => $deta,
                'link_notes'   => '检测友情链接正常！',
            );
            $wpdb->update($links, $link_con, array('link_id' => $link_id));
            zib_send_json_success(array('code' => 0, 'msg' => '已将链接显示'));
        } elseif ($link_yn == 'D') {
            $del = $wpdb->delete($links, array('link_id' => $link_id));
            if ($del) {
                zib_send_json_success(array('code' => 0, 'msg' => '删除成功'));
            }
        }
    }
    add_action('wp_ajax_xy_link_jc', 'xy_link_jc');

    function Links()
    {
        global $wpdb;
        $links = $wpdb->prefix . 'links';
        $links_count = $wpdb->get_var("SELECT COUNT(`link_id`) FROM {$links}");
        if (get_current_user_id() == 1) {
            $gl = true;
            $gl_td = '<th align="center" class="xy-width-100 xy_hide">管理</th>';
        }
        //<span class="but jb-pink inspect" style="float: right;font-size: 12px;">一键检测</span>
        $html = '
        <div class="zib-widget">
            <h2>友情链接检测

            </h2>
            <div class="xypro_describe"> 
                <p class="xy_height_hide_p2 xy_display_btn">查看更多友链 <i class="fa fa-angle-down ml6 xy-more-btn"></i></p>
                <p class="xy_height_hide_p"></p>
                <div class="xypro_describe_title">
                    检测列表（' . $links_count . '条友链）
                </div> 
                <div id="xy_hide" class="xypro_describe_content xy_height_hide">
                    <table class="yq">
                        <thead>
                            <tr>
                                <th align="center" class="xy-width-190">检测时间</th>
                                <th align="center">网站名称</th>
                                <th align="center">下链原因</th>
                                ' . $gl_td . '
                            </tr>
                        </thead>';
        $html .= '          <tbody class="link-list">';

        //获取分页数据 :每页显示的数量 默认为50
        $limit = 15;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        //计算每一页第一条记录的显示偏移量
        //偏移量 = (页码 -1) \* 每页的显示数量
        $offset = ($paged - 1) * $limit;

        $total = $wpdb->get_var("SELECT COUNT(`link_id`) FROM $links");
        $pages = ceil($total / $limit);

        //调用
        $link = $wpdb->get_results("SELECT * FROM $links WHERE link_id ORDER BY link_id desc LIMIT {$limit} OFFSET {$offset}");

        foreach ($link as $k => $v) {
            $name = $v->link_name;
            $btn = '<a href="javascript:;" class="but jb-pink testing" style="float:right;font-size:12px" id="' . $v->link_url . '">检测</a>';
            $btn = get_current_user_id() == 1 ? $btn : '';
            if ($v->link_notes == '检测友情链接正常！') {
                $msg_btn = 'color: green;';
            } else {
                $msg_btn = 'color: red;';
            }
            if ($gl) {
                $gl_tr_td = '<td class="xy_hide">
            <a  href="javascript:;" class="admin-btn">管理</a>
            <ul class="admin-guanli">
                <li><a class="link_JC" href="javascript:;" id="Y' . $v->link_id . '">显示</a></li>
                <li><a class="link_JC" href="javascript:;" id="N' . $v->link_id . '">隐藏</a></li>
                <li><a class="link_JC" href="javascript:;" id="D' . $v->link_id . '">删除</a></li>
            </ul>
            </td>';
            }
            if ($v->link_notes == '检测友情链接正常！') {
                $title = '检测友情链接正常';
                $name = '<a href="' . $v->link_url . '" target="_blank" data-toggle="tooltip" data-original-title="' . $v->link_description . '">' . $name . '</a>';
            } elseif ($v->link_notes == '未获得URL相关数据，请重试！') {
                $title = '请检查网站是否开了重定向';
            } elseif ($v->link_notes == '请确认您已经添加本站的链接') {
                $title = '请检查该链接是否做了本站友链';
            } elseif (!$v->link_notes) {
                $title = '该网站站长还未检测';
            } else {
                $title = '检测网站访问时间过长';
            }
            $link_notes = $v->link_notes ? $v->link_notes : '该网站站长还未检测';
            $html .= '<tr class="yq_link">
                    <td>' . $v->link_updated . '</td>
                    <td>' . $name . '</td>
                    <td style="' . $msg_btn . '"><span data-toggle="tooltip" data-original-title="' . $title . '">' . $link_notes . '</span><span class="xy_hide">' . $btn . '</span></td>
                    ' . $gl_tr_td . '
                </tr>';
        }

        $html .= '<script>
 
        var clicktype = true;
        $(".link_JC").on("click",function(e){
            if(confirm(\'是否进入下一步操作?\')) {
                if(clicktype == false){return false};
                clicktype = false;
                var link_id = $(this).attr("id");
                $.ajax({
                    type:"POST",
                    url:"' . admin_url('admin-ajax.php') . '",
                    data:{
                        "action":"xy_link_jc",
                        "link_id":link_id,
                    },
                    cache:false,
                    dataType:"json",
                    success:function(data){
                        if(data.code == 0){
                            notyf(data.msg,"success");
                        }else{
                            notyf(data.msg,"warning");
                        }
                        clicktype = true;
                    },
                    error:function(data){
                        notyf("请求数据错误","warning");
                        clicktype = true;
                    }
                });
            }
        });
    </script>';

        $html .= '<script>
        var clicktype = true;
        $(".testing").on("click",function(e){
            if(clicktype == false){return false};
            clicktype = false;
            var link_url = $(this).attr("id");
            notyf("检测中请稍等...","load", "2");
            var text = "<i class=loading mr6></i> 检测中";
            $(this).attr("disabled",true);
            $(this).text("");
            $(this).append(text);
            $(this).addClass("jc-load");
            $.ajax({
                    type:"POST",
                    url:"' . admin_url('admin-ajax.php') . '",
                    data:{
                        "action":"xy_link",
                        "user_url":link_url,
                    },
                    cache:false,
                    dataType:"json",
                    success:function(data){
                        if(data.code == 0){
                            notyf(data.msg,"success");
                        }else{
                            notyf(data.msg,"warning");
                        }
                        clicktype = true;
                        $(".jc-load").text("");
                        $(".jc-load").append("检测");
                        $(".jc-load").attr("disabled",false);
                      //  link_url.removeClass("jc-load");
                    },
                    error:function(data){
                        notyf("请求数据错误","warning");
                        clicktype = true;
                        $(".jc-load").text("");
                        $(".jc-load").append("检测");
                        $(".jc-load").attr("disabled",false);
                       // link_url.removeClass("jc-load");
                    }
                });
        })
    </script>';

        $html .= '<script>
        $(document).on("click",".xy_display_btn",function(){
            $(".xy_display_btn").remove();
            $(".xy_height_hide_p").remove();
            $("#xy_hide").removeClass("xy_height_hide");
            $(".xypro_describe").append("<p class=\'xy_height_hide_p2 xy_hide_btn\'>隐藏友链列表 <i class=\'fa fa-angle-up ml6 xy-more-btn\'></i></p>");
        });
        $(document).on("click",".xy_hide_btn",function(){
            $(".xy_hide_btn").remove();
            $("#xy_hide").addClass("xy_height_hide");
            $(".xypro_describe").append("<p class=\'xy_height_hide_p2 xy_display_btn\'>查看更多友链 <i class=\'fa fa-angle-down ml6 xy-more-btn\'></i></p><p class=\'xy_height_hide_p\'></p>");
            $("body,html").animate({scrollTop:$(".xypro_describe").offset().top},400);

        });
    </script>';
        $html .= '</tbody></table>';
        $html .= $link ? xy_pages($pages, $paged) : '<div class="text-center ajax-item "><p style="" class="em09 muted-3-color separator">暂无友链链接</p></div>';
        $html .= '</div></div></div>';
        return $html;
    }
    /**
     * 数字分页函数
     * 因为wordpress默认仅仅提供简单分页
     * 所以要实现数字分页，需要自定义函数      
     */
    function xy_pages($max_page, $paged)
    {
        $html = '';
        $html .= '<style>
        .pagination{margin:30px 0;padding:0 10px;text-align:center;font-size:12px;display:block;border-radius:0}
        .excerpts .pagination{margin-bottom: 10px;}
        .pagination ul{display:inline-block !important;margin-left:0;margin-bottom:0;padding:0}
        .pagination ul > li{display:inline}
        .pagination ul > li > a,.pagination ul > li > span{margin:0 2px;padding:6px 12px;background-color:#ddd;color:#666;border-radius:2px;opacity:.88}
        .pagination ul > li > a:hover,.pagination ul > li > a:focus{opacity:1}
        .pagination ul > .active > a,.pagination ul > .active > span{background-color:#1d1d1d;color:#fff}
        .pagination ul > .active > a,.pagination ul > .active > span{cursor:default}
        .pagination ul > li > span,.pagination ul > .disabled > span,.pagination ul > .disabled > a,.pagination ul > .disabled > a:hover,.pagination ul > .disabled > a:focus{color:#999999;background-color:transparent;cursor:default}
    </style>';

        $p = 2;
        if ($max_page == 1) {
            return;
        }
        $html .= '<span class="pagination"><ul>';
        $paged = !empty($paged) ? $paged : 1;

        if ($paged > 1) {
            $html .= '<li><a href="' . esc_html(get_pagenum_link(1)) . '">首页</a></li>';
        }

        $html .= '<li class="prev-page">';
        $html .= '</li>';
        for ($i = $paged - $p; $i <= $paged + $p; $i++) {
            if ($i > 0 && $i <= $max_page) {
                if ($i == $paged) {
                    $html .= "<li class=\"active\"><span>{$i}</span></li>";
                } else {
                    $html .= '<li><a href="' . esc_html(get_pagenum_link($i)) . '">' . $i . '</a></li>';
                }
            }
        }
        $html .= '<li class="next-page">';
        $html .= '</li>';
        $html .= '<li><a href="' . esc_html(get_pagenum_link($max_page)) . '">尾页</a></li>';
        //$html.= '<li><span>共 '.$max_page.' 页</span></li>';
        $html .= '</ul></span>';
        return $html;
    }

    /*友情链接检测*/



    // 获取链接列表
    function zib_page_links()
    {

        $type = 'card';
        $post_ID = get_queried_object_id();
        $args_orderby = get_post_meta($post_ID, 'page_links_orderby', true);
        $args_order = get_post_meta($post_ID, 'page_links_order', true);
        $args_limit = get_post_meta($post_ID, 'page_links_limit', true);
        $args_category = get_post_meta($post_ID, 'page_links_category', true);
        $args = array(
            'orderby'        => $args_orderby ? $args_orderby : 'name', //排序方式
            'order'          => $args_order ? $args_order : 'ASC', //升序还是降序
            'limit'          => $args_limit ? $args_limit : -1, //最多显示数量
            'category'       => $args_category, //以逗号分隔的类别ID列表
        );
        $links = get_bookmarks($args);

        $html = '';

        if ($links) {
            $html .= zib_links_box($links, $type, false);
        } elseif (is_super_admin()) {
            $html = '<a class="author-minicard links-card radius8" href="' . admin_url('link-manager.php') . '" target="_blank">添加链接</a>';
        } else {
            $html = '<div class="author-minicard links-card radius8">暂无链接，请联系管理员添加</div>';
        }
        return $html;
    }

    get_header();
    $post_id = get_queried_object_id();
    $header_style = zib_get_page_header_style();
    $page_links_content_s = get_post_meta($post_id, 'page_links_content_s', true);
    $page_links_content_position = get_post_meta($post_id, 'page_links_content_position', true);
    $page_links_submit_s = get_post_meta($post_id, 'page_links_submit_s', true);
?>
    <style>
        .admin-btn {
            background: #8486f8;
            padding: 2px 10px;
            color: #fff;
            border-radius: 4px;
        }

        .admin-guanli {
            visibility: hidden;
            position: absolute;
            min-width: 80px;
            background-color: var(--main-bg-color);
            padding: 10px 5px;
            z-index: 99;
            border-radius: var(--main-radius);
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            right: -40px;
            margin-top: -40px;
        }

        .xy_hide:hover>.admin-guanli {
            visibility: unset;
        }

        .xy_hide:hover>.admin-btn {
            color: #fff;
            background: #6d6fd8;
        }

        .f12 {
            font-size: 12px;
        }

        .xypro_describe {
            position: relative;
            border: 1px dashed #dcdfe6;
            line-height: 26px;
        }

        .xypro_describe_title {
            position: absolute;
            top: 0;
            left: 8px;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            background: #fff;
            padding: 0 5px;
            color: #303133;
            font-weight: 500;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .xypro_describe_content {
            color: #606266;
            padding: 18px 15px 30px;
        }

        .yq {
            width: 100%;
            max-width: 100%;
            table-layout: fixed;
            color: #909399;
            margin-bottom: 18px;
            border-top: 1px solid #ebeef5;
            border-left: 1px solid #ebeef5;
        }

        .yq thead th {
            font-weight: 500;
            background: #ebeef5;
            text-align: center;
            padding: 8px;
            border-bottom: 1px solid #ebeef5;
            border-right: 1px solid #ebeef5;
        }

        .yq_link td {
            text-align: center;
            padding: 8px;
            border-bottom: 1px solid #ebeef5;
            border-right: 1px solid #ebeef5;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .xy_li {
            text-align: center;
            font-size: 16px;
            line-height: 30px;
        }

        .xy_li::marker {
            content: "#" counter(list-item) " ";
            color: var(--theme-color);
        }

        .xy-mask {
            background-color: rgba(0, 0, 0, .5);
        }

        .xy_height_hide {
            height: 300px;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .xy_height_hide_p {
            background: linear-gradient(180deg, hsla(0, 0%, 100%, 0), #fff);
            width: 100%;
            z-index: 1;
            position: absolute;
            bottom: 0;
            margin: 0;
            height: 100px;
        }

        .xy_height_hide_p2 {
            text-align: center;
            bottom: 0;
            z-index: 2;
            position: absolute;
            left: 0;
            right: 0;
            cursor: pointer !important;
        }

        .xy-more-btn {
            width: 20px;
            height: 20px;
            background-color: var(--main-bg-color);
            border: 1px solid rgb(237, 237, 237);
            border-radius: 50%;
            line-height: 18px;
        }

        code {
            font-family: "lovely";
        }

        .xy_callout ol li::marker {
            content: "#" counter(list-item) " ";
            color: var(--theme-color);
        }

        .xy_callout {
            padding: 20px;
            border: 1px solid #e4e4e4;
            border-left-width: 5px;
            border-radius: 6px;
            line-height: 30px;
            font-weight: 600;
            border-left-color: var(--theme-color);
        }

        .xy_content>h5 {
            margin: 0;
            font-weight: 600;
            font-size: 24px;
            line-height: 32px;
            padding: 20px 0;
            text-align: center;
        }

        .xy_checkbox:checked {
            background: var(--theme-color);
            -webkit-appearance: none;
            position: relative;
            border-radius: 2px;
            width: 15px;
            height: 15px;
            vertical-align: -2px;
        }

        .xy_content h5:before {
            content: '「';
            color: var(--theme-color);
            font-weight: 600;
            margin-left: 5px;
        }

        .xy_content h5:after {
            content: '」';
            color: var(--theme-color);
            font-weight: 600;
            margin-right: 5px;
        }

        /**.xy_checkbox:checked:after {content:'';width: 6px;height: 10px;position: absolute;top: 1px;left: 5px;border: 2px solid #fff;border-top: 0;border-left: 0;-webkit-transform: rotate(45deg);transform: rotate(45deg);}**/
        .wp-posts-content li {
            margin-bottom: 0;
        }

        .xy-width {
            padding: 0 30px 30px;
        }

        .wp-posts-content ol>li>span {
            color: var(--theme-color);
        }

        @media screen and (max-width:500px) {
            .xy-width {
                padding: 10px;
            }

            .wp-posts-content ol:not(.blocks-gallery-grid) {
                margin: 0;
            }

            .xy_hide {
                display: none;
            }

            .title-h-center {
                display: none;
            }

            .xy-mask {
                background-color: rgb(0 0 0 / 5%);
            }
        }

        @media screen and (min-width:500px) {
            .xy-width-190 {
                width: 190px;
            }

            .xy-width-100 {
                width: 100px;
            }
        }
    </style>
    <script>
        //$.getJSON("https://api.qjqq.cn/api/Yi?c=f&encode=json",function(data){ $("#yulu").text(data.hitokoto);});$(function(){$("#yulu").click(function() {$(this).select();})})
    </script>

    <main class="container">
        <div class="content-wrap">
            <div class="content-layout">
                <?php while (have_posts()) : the_post(); ?>
                    <?php echo Links(); ?>
                <?php endwhile; ?>
                <?php comments_template('/template/comments.php', true); ?>
            </div>
        </div>
        <?php get_sidebar(); ?>
    </main>
<?php get_footer(); ?>