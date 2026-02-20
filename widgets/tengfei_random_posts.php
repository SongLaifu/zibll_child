<?php
class ZibTF_Custom_Random_Posts_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'zibtf_custom_random_posts_widget',
            'ZibTF 文章侧边随机文章',
            array('description' => '随机文章展示小工具，优先使用主题外链特色图像')
        );
    }

    public function widget($args, $instance) {
        extract($args);
        
        $widget_unique_id = esc_attr($this->id);
        $posts_num = empty($instance['posts_num']) ? 4 : (int)$instance['posts_num'];
        $title = empty($instance['title']) ? '今日精选' : $instance['title'];
        $show_thumbnail = isset($instance['show_thumbnail']) ? (bool)$instance['show_thumbnail'] : true;
        $show_date = isset($instance['show_date']) ? (bool)$instance['show_date'] : true;

        $title_first = mb_substr($title, 0, 2, 'UTF-8');
        $title_rest = mb_substr($title, 2, null, 'UTF-8');

        $random_posts = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => $posts_num,
            'orderby' => 'rand',
            'post_status' => 'publish',
            'no_found_rows' => true,
            'ignore_sticky_posts' => true
        ));
        ?>

<link rel="preload" href=<?php echo get_stylesheet_directory()?> + "/fonts/AlimamaShuHeiTi-Bold.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" id="zibtf-custom-fonts">
<style id="zibtf-font-fix">
@font-face {
    font-family: "AliFont";
    src: url(<?php echo get_stylesheet_directory()?> + "/fonts/AlimamaShuHeiTi-Bold.woff2") format("woff2"),
         url(<?php echo get_stylesheet_directory()?> + "/fonts/AlimamaShuHeiTi-Bold.woff") format("woff");
    font-weight: 600;
    font-style: normal;
    font-display: swap;
    unicode-range: U+4E00-9FFF, U+3000-30FF;
}

.zibtf-posts-header .zibtf-posts-title.fali,
#zibtf-crp-widget-<?php echo $widget_unique_id; ?> .zibtf-posts-header .zibtf-posts-title.fali {
    font-family: "AliFont", "Alimama ShuHei Ti", "Arial Unicode MS", sans-serif !important;
    font-size: 22px !important;
    font-weight: 600 !important;
    color: #222 !important;
    line-height: 1.5 !important;
    letter-spacing: 0.5px !important;
    display: block !important;
    position: relative !important;
    z-index: 20 !important;
}

@font-face {
    font-family: "AliFontFallback";
    src: local("SimHei"), local("Microsoft YaHei"), local("Heiti TC");
    font-weight: 600;
}

.font-loading-failed .zibtf-posts-title.fali {
    font-family: "AliFontFallback", sans-serif !important;
}

.zibtf-custom-posts-widget {
    font-family: inherit;
    max-width: 500px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.zibtf-posts-header .zibtf-posts-title {
    margin: 0 !important;
    position: relative;
    padding-bottom: 8px;
    display: block !important;
    visibility: visible !important;
    height: auto !important;
    overflow: visible !important;
}

.zibtf-posts-title.fali span {
    color: var(--focus-color) !important;
}

.zibtf-article-title {
    font-size: 15px !important;
    color: #1e293b !important;
    margin: 0 0 8px !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    transition: color 0.2s !important;
    line-height: 1.5 !important;
    height: auto !important;
    visibility: visible !important;
}

.zibtf-article-title a {
    text-decoration: none !important;
    color: inherit !important;
    display: inline !important;
}

.zibtf-article-card:hover .zibtf-article-title,
.zibtf-article-title a:hover {
    color: var(--focus-color) !important;
}

.zibtf-posts-card {
    background: var(--footer-bg);
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: all 0.5s;
    position: relative;
    margin-bottom: 15px;
}
.zibtf-posts-card:hover {
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}
.zibtf-bubble-top-right, .zibtf-bubble-bottom-left {
    position: absolute;
    width: 128px;
    height: 128px;
    border-radius: 50%;
    filter: blur(24px);
}
.zibtf-bubble-top-right {
    top: 0;
    right: 0;
    margin-right: -64px;
    margin-top: -64px;
    background-color: rgba(30,64,175,0.05);
    clip-path: polygon(100% 0,100% 100%,0 100%);
}
.zibtf-bubble-bottom-left {
    bottom: 0;
    left: 0;
    margin-left: -64px;
    margin-bottom: -64px;
    background-color: rgba(248,113,113,0.05);
    clip-path: polygon(0 0,100% 0,0 100%);
}
.zibtf-corner-dot {
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}
.zibtf-dot-top-right {
    top: 16px;
    right: 16px;
    background-color: rgba(30,64,175,0.3);
    z-index: 999;
}
.zibtf-dot-bottom-left {
    bottom: 16px;
    left: 16px;
    background-color: rgba(248,113,113,0.3);
    z-index: 999;
}
.zibtf-posts-header {
    padding: 24px 24px 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 10;
    margin-bottom: 12px;
}
.zibtf-posts-header:not(.noborder):after {
    position: absolute;
    left: 0;
    bottom: 0;
    content: "";
    height: 1px;
    width: 100%;
    background: var(--main-shadow);
}
.zibtf-posts-title::after {
    content: '';
    position: absolute;
    bottom: 5px;
    left: 0;
    width: 33%;
    height: 4px;
    background-color: var(--focus-shadow-color);
    border-radius: 2px;
}
.zibtf-refresh-btn {
    padding: 6px 12px;
    border-radius: 50px;
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}
.zibtf-refresh-btn::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--focus-color-opacity1);
    border-radius: 50px;
    transform: scale(0);
    transition: transform 0.3s;
}
.zibtf-refresh-btn:hover {
    color: var(--focus-color);
}
.zibtf-refresh-btn:hover::after {
    transform: scale(1);
}
@keyframes zibtf-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.zibtf-animate-spin {
    animation: zibtf-spin 1s linear infinite;
}
.zibtf-articles-list {
    padding: 0 8px;
    position: relative;
    z-index: 10;
}
.zibtf-article-card {
    display: flex;
    gap: 14px;
    padding: 16px;
    border-bottom: 1px solid var(--float-btn-bg);
    transition: all 0.3s;
    align-items: center;
}
.zibtf-article-card:last-child {
    border-bottom: none;
}
.zibtf-article-card:hover {
    background-color: var(--body-bg-color);
    transform: translateY(-2px);
    border-radius: 10px;
}
.zibtf-article-image {
    width: 56px;
    height: 56px;
    border-radius: 8px;
    object-fit: cover;
    flex-shrink: 0;
    transition: transform 0.3s;
}
.zibtf-article-card:hover .zibtf-article-image {
    transform: scale(1.05);
}
.zibtf-article-info {
    flex: 1;
    min-width: 0;
}
.zibtf-article-date {
    font-size: 15px;
    color: var(--footer-color);
    display: flex;
    align-items: center;
}
.zibtf-date-bar {
    width: 6px;
    height: 6px;
    background-color: var(--focus-color);
    border-radius: 50%;
    margin-right: 8px;
}
.zibtf-posts-footer {
    padding: 16px 24px;
    text-align: center;
    color: #64748b;
    font-size: 15px;
    position: relative;
    z-index: 10;
}
@media (max-width: 480px) {
    .zibtf-article-image {
        width: 44px;
        height: 44px;
    }
    .zibtf-posts-header {
        padding: 20px 16px 10px;
    }
    .zibtf-article-title, .zibtf-article-date {
        font-size: 13px !important;
    }
    .zibtf-posts-footer {
        font-size: 13px;
    }
}
</style>

<div class="zibtf-custom-posts-widget" id="zibtf-crp-widget-<?php echo $widget_unique_id; ?>">
    <div class="zibtf-posts-card">
        <div class="zibtf-bubble-top-right"></div>
        <div class="zibtf-bubble-bottom-left"></div>
        <div class="zibtf-corner-dot zibtf-dot-top-right"></div>
        <div class="zibtf-corner-dot zibtf-dot-bottom-left"></div>
        <div class="zibtf-posts-header">
            <h2 class="zibtf-posts-title fali">
                <span><?php echo esc_html($title_first); ?></span><?php echo esc_html($title_rest); ?>
            </h2>
            <button class="zibtf-refresh-btn" id="zibtf-crp-refresh-btn-<?php echo $widget_unique_id; ?>">
                <i class="fa fa-repeat"></i>
                <span>换一批</span>
            </button>
        </div>
        <div class="zibtf-articles-list" id="zibtf-crp-list-<?php echo $widget_unique_id; ?>">
            <?php
            if ($random_posts->have_posts()) :
                wp_reset_postdata();
                while ($random_posts->have_posts()) : $random_posts->the_post();
                    $current_post_id = get_the_ID();
                    $img_url = '';
                    if (function_exists('zib_get_post_meta')) {
                        $img_url = zib_get_post_meta($current_post_id, 'thumbnail_url', true);
                    }
                    
                    if (!$img_url && function_exists('zib_get_post_img_urls')) {
                        $post_img_urls = zib_get_post_img_urls(get_post($current_post_id));
                        $img_url = isset($post_img_urls[0]) ? $post_img_urls[0] : '';
                    }
                    
                    if (!$img_url && function_exists('zib_get_spare_thumb')) {
                        $img_url = zib_get_spare_thumb();
                    }

                    $lazy_thumb = function_exists('zib_get_lazy_thumb') ? zib_get_lazy_thumb() : '';
                    $is_lazy = function_exists('zib_is_lazy') && zib_is_lazy('lazy_posts_thumb');
                    $post_title = get_the_title($current_post_id);
                    $post_permalink = get_permalink($current_post_id);
            ?>
                <div class="zibtf-article-card">
                    <?php if ($show_thumbnail && $img_url) : ?>
                        <?php if ($is_lazy) : ?>
                            <img src="<?php echo esc_url($lazy_thumb); ?>" 
                                 data-src="<?php echo esc_url($img_url); ?>" 
                                 alt="<?php echo esc_attr($post_title); ?>" 
                                 class="zibtf-article-image lazyload">
                        <?php else : ?>
                            <img src="<?php echo esc_url($img_url); ?>" 
                                 alt="<?php echo esc_attr($post_title); ?>" 
                                 class="zibtf-article-image">
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="zibtf-article-info">
                        <h3 class="zibtf-article-title" style="display:block !important;">
                            <a href="<?php echo esc_url($post_permalink); ?>" style="display:inline !important;">
                                <?php echo $post_title ? esc_html($post_title) : '无标题文章'; ?>
                            </a>
                        </h3>
                        <?php if ($show_date) : ?>
                        <div class="zibtf-article-date">
                            <span class="zibtf-date-bar"></span>
                            <span><?php echo get_the_date('', $current_post_id); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else : ?>
                <div class="p-4 text-center text-gray-500">没有找到文章</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
(function(){
    const wid = '<?php echo $widget_unique_id; ?>';
    const refreshBtn = document.getElementById('zibtf-crp-refresh-btn-' + wid);
    const listContainer = document.getElementById('zibtf-crp-list-' + wid);
    const widgetContainer = document.getElementById('zibtf-crp-widget-' + wid);

    function checkFontLoading() {
        const testElement = document.createElement('span');
        testElement.style.position = 'absolute';
        testElement.style.visibility = 'hidden';
        testElement.style.fontFamily = 'AliFont, sans-serif';
        testElement.style.fontSize = '20px';
        testElement.textContent = '今日';
        document.body.appendChild(testElement);
        const aliFontWidth = testElement.offsetWidth;
        testElement.style.fontFamily = 'sans-serif';
        const sansWidth = testElement.offsetWidth;
        
        if (aliFontWidth === sansWidth) {
            widgetContainer.classList.add('font-loading-failed');
            
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = '<?php echo get_template_directory_uri(); ?>/fonts/AlimamaShuHeiTi-Bold.css';
            document.head.appendChild(link);
        }
        
        document.body.removeChild(testElement);
    }

    function bindCardClicks(){
        listContainer.querySelectorAll('.zibtf-article-card').forEach(card => {
            card.onclick = e => {
                if (!e.target.closest('img')) {
                    const link = card.querySelector('.zibtf-article-title a');
                    if(link) window.location.href = link.href;
                }
            };
        });
    }

    function animateCards() {
        listContainer.querySelectorAll('.zibtf-article-card').forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0.5';
                setTimeout(() => card.style.opacity = '1', 200);
            }, index * 100);
        });
    }

    function refreshWidget(){
        if(!refreshBtn || !listContainer) return;
        const icon = refreshBtn.querySelector('.fa');
        icon?.classList.add('zibtf-animate-spin');
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '<?php echo admin_url('admin-ajax.php'); ?>?action=zibtf_refresh_random_posts&posts_num=<?php echo $posts_num; ?>&show_thumbnail=<?php echo $show_thumbnail ? 1 : 0; ?>&show_date=<?php echo $show_date ? 1 : 0; ?>&widget_id=' + wid + '&_=' + Math.random(), true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                icon?.classList.remove('zibtf-animate-spin');
                listContainer.innerHTML = xhr.status === 200 ? xhr.responseText : 
                    '<div class="p-4 text-center text-red-500">加载失败，请重试！</div>';
                if (xhr.status === 200) {
                    animateCards();
                    bindCardClicks();
                    setTimeout(checkFontLoading, 300);
                }
            }
        };
        xhr.send();
    }

    window.addEventListener('load', checkFontLoading);
    refreshBtn?.addEventListener('click', e => { e.preventDefault(); refreshWidget(); });
    document.addEventListener('DOMContentLoaded', bindCardClicks);
})();
</script>
<?php
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, array(
            'posts_num' => 4,
            'title' => '今日精选',
            'show_thumbnail' => true,
            'show_date' => true
        ));
        
        $posts_num = intval($instance['posts_num']);
        $title = esc_attr($instance['title']);
        $show_thumbnail = isset($instance['show_thumbnail']) ? (bool)$instance['show_thumbnail'] : true;
        $show_date = isset($instance['show_date']) ? (bool)$instance['show_date'] : true;
        ?>
        
        <style>
        .zibtf-widget-section {
            margin: 15px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
            border: 1px solid #eee;
        }
        .zibtf-widget-section h4 {
            margin: 0 0 12px;
            padding: 0 0 8px;
            border-bottom: 1px solid #eee;
            color: #23282d;
            font-size: 14px;
        }
        .zibtf-widget-field {
            margin-bottom: 15px;
        }
        .zibtf-widget-field:last-child {
            margin-bottom: 0;
        }
        .zibtf-widget-field label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #555;
        }
        .zibtf-widget-field input[type="text"],
        .zibtf-widget-field input[type="number"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .zibtf-widget-field input[type="checkbox"] {
            margin-right: 6px;
        }
        .zibtf-widget-desc {
            margin-top: 5px;
            font-size: 12px;
            color: #777;
        }
        </style>
        
        <div class="zibtf-widget-section">
            <h4>标题设置</h4>
            <div class="zibtf-widget-field">
                <label for="<?php echo $this->get_field_id('title'); ?>">自定义标题</label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                       name="<?php echo $this->get_field_name('title'); ?>" type="text" 
                       value="<?php echo $title; ?>">
                <p class="zibtf-widget-desc">前两字将自动显示为子比主题色，其余为黑色（示例：输入"每日推荐"则"每日"红、"推荐"黑）</p>
            </div>
        </div>
        
        <div class="zibtf-widget-section">
            <h4>基本设置</h4>
            <div class="zibtf-widget-field">
                <label for="<?php echo $this->get_field_id('posts_num'); ?>">显示文章数量</label>
                <input class="widefat" id="<?php echo $this->get_field_id('posts_num'); ?>" 
                       name="<?php echo $this->get_field_name('posts_num'); ?>" type="number" 
                       value="<?php echo $posts_num; ?>" min="1" max="10">
                <p class="zibtf-widget-desc">设置随机显示的文章数量（1-10篇）</p>
            </div>
        </div>
        
        <div class="zibtf-widget-section">
            <h4>显示设置</h4>
            <div class="zibtf-widget-field">
                <label>
                    <input type="checkbox" id="<?php echo $this->get_field_id('show_thumbnail'); ?>" 
                           name="<?php echo $this->get_field_name('show_thumbnail'); ?>" 
                           <?php checked($show_thumbnail); ?>>
                    显示文章缩略图
                </label>
            </div>
            <div class="zibtf-widget-field">
                <label>
                    <input type="checkbox" id="<?php echo $this->get_field_id('show_date'); ?>" 
                           name="<?php echo $this->get_field_name('show_date'); ?>" 
                           <?php checked($show_date); ?>>
                    显示发布日期
                </label>
            </div>
        </div>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['posts_num'] = intval($new_instance['posts_num']);
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['show_thumbnail'] = isset($new_instance['show_thumbnail']) ? (bool)$new_instance['show_thumbnail'] : false;
        $instance['show_date'] = isset($new_instance['show_date']) ? (bool)$new_instance['show_date'] : false;
        return $instance;
    }
}

add_action('widgets_init', function(){
    register_widget('ZibTF_Custom_Random_Posts_Widget');
});

add_action('wp_ajax_zibtf_refresh_random_posts', 'zibtf_handle_refresh_random_posts');
add_action('wp_ajax_nopriv_zibtf_refresh_random_posts', 'zibtf_handle_refresh_random_posts');

function zibtf_handle_refresh_random_posts() {
    $posts_num = isset($_GET['posts_num']) ? intval($_GET['posts_num']) : 4;
    $show_thumbnail = isset($_GET['show_thumbnail']) ? (bool)$_GET['show_thumbnail'] : true;
    $show_date = isset($_GET['show_date']) ? (bool)$_GET['show_date'] : true;
    
    $random_posts = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => $posts_num,
        'orderby' => 'rand',
        'post_status' => 'publish',
        'no_found_rows' => true,
        'ignore_sticky_posts' => true
    ));

    if ($random_posts->have_posts()) :
        wp_reset_postdata();
        while ($random_posts->have_posts()) : $random_posts->the_post();
            $current_post_id = get_the_ID();
            $img_url = '';
            if (function_exists('zib_get_post_meta')) {
                $img_url = zib_get_post_meta($current_post_id, 'thumbnail_url', true);
            }
            
            if (!$img_url && function_exists('zib_get_post_img_urls')) {
                $post_img_urls = zib_get_post_img_urls(get_post($current_post_id));
                $img_url = isset($post_img_urls[0]) ? $post_img_urls[0] : '';
            }
            
            if (!$img_url && function_exists('zib_get_spare_thumb')) {
                $img_url = zib_get_spare_thumb();
            }

            $lazy_thumb = function_exists('zib_get_lazy_thumb') ? zib_get_lazy_thumb() : '';
            $is_lazy = function_exists('zib_is_lazy') && zib_is_lazy('lazy_posts_thumb');
            $post_title = get_the_title($current_post_id);
            $post_permalink = get_permalink($current_post_id);
            ?>
            <div class="zibtf-article-card">
                <?php if ($show_thumbnail && $img_url) : ?>
                    <?php if ($is_lazy) : ?>
                        <img src="<?php echo esc_url($lazy_thumb); ?>" 
                             data-src="<?php echo esc_url($img_url); ?>" 
                             alt="<?php echo esc_attr($post_title); ?>" 
                             class="zibtf-article-image lazyload">
                    <?php else : ?>
                        <img src="<?php echo esc_url($img_url); ?>" 
                             alt="<?php echo esc_attr($post_title); ?>" 
                             class="zibtf-article-image">
                    <?php endif; ?>
                <?php endif; ?>
                <div class="zibtf-article-info">
                    <h3 class="zibtf-article-title" style="display:block !important;">
                        <a href="<?php echo esc_url($post_permalink); ?>" style="display:inline !important;">
                            <?php echo $post_title ? esc_html($post_title) : '无标题文章'; ?>
                        </a>
                    </h3>
                    <?php if ($show_date) : ?>
                    <div class="zibtf-article-date">
                        <span class="zibtf-date-bar"></span>
                        <span><?php echo get_the_date('', $current_post_id); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<div class="p-4 text-center text-gray-500">没有找到文章</div>';
    endif;
    wp_die();
}