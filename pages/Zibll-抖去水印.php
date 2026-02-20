<?php
// Template name: Zibll-抖去水印
get_header();?>
    <style>
        .container {
            max-width: 60%;
        }
    </style>
    <?php
    $finalUrl = "";
    $errorMsg = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = $_POST['inputField'];

        // 处理用户输入，尝试获取视频ID或链接
        $videoIdOrLink = processUserInput($input);
        if (is_numeric($videoIdOrLink)) {
            // 如果输入是纯数字，则认为它是videoId
            $videoId = $videoIdOrLink;
        } else if (preg_match('/v\.douyin\.com\/[a-zA-Z0-9]+/', $videoIdOrLink)) {
            // 从链接中提取视频ID
            $videoId = extractVideoId($videoIdOrLink);
        } else {
            $errorMsg = "输入无法识别";
        }

        if ($videoId) {
            $apiUrl = "https://www.iesdouyin.com/web/api/v2/aweme/iteminfo/?reflow_source=reflow_page&item_ids={$videoId}&a_bogus=64745b2b5bdc4e75b720a9a85b19867a";
            $response = file_get_contents($apiUrl);
            $data = json_decode($response, true);

            if (!empty($data['item_list'][0]['video']['play_addr']['uri'])) {
                $uri = $data['item_list'][0]['video']['play_addr']['uri'];
                $desc = $data['item_list'][0]['desc'];
                $finalUrl = "www.iesdouyin.com/aweme/v1/play/?video_id={$uri}&ratio=1080p&line=0";
            }
        } else if (!$errorMsg) {
            $errorMsg = "无法获取视频ID";
        }
    }

    function processUserInput($input)
    {
        preg_match('/v\.douyin\.com\/[a-zA-Z0-9]+/', $input, $matches);
        if (!empty($matches)) return $matches[0];
        preg_match('/\d{19}/', $input, $matches);
        if (!empty($matches)) return $matches[0];
        return null;
    }

    function extractVideoId($link)
    {
        $redirectLink = getRedirectUrl($link);
        preg_match('/\/video\/(\d+)\//', $redirectLink, $idMatches);
        return !empty($idMatches) ? $idMatches[1] : null;
    }

    function getRedirectUrl($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        preg_match('/^Location: (.+)$/mi', $response, $matches);
        return !empty($matches[1]) ? trim($matches[1]) : null;
    }

    ?>
    <main class="container">
        <div class="content-wrap">
            <div class="content-layout">
                <div class="nopw-sm box-body theme-box radius8 main-bg main-shadow">
                    <article class="article wp-posts-content">
                        <h2 class="wp-block-heading has-text-align-center has-x-large-font-size">请输入抖音链接</h2>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="link_name" class="col-sm-2 control-label">输入信息：</label>
                                    <input type="text" class="form-control" id="inputField" name="inputField" placeholder="输入包含抖音链接的文本,或者是视频ID">
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="but c-blue padding-lg">提交</button>
                                </div>
                                <div class="form-group">
                                    <label for="resultLink" class="col-sm-2 control-label">视频标题:(双击复制)</label>
                                    <input type="text" class="form-control" id="resultdesc" value="<?php echo $desc; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="resultLink" class="col-sm-2 control-label">无水印链接:(双击复制)</label>
                                    <input type="text" class="form-control" id="resultLink" value="<?php echo $finalUrl; ?>">
                                </div>

                                <?php if ($errorMsg) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        错误:
                                        <?php echo $errorMsg; ?>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </article>
                    <script>
                        $(document).ready(function() {
                            // 当用户双击resultLink输入框时，复制其内容
                            $("#resultLink").dblclick(function() {
                                this.select();
                                document.execCommand('copy');
                                toastr.options.timeOut = 2000; // 3秒后消失
                                toastr.options.positionClass = "toast-top-center"; // 设置位置在顶部中间
                                // 使用toastr来显示消息
                                toastr.success('链接已复制到剪贴板!');
                                // alert("链接已复制到剪贴板!");
                            });

                            // 当用户双击resultdesc输入框时，复制其内容
                            $("#resultdesc").dblclick(function() {
                                this.select();
                                document.execCommand('copy');
                                toastr.options.timeOut = 2000; // 3秒后消失
                                toastr.options.positionClass = "toast-top-center"; // 设置位置在顶部中间
                                // 使用toastr来显示消息
                                toastr.success('标题已复制到剪贴板!');
                                // alert("链接已复制到剪贴板!");
                            });

                            // 当用户双击resultdesc输入框时，复制其内容
                            $("#submit-one").click(function() {
                                // this.select();
                                // document.execCommand('copy');
                                toastr.options.timeOut = 3000; // 3秒后消失
                                toastr.options.positionClass = "toast-top-center"; // 设置位置在顶部中间
                                // 使用toastr来显示消息
                                toastr.success('提交成功');
                                // alert("链接已复制到剪贴板!");
                            });

                            // 当表单提交时，清空所有内容
                            $("form").submit(function() {
                                $("#resultLink").val("");
                                $(".alert").hide();
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </main>
<?php get_footer(); ?>