<?php
// Template name: Zibll-美女视频
get_header(); ?>
    <style>
        .container {
            max-width: 60%;
        }

        /* 按钮通用样式 */
        .button-container button {
            background-color: #4CAF50;
            /* 绿色背景 */
            border: none;
            /* 无边框 */
            color: white;
            /* 白色文字 */
            padding: 15px 32px;
            /* 内边距，增加点击区域 */
            text-align: center;
            /* 文字居中 */
            text-decoration: none;
            /* 无下划线 */
            display: inline-block;
            /* 行内块级元素，使其可以设置宽度和高度 */
            font-size: 16px;
            /* 字体大小 */
            margin: 4px 2px;
            /* 外边距，调整按钮间距 */
            cursor: pointer;
            /* 鼠标悬停时变为手形指针 */
            transition: background-color 0.3s ease;
            /* 背景色过渡效果 */
            border-radius: 8px;
            /* 圆角边框 */
            box-shadow: 0 4px #999;
            /* 阴影效果 */
        }

        /* “下一个”按钮特定样式 */
        .next-button {
            background-color: #2196F3;
            /* 蓝色背景 */
        }

        /* “下载”按钮特定样式 */
        .download-button {
            background-color: #ff9800;
            /* 橙色背景 */
        }

        /* 按钮悬停效果 */
        .button-container button:hover {
            background-color: #ddd;
            /* 悬停时背景色变浅 */
            box-shadow: 0 8px #666;
            /* 悬停时阴影加深 */
        }

        /* 按钮居中效果 */
        .button-container {
            display: flex;
            /* 使用Flexbox布局 */
            justify-content: center;
            /* 水平居中 */
            align-items: center;
            /* 垂直居中（如果需要的话） */
        }
    </style>
    <main class="container">
        <div class="content-wrap">
            <div class="content-layout">
                <!-- wp:zibllblock/dplayer -->
                <div class="wp-block-zibllblock-dplayer new-dplayer post-dplayer dplayer-scale-height" id="videoPlayer" video-url="https://example.com/video1.mp4" media-id="" data-loop="" data-hide="" data-autoplay="" data-volume="0.55" style="--scale-height:60%;" data-scale-height="60">
                    <div class="graphic" style="padding-bottom:50%">
                        <div class="abs-center text-center">
                            <i class="fa fa-play-circle fa-4x muted-3-color opacity5"></i>
                        </div>
                    </div>
                </div>
                <!-- /wp:zibllblock/dplayer -->

                <!-- 添加按钮 -->
                <div class="button-container">
                    <button class="next-button">下一个</button>
                    <button class="download-button">保存</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        // 视频URL列表
        const videoUrls = [
            'https://api.yujn.cn/api/zzxjj.php?type=video',
            // 添加更多视频URL
        ];

        // 获取当前视频索引（从URL参数中获取）
        function getCurrentVideoIndexFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            const indexParam = urlParams.get('videoIndex');
            return indexParam ? parseInt(indexParam, 10) : 0;
        }

        // 设置视频URL（根据当前视频索引）
        function setVideoUrl(index) {
            const playerElement = document.getElementById('videoPlayer');
            playerElement.setAttribute('video-url', videoUrls[index]);
            // 如果播放器有reload方法，则调用它重新加载视频
            if (typeof playerElement.reload === 'function') {
                playerElement.reload();
            } else {
                console.warn('播放器没有reload方法，请检查播放器API。');
            }
        }

        // 页面加载时设置视频URL
        window.onload = function() {
            const currentIndex = getCurrentVideoIndexFromUrl();
            setVideoUrl(currentIndex);
        };

        // “下一个”按钮点击事件
        document.querySelector('.next-button').addEventListener('click', function() {
            const currentIndex = getCurrentVideoIndexFromUrl();
            const nextIndex = (currentIndex + 1) % videoUrls.length;
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.set('videoIndex', nextIndex);
            window.location.href = newUrl.href;
        });

        // “保存”按钮点击事件
        document.querySelector('.download-button').addEventListener('click', function() {
            const currentIndex = getCurrentVideoIndexFromUrl();
            const videoUrl = videoUrls[currentIndex];

            // 创建一个隐藏的下载链接
            const downloadLink = document.createElement('a');
            downloadLink.href = videoUrl;
            downloadLink.download = 'video.mp4'; // 设置下载文件的默认名称
            document.body.appendChild(downloadLink);

            // 模拟点击下载链接
            downloadLink.click();

            // 移除下载链接
            document.body.removeChild(downloadLink);
        });
    </script>
<?php get_footer(); ?>