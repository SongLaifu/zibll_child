<?php
/**
 * Template Name: Zibll-关于本站
 */
get_header();
?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . "/pages/css/style.css" ?> ">
    <script>
        function calculateTotalAmount() {
            const totalAmountElement = document.querySelector(".reward-list-tips p");
            if (!totalAmountElement) {
                console.error("总金额元素未找到，请检查 HTML 结构是否正确！");
                return;
            }
            const amounts = document.querySelectorAll(".reward-list-item-money");
            let total = 0;
            amounts.forEach(amount => {
                const value = parseFloat(amount.textContent.replace("¥", "").trim());
                if (!isNaN(value)) {
                    total += value;
                }
            });
            totalAmountElement.textContent = `总金额：¥ ${total.toFixed(2)}，将全部用于博客的服务器、域名及云服务开销`;
        }
        document.addEventListener("DOMContentLoaded", calculateTotalAmount);
    </script>
    <script defer>
        function initAboutPage() {
            const helloAboutEl = document.querySelector(".hello-about");
            helloAboutEl.addEventListener("mousemove", evt => {
                const mouseX = evt.offsetX;
                const mouseY = evt.offsetY;

                // 设置鼠标跟随动画
                gsap.set(".cursor", {
                    x: mouseX,
                    y: mouseY,
                });

                // 对元素进行跟随动画并添加延迟效果
                gsap.to(".shape", {
                    x: mouseX,
                    y: mouseY,
                    stagger: -0.1,
                });
            });
        }

        // 检查是否加载了 gsap，未加载则动态加载
        if (typeof gsap === "object") {
            initAboutPage();
        } else {
            const getScript = (url) => new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = url;
                script.async = true;
                script.onerror = reject;
                script.onload = resolve;
                document.head.appendChild(script);
            });

            getScript("<?php echo get_stylesheet_directory_uri() . "/pages/js/gsap.min.js" ?>")
                .then(initAboutPage);
        }
    </script>

    <script>
        // 滚动
        var pursuitInterval = null;
        pursuitInterval = setInterval(function() {
            const show = document.querySelector('span[data-show]')
            const next = show.nextElementSibling || document.querySelector('.first-tips')
            const up = document.querySelector('span[data-up]')

            if (up) {
                up.removeAttribute('data-up')
            }

            show.removeAttribute('data-show')
            show.setAttribute('data-up', '')

            next.setAttribute('data-show', '')
        }, 2000)

        document.addEventListener('pjax:send', function() {
            clearInterval(pursuitInterval);
        });
    </script>
    </head>

    <body>
        <main class="layout hide-aside" id="content-inner">
            <div id="page">
                <div id="about-page">
                    <div class="author-info">
                        <div class="author-tag-left"><span class="author-tag">🤖️ 数码科技爱好者</span><span class="author-tag">🔍
                                分享与热心帮助</span><span class="author-tag">🏠 智能家居小能手</span><span class="author-tag">🔨
                                设计开发一条龙</span></div>
                        <div class="author-img">
                            <div id="lottie_avatar">
                                <img src="https://q1.qlogo.cn/g?b=qq&nk=2163564949&s=640" style="width: 100%">
                            </div>
                        </div>
                        <div class="author-tag-right"> <span class="author-tag">专修交互与设计 🤝</span><span
                                class="author-tag">脚踏实地行动派
                                🏃</span><span class="author-tag">团队小组发动机 🧱</span><span class="author-tag">壮汉人狠话不多
                                💢</span></div>
                    </div>
                    <div class="author-title">关于我</div>
                    <span class="p center author-span">生活明朗，万物可爱✨</span>
                    <div class="author-page-content">
                        <div class="author-content">
                            <div class="author-content-item myInfoAndSayHello">
                                <div class="title1">你好，很高兴认识你👋</div>
                                <div class="title2">我叫 <span class="inline-word">天才笨蛋喵</span></div>
                                <div class="title1">是一名 学生、运维小白、独立开发者、<span class="inline-word">博主</span></div>
                            </div>
                            <div class="aboutsiteTips author-content-item">
                                <div class="author-content-item-tips">追求</div>
                                <h2>源于<br> 热爱而去<span class="inline-word">创造</span>
                                    <div class="mask"><span class="first-tips"
                                            data-show="">产品</span><span>设计</span><span>程序</span><span>体验</span></div>
                                </h2>
                            </div>
                        </div>
                        <div class="author-content-item selfInfo single">
                            <div><span class="selfInfo-title">生于</span><span class="selfInfo-content"
                                    style="color: #43a6c6;">🎂 2006</span></div>
                            <div><span class="selfInfo-title">星座</span><span class="selfInfo-content"
                                    style="color:rgb(79, 193, 85);">🐏 白羊座</span></div>
                            <div><span class="selfInfo-title">现在职业</span><span class="selfInfo-content"
                                    style="color: #b04fe6;">💻 IT/学生</span></div>
                            <div><span class="selfInfo-title">所属</span><span class="selfInfo-content"
                                    style="color:rgb(240, 76, 76);">🌏 湖北省</span></div>
                        </div>
                        <div class="author-content">
                            <div class="create-site-post author-content-item single">
                                <div class="author-content-item-tips">心路历程</div>
                                <span class="author-content-item-title" style="font-size:25px;">关于本站</span>
                                <p>欢迎来到我的博客 😝，这里是我记生活和笔记的地方 🙌，目前就读于<strong
                                        style="color:#339966;font-size:24px;">计算机网络技术</strong>专业，<strong
                                        style="color: #33cccc;font-size:24px;">运维领域</strong>的一枚小白，虽然有时候常常会忘记更新笔记，咕咕 ✋~
                                    但是记笔记真的是一个很棒的习惯 💪，能把学下来的知识进行积累，沉淀，有一句话说的好，能教给别人的知识，才是真正学会了的知识！ ⚡</p>
                                <p> 创建<b><a style="font-size: 24px;color: #f2b94b;"
                                            href="#">本站</a></b>的本意其实是为了方便记录自己的学习过程中的一些笔记，并且因为是计算机专业的学生，所以接触电脑的时间相对较多，在网上看到了非常多的优秀的个人博客，而且那时候觉得自己动手搭建一个网站，是一件非常cool的事情，因此萌生了创建自己的博客的想法！
                                </p>
                                <p>总的来说，建立这个小站的初衷源于<b style="font-size:24px;color: #f45f7f;">热爱</b>分享，源于<strong
                                        style="font-size:24px;color:#425AEF;">兴趣</strong>使然</p>
                                <p>创造这个小站的本意<strong style="font-size:24px;color:#b04fe6;">也是我分享生活的方式</strong>，有幸能和你相遇在这里，相信我们能共同留下一段美好记忆！
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
    <?php get_footer(); ?>