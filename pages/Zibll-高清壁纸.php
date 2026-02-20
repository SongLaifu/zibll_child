<?php
// Template name: Zibll-高清壁纸
get_header(); ?>
<?php
    // 模拟的API返回数据，实际情况下，您需要从真实的API获取这些数据
    $apiResponse = [
        'status' => 'success',
        'data' => [
            'image_url' => 'https://t.alcy.cc/pc/', // 这里应该是您的API返回的图片URL
        ],
    ];

    // 检查API响应状态
    if ($apiResponse['status'] === 'success') {
        $imageUrl = $apiResponse['data']['image_url'];
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>壁纸设置</title>
            <style>
                body {
                    background-image: url('<?php echo $imageUrl; ?>');
                    background-size: cover;
                    background-repeat: no-repeat;
                }

                .button-container {
                    position: fixed;
                    bottom: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    text-align: center;
                }

                .button {
                    display: inline-block;
                    margin: 0 10px;
                    padding: 12px 24px;
                    background: linear-gradient(to right, #ff5e62, #ff9966);
                    /* 渐变背景 */
                    color: white;
                    /* 文本颜色 */
                    border: none;
                    border-radius: 50px;
                    /* 圆角 */
                    cursor: pointer;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    /* 内阴影 */
                    transition: all 0.3s ease;
                    /* 平滑过渡效果 */
                    font-weight: bold;
                    /* 加重字体 */
                    text-transform: uppercase;
                    /* 文本大写 */
                    letter-spacing: 1px;
                    /* 字符间距 */
                }

                .button:hover {
                    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
                    /* 悬停时更深的阴影 */
                    transform: translateY(-2px);
                    /* 悬停时上移 */
                }

                .footer {
                    display: none;
                }
            </style>
        </head>

        <body>
            <div class="button-container">
                <button class="button" onclick="nextImage()">下一张</button>
                <button class="button" onclick="saveWallpaper()">保存壁纸</button>
            </div>
            <script>
                function nextImage() {
                    // 触发网页刷新
                    location.reload();
                }

                function saveWallpaper() {
                    // 尝试复制图片URL到剪贴板
                    navigator.clipboard.writeText('<?php echo $imageUrl; ?>')
                        .then(() => {
                            alert('图片路径已复制到剪贴板！');
                        })
                        .catch(err => {
                            // 如果复制失败，可能是因为浏览器不支持或用户未授权
                            alert('复制失败，请手动复制图片路径: <?php echo $imageUrl; ?>');
                            console.error('无法复制文本: ', err);
                        });
                }
            </script>
        </body>

        </html>
    <?php
    } else {
        echo '无法从API获取图片。';
    }
    ?>
<?php get_footer(); ?>