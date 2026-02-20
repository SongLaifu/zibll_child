<?php
/*
Template Name: Zibll-新闻日报

*/
get_header();
    /* 新闻60秒早报 */
    /* 使用方法：将代码放到主题function，新建页面选择HTML自定义代码，添加内容[zaobao] */
    function newzaobao()
    { // 60s
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://www.tfbkw.com/api/60s/test.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
            ),
        ));

        $url = curl_exec($ch);
        $a = json_decode($url, true);
        curl_close($ch);
        $code = $a['code'];

        if (is_home()) {
            echo "<posts class='posts-item list ajax-item flex' style='padding: 0;margin: 0;box-shadow: none;border-radius: unset;'>";
            echo "<div class='post-graphic'>";
            echo "<div class='item-thumbnail'>";
            echo "<a href='/sixs' title='新闻日报' rel='noopener noreferrer'>";

            if ($code != '200') {
                echo "<img width='100%' height='100%' class=' lazyloaded' src='https://xyblog-1259307513.cos.ap-guangzhou.myqcloud.com/wp-content/uploads/2022/01/20220127174907901.png' data-src='https://xyblog-1259307513.cos.ap-guangzhou.myqcloud.com/wp-content/uploads/2022/01/20220127174907901.png' alt='新闻日报'>";
            } else {
                echo "<img width='100%' height='100%' class=' lazyloaded' src='" . $a['data']['head_image'] . "' data-src='" . $a['data']['head_image'] . "' alt='新闻日报'>";
            }

            echo "</a>";
            echo "<badge class='img-badge left jb-red' style='background-image: -webkit-linear-gradient(0deg,#ffa8a8 0%,#dc2d30 100%);'>日报</badge>";
            echo "</div>";
            echo "</div>";
            echo "<div class='item-body flex xx flex1 jsb'>";
            echo "<h2 class='item-heading'>";
            echo "<a href='/sixs' class='title' title='新闻日报' rel='noopener noreferrer'>";
            echo "<span class='badge' style='display: inline-block; background-image: -webkit-linear-gradient(0deg, #f95491 0%, #2953fd 100%);margin-top: -3px;'>时事</span>  新闻日报</a>";
            echo "</h2>";

            if ($code != '200') {
                echo "<span style='display: inline-block;'>【微语】</span>";
                echo "<a class='abstract weiyu' style='overflow: hidden;text-overflow: ellipsis;white-space: nowrap;' href='/sixs' title='新闻摘要' rel='noopener noreferrer'></a>";
            } else {
                echo "<a class='abstract' style='overflow: hidden;text-overflow: ellipsis;white-space: nowrap;' href='/sixs' title='新闻摘要' rel='noopener noreferrer'>" . $a['data']['weiyu'] . "</a>";
            }

            echo "<div class='item-tags scroll-x no-scrollbar mb6'>";
            echo "<a class='but c-blue' title='查看更多分类文章' href='/news'><i class='fa fa-folder-open-o' aria-hidden='true'></i>每日新闻</a>";
            echo "<a href='/news' title='查看此标签更多文章' class='but'># 热点新闻早报</a>";
            echo "</div>";
            echo "<div class='item-meta muted-2-color flex jsb ac'>";
            echo "<item class='meta-author flex ac'>";
            echo "<a href='/user/'><span class='avatar-mini'>" . get_avatar(1, 32) . "</span></a>";
            echo "<span class='hide-sm ml6'>腾飞报道</span>";
            echo "<span class='icon-circle'>" . date('m月d日', time()) . "</span>";
            echo "</item>";
            echo "<div class='meta-right'>";
            echo "<item class='meta-comm'>";
            echo "<span class='link'><svg class='icon' aria-hidden='true'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-zhifengche'></use></svg>每日新闻自动更新</span>";
            echo "</item>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } else {
            if ($code != '200') {
                echo '<script>var str="https://www.tfbkw.com/api/60s/test.json";$.getJSON(str, function(json){var imgid = json.imageUrl;document.getElementById("suolue").src=imgid;});</script>';
                echo "<div style='text-align: center;'>";
                echo "<img id='suolue' style='width:100%;'>";
                echo "</div>";
            } else {
                echo "<div style='text-align:center;margin: 20px 0 10px;'>";
                echo "<span style='font-size:38px;'>每日热点新闻</span>";
                echo "</div>";
                echo "<div style='text-align:center;'>";
                echo "<span style='font-size:20px;'>更新时间：" . date('Y年m月d日', time()) . "</span>";
                echo "</div>";
                echo "<br>";

                for ($i = 0; $i < 15; $i++) {
                    if (isset($a['data']['news'][$i])) {
                        echo "<div><h3></h3><span> " . $a['data']['news'][$i] . "</span></div>";
                    }
                }

                echo "<br>";
                echo "<div><span style='font-size:16px;margin-left:0;'>" . $a['data']['weiyu'] . "</span></div>";
                echo "<div style='text-align:right;margin-top: 20px;'>";
                echo "<span style='font-size:20px;'>--- 来自新闻日报</span>";
                echo "</div>";
            }
        }
    }

    // 注册短代码
    add_shortcode('zaobao', 'newzaobao');
?>

    <style>
        .box-body,
        .box-header {
            padding: 100px;
            padding-top: 25px;
        }
    </style>
    <main class="container">
        <div class="content-wrap">
            <div class="content-layout">
                <div class="nopw-sm box-body theme-box radius8 main-bg main-shadow">
                    <!-- wp:paragraph -->
                    <?php
                    // 检查是否启用了短代码
                    if (function_exists('newzaobao')) {
                        echo do_shortcode('[zaobao]');
                    } else {
                        echo '短代码未注册或函数不存在。';
                    }
                    ?>
                    <!-- /wp:paragraph -->
                </div>
            </div>
        </div>
    </main>
<?php get_footer(); ?>