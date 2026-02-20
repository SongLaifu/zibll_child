<?php

/**
 * Template name: Zibll-赞助发电
 * Description:   sidebar page
 */

get_header(); ?>
    <main class="container">
        <div class="content-wrap">
            <div id="percentageCounter"></div>
            <style>
                .yfkj-donate-cover {
                    position: relative;
                    width: 100%;
                    height: 100%;
                    border-radius: var(--main-radius);
                    overflow: hidden;
                    box-sizing: border-box
                }

                .yfkj-donate-cover img {
                    width: 100%;
                    -o-object-fit: cover;
                    object-fit: cover;
                    cursor: pointer;
                    -webkit-user-drag: none
                }

                .yfkj-donate-programme {
                    overflow: hidden
                }

                .yfkj-donate-programme>.yfkj-programme-title {
                    text-align: center;
                    background: linear-gradient(135deg, #16aaf7 0, #c696fc 80%);
                    padding: 10px;
                    font-size: 1.8em;
                    color: #fff;
                }

                .yfkj-programme-content .yfkj-money-wrap {
                    display: flex;
                    flex-direction: row;
                    flex-wrap: wrap
                }

                .yfkj-programme-content .yfkj-money-item {
                    position: relative;
                    width: 100%;
                    height: 180px;
                    margin: 10px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: space-around;
                    border: 1px solid transparent;
                    overflow: hidden;
                    -webkit-transition: transform .5s;
                    transition: transform .5s;
                    box-shadow: 8px 8px 20px 0 rgb(55 99 170 / 10%), -1px -1px 10px 0 #f7aecd;
                }

                .yfkj-programme-content .yfkj-money-item:hover {
                    border-color: #ed6d83;
                    -webkit-transform: translateY(-8px);
                    transform: translateY(-8px);
                    -webkit-transition: transform .5s;
                    transition: transform .5s
                }

                .yfkj-donate-programme .yfkj-money-label {
                    width: 70px;
                    height: 30px;
                    line-height: 30px;
                    background: #fe85ca;
                    ;
                    border-radius: 0 5px 0 10px;
                    font-weight: 700;
                    color: var(--main-bg-color);
                    font-size: 18px;
                    text-align: center;
                    position: absolute;
                    top: -2px;
                    right: -2px
                }

                .yfkj-donate-programme .yfkj-money-icon {
                    width: 90px;
                    height: 90px
                }

                .yfkj-donate-programme .yfkj-money-name {
                    font-size: 1.6em
                }

                @media (min-width:768px) and (max-width:1023px) {
                    .yfkj-donate-cover {
                        height: 350px
                    }

                    .yfkj-programme-content .yfkj-money-item {
                        width: calc(100% / 2 - 20px)
                    }
                }

                @media (min-width:1024px) {
                    .yfkj-donate-cover {
                        height: 350px
                    }

                    .yfkj-programme-content .yfkj-money-item {
                        width: calc(100% / 3 - 20px)
                    }
                }

                .modal-content {
                    overflow: hidden
                }

                .yfkj-modal-body {
                    background: var(--body-bg-color)
                }

                .yfkj-donate-modal-zfm {
                    position: relative;
                    text-align: center;
                    background: var(--main-bg-color);
                    overflow: hidden;
                    border-radius: var(--main-radius)
                }

                .yfkj-donate-modal-zfm::after,
                .yfkj-donate-modal-zfm::before {
                    position: absolute;
                    content: "";
                    width: 35px;
                    height: 35px;
                    background: var(--body-bg-color);
                    border-radius: 99px;
                    top: 6.8rem
                }

                .yfkj-donate-modal-zfm::before {
                    left: -17px
                }

                .yfkj-donate-modal-zfm::after {
                    right: -17px
                }

                .yfkj-donate-modal-zfm img {
                    width: auto;
                    height: 180px
                }

                .yfkj-donate-modal-title {
                    margin: 1rem;
                    border-bottom: .25rem dashed var(--main-border-color)
                }

                .yfkj-donate-modal-title b {
                    font-size: 2rem
                }

                .yfkj-donate-modal-ewm {
                    padding: 1rem
                }

                .yfkj-donate-modal-btn {
                    padding: 15px
                }

                .yfkj-donate-btns {
                    display: inline-block;
                    background: var(--main-border-color);
                    border-radius: 99px;
                    border: 1px solid var(--main-border-color);
                    overflow: hidden
                }

                .btn.focus,
                .btn:focus,
                .btn:hover {
                    color: var(--key-color) !important
                }

                .yfkj-donate-btns .yfkj-zf-btn {
                    border-radius: 99px;
                    background: 0 0;
                    transition: all .5s
                }

                .yfkj-donate-btns .yfkj-zf-btn.yfkj-active {
                    background: var(--main-bg-color)
                }

                /*说明*/
                .yfkj-text-title {
                    font-size: 18px;
                    font-weight: 200;
                    color: #ffa0a0;
                }

                .yfkj-text-title>i {
                    padding: 0 8px 0 5px;
                    margin-right: 5px;
                    color: #fff;
                    background: #feaa71;
                    border-radius: var(--main-radius)
                }

                .yfkj-text-content {
                    padding: 0 10px
                }

                .yfkj-text-content {
                    font-size: 16px
                }

                .yfkj-serve-content>.yfkj-serve-item {
                    padding-left: 1em;
                    font-size: 16px;
                    list-style: inside !important
                }

                .yfkj-serve-content>.yfkj-serve-item>b {
                    color: var(--wp--preset--color--vivid-red)
                }

                .feature-icon img {
                    width: 60px;
                    height: auto
                }

                .yfkjco {
                    box-shadow: 0 0 10px rgb(227 228 228)
                }

                /*é¦–é¡µå¿«é€Ÿå¯¼èˆª*/
                .jitheme-container {
                    /* margin-top: 0px!important; */
                }

                .jitheme-background-default {
                    background-color: #fff;
                }

                .jitheme_slide_ss {
                    display: flex;
                    -ms-flex-wrap: wrap;
                    flex-wrap: wrap;
                    margin-left: -20px;
                }

                .jitheme_slide_jb {
                    position: relative;
                    margin-bottom: 30px !important;
                }

                .jitheme_slide_n {
                    display: flex;
                    margin: 0 auto;
                    padding-top: 10px;
                    height: 60px;
                    color: #fff;
                    font-size: 14px;
                    justify-content: space-between;
                }

                .jitheme_slide_n .jitheme_slide_s {
                    position: relative;
                    display: inline-block;
                    padding: 0 30px;
                    height: 40px;
                    border-radius: 73px;
                    background: none;
                    vertical-align: middle;
                    text-align: center;
                    line-height: 40px
                }

                .jitheme_slide_n .jitheme_slide_s ul {
                    float: left;
                    margin: 0 auto
                }

                .jitheme_slide_n .jitheme_slide_s li {
                    float: left;
                    margin-right: 40px
                }

                .jitheme_slide_n .jitheme_slide_s li .first {
                    color: var(--b2color)
                }

                .jitheme_slide_n .jitheme_slide_s li a {
                    float: left;
                    color: #606075;
                    font-weight: 200;
                    font-size: 14px;
                }

                .jitheme_slide_n .jitheme_slide_y {
                    /* font-weight:600; */
                    position: relative;
                    display: inline-block;
                    padding: 0 40px;
                    height: 40px;
                    background: none;
                    vertical-align: middle;
                    text-align: center;
                    line-height: 40px;
                }

                .jitheme_slide_n .jitheme_slide_y a {
                    margin-left: 40px;
                    color: #ff3355;
                }

                .jitheme_slide_d {
                    padding-left: 20px;
                    flex: 0 0 25%;
                    box-sizing: border-box;
                    width: 100%;
                    max-width: 100%
                }

                .jitheme-dt:hover {
                    transform: translateY(-3px);
                    -webkit-transform: translateY(-3px);
                    -ms-transform: translateY(-3px);
                    transform: translateY(-3px);
                }

                .jitheme_slide_d .mini-stats {
                    position: relative;
                    display: -ms-flexbox;
                    display: flex;
                    -ms-flex-direction: column;
                    flex-direction: column;
                    min-width: 0;
                    word-wrap: break-word;
                    transition: all .3s;
                    background-color: var(--body-bg-color);
                    background-clip: border-box;
                    border: 1px solid rgba(0, 0, 0, .125);
                    border: none;
                    -webkit-box-shadow: 0 0 1.25rem rgba(108, 118, 134, 0.1);
                    box-shadow: 0 0 1.25rem rgba(108, 118, 134, 0.1);
                    overflow: hidden;
                    border-radius: var(--main-radius);
                }

                .jitheme_slide_d .mini-stats:hover {
                    transform: translateY(-3px);
                    -webkit-transform: translateY(-3px);
                    -ms-transform: translateY(-3px);
                    transform: translateY(-3px);
                }

                .mini-stats .mini-stats-content {
                    padding: 10px 15px 15px 15px !important
                }

                .jitheme_slide_d_mb4,
                .my-4 {
                    margin-bottom: 15px !important
                }

                .jitheme_slide_d_right {
                    text-align: right !important;
                    color: rgba(255, 255, 255, .5) !important
                }

                .jitheme_slide_d_right span {
                    margin-top: .5rem !important;
                    background-color: #f8f9fa;
                    margin-bottom: .5rem !important;
                    color: #f27d7d;
                    display: inline-block;
                    padding: .25em .4em;
                    font-size: 75%;
                    font-weight: 700;
                    line-height: 1;
                    text-align: center;
                    white-space: nowrap;
                    vertical-align: baseline;
                    border-radius: .25rem;
                    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out
                }

                .jitheme_slide_d_right p {
                    color: #fff
                }

                .jitheme_slide_d_m {
                    margin-left: 15px !important;
                    margin-right: 15px !important;
                }

                .jitheme_slide_d_m .mini-stats-desc {
                    display: inline-block;
                    position: relative;
                    bottom: 22px;
                    height: 100%;
                    -webkit-box-shadow: 0 0 1.25rem rgba(108, 118, 134, 0.1);
                    box-shadow: 0 0 1.25rem rgba(108, 118, 134, 0.1);
                    background-color: var(--body-bg-color) !important;
                    padding: 10px !important;
                    display: flex;
                    -ms-flex-wrap: wrap;
                    flex-wrap: wrap;
                    border-radius: var(--main-radius);
                }

                .jitheme_slide_d_m .mini-stats-desc li {
                    float: left;
                    flex: 0 0 33.33333%;
                    box-sizing: border-box;
                    width: 100%;
                    max-width: 100%;
                }

                .jitheme_slide_d_m .mini-stats-desc a {
                    display: block;
                    /* height:60px; */
                    /* padding:12px 15px 15px 15px; */
                }

                .jitheme_slide_d_m .mini-stats-desc a:hover {
                    color: var(--primary-color) !important
                }

                .jitheme_slide_d_m .mini-stats-desc a img {
                    display: block;
                    width: 58px;
                    height: 45px;
                    margin: 0 auto 5px
                }

                .jitheme_slide_d_m .mini-stats-desc p {
                    display: block;
                    height: 20px;
                    line-height: 20px;
                    overflow: hidden;
                    font-size: 12px;
                    color: #5f5f5f;
                    text-align: center;
                }

                .jitheme_slide_n ol,
                ul,
                li {
                    list-style: none;
                }

                .widget_text.zib-widget.widget_custom_html {
                    padding: 0px;
                }

                .mini-stats-desc.b2-radius li:not(article):hover {
                    opacity: 1;
                    z-index: 99;
                    border-radius: 20px;
                    transform: translateY(-5px);
                    box-shadow: 0 3px 20px rgba(0, 0, 0, .25);
                    animation: index-link-active 1s cubic-bezier(0.315, 0.605, 0.375, 0.925) forwards;
                }

                @keyframes index-link-active {
                    0% {
                        transform: perspective(2000px) rotateX(0) rotateY(0) translateZ(0);
                    }

                    16% {
                        transform: perspective(2000px) rotateX(10deg) rotateY(5deg) translateZ(32px);
                    }

                    100% {
                        transform: perspective(2000px) rotateX(0) rotateY(0) translateZ(65px);
                    }
                }

                @media (max-width: 767px) {
                    .jitheme_slide_d {
                        padding-left: 20px;
                        flex: 0 0 100%;
                        box-sizing: border-box;
                        width: 100%;
                        max-width: 100%;
                    }

                    @media only screen and (max-width:1100px) {
                        .textwidget.custom-html-widget {
                            display: none !important
                        }
                    }
                }
            </style>
            <main class="container">
                <div class="content-wrap">
                    <div class="content-layout">
                        <div class="yfkj-donate-programme mb20 main-bg main-shadow radius8">
                            <div class="yfkj-programme-title">
                                <section data-id="124069" class="yfkjeditor style_1" powered-by="#" draggable="true" data-md5="023bb">
                                    <section style="text-align: center;" powered-by="#" data-md5="023bb" class="style_2">
                                        <section style="display: inline-block;vertical-align:middle;" powered-by="#" data-md5="023bb" class="style_3">
                                            <section style="display: flex;align-items: center;justify-content: space-between;" powered-by="#" data-md5="023bb" class="style_4">
                                                <section style="width: 7px;height: 7px;border:1px solid #ffcd59;border-radius: 50%;box-sizing: border-box;transform: translate(52px,5px);" powered-by="#" data-md5="023bb" class="style_5"></section>
                                                <section style="width:21px;margin: 0 -9px 8px auto;line-height:2px;" powered-by="#" data-md5="023bb" class="style_6"><img src="/wp-content/plugins/Zibll-Extensions/pages/img/zhanzu5.webp" style="vertical-align:middle;width:100%;" class="small_image style_7" _src="/wp-content/plugins/Zibll-Extensions/pages/img/zhanzu5.webp" data-isstyleimage="1" draggable="false" data-md5="023bb"></section>
                                            </section>
                                            <section style="display: flex;align-items: center;justify-content: center;" powered-by="#" data-md5="023bb" class="style_8">
                                                <section style="width: 28px;height: 28px;background-color: #85d6ac;border-radius: 4px;margin:0 8px;transform-origin: right bottom;transform: rotate(16deg);" powered-by="#" class="yfkj-banone style_9" data-md5="023bb">
                                                    <section class="wxqq-Color style_10" style="color: #fff;letter-spacing: 1px;line-height: 28px;text-align:center;font-size: 16px;font-weight: bold;" powered-by="#" data-md5="023bb">
                                                        <p class="yfkjbrush style_11" style="padding: 0px;margin: 0px;" data-md5="023bb">赞</p>
                                                    </section>
                                                </section>
                                                <section style="width: 28px;height: 28px;background-color: #ff8566;border-radius: 4px;margin:0 8px;transform-origin: left bottom;transform: rotate(-16deg);" powered-by="#" class="yfkj-banone style_12" data-md5="023bb">
                                                    <section class="wxqq-Color style_13" style="color: #fff;letter-spacing: 1px;line-height: 28px;text-align:center;font-size: 16px;font-weight: bold;" powered-by="#" data-md5="023bb">
                                                        <p class="yfkjbrush style_14" style="padding: 0px;margin: 0px;" data-md5="023bb">助</p>
                                                    </section>
                                                </section>
                                                <section style="width: 28px;height: 28px;background-color: #ffcd59;border-radius: 4px;transform-origin: right top;transform: rotate(16deg);" powered-by="#" class="yfkj-banone style_15" data-md5="023bb">
                                                    <section class="wxqq-Color style_16" style="color: #fff;letter-spacing: 1px;line-height: 28px;text-align:center;font-size: 16px;font-weight: bold;" powered-by="#" data-md5="023bb">
                                                        <p class="yfkjbrush style_17" style="padding: 0px;margin: 0px;" data-md5="023bb">方</p>
                                                    </section>
                                                </section>
                                                <section style="width: 28px;height: 28px;background-color: #7fceff;border-radius: 4px;margin:0 2px;transform-origin: left top;transform: rotate(-16deg);" powered-by="#" class="yfkj-banone style_18" data-md5="023bb">
                                                    <section class="wxqq-Color style_19" style="color: #fff;letter-spacing: 1px;line-height: 28px;text-align:center;font-size: 16px;font-weight: bold;" powered-by="#" data-md5="023bb">
                                                        <p class="yfkjbrush style_20" style="padding: 0px;margin: 0px;" data-md5="023bb">案</p>
                                                    </section>
                                                </section>
                                            </section>
                                            <section style="display: flex;align-items: center;justify-content: space-between;margin-top: -7px;" powered-by="#" data-md5="023bb" class="style_21">
                                                <section style="width: 7px;height: 7px;border:1px solid #ffab4c;border-radius: 50%;box-sizing: border-box;transform: translate(7px,-11px);" powered-by="#" data-md5="023bb" class="style_22"></section>
                                                <section style="width: 7px;height: 7px;border:1px solid #85d6ac;border-radius: 50%;box-sizing: border-box;transform: translate(-27px,5px);" powered-by="#" data-md5="023bb" class="style_23"></section>
                                            </section>
                                        </section>
                                    </section>
                                </section>
                            </div>
                            <div class="yfkj-programme-content">
                                <ul class="yfkj-money-wrap">
                                    <li data-pay="10" class="yfkjco yfkj-money-item main-shadow radius8">
                                        <span class="yfkj-money-label">￥10</span>
                                        <img class="yfkj-money-icon" src="<?php echo get_plugin_url() . "/pages/img/1.webp" ?>" alt="一个鸡腿" draggable="false" />
                                        <b class="yfkj-money-name">一个鸡腿</b>
                                    </li>
                                    <li data-pay="20" class="yfkjco yfkj-money-item main-shadow radius8">
                                        <span class="yfkj-money-label">￥20</span>
                                        <img class="yfkj-money-icon" src="<?php echo get_plugin_url() . "/pages/img/2.webp" ?>" alt="一杯咖啡" draggable="false" />
                                        <b class="yfkj-money-name">一杯咖啡</b>
                                    </li>
                                    <li data-pay="30" class="yfkjco yfkj-money-item main-shadow radius8">
                                        <span class="yfkj-money-label">￥30</span>
                                        <img class="yfkj-money-icon" src="<?php echo get_plugin_url() . "/pages/img/4.webp" ?>" alt="一个汉堡" draggable="false" />
                                        <b class="yfkj-money-name">一个汉堡</b>
                                    </li>
                                    <li data-pay="50" class="yfkjco yfkj-money-item main-shadow radius8">
                                        <span class="yfkj-money-label">￥50</span>
                                        <img class="yfkj-money-icon" src="<?php echo get_plugin_url() . "/pages/img/5.webp" ?>" alt="一份肯德基套餐" draggable="false" />
                                        <b class="yfkj-money-name">一份肯德基套餐</b>
                                    </li>
                                    <li data-pay="100" class="yfkjco yfkj-money-item main-shadow radius8">
                                        <span class="yfkj-money-label">￥100</span>
                                        <img class="yfkj-money-icon" src="<?php echo get_plugin_url() . "/pages/img/3.webp" ?>" alt="一份全家桶" draggable="false" />
                                        <b class="yfkj-money-name">一份全家桶</b>
                                    </li>
                                    <li data-pay="zdy" class="yfkjco yfkj-money-item main-shadow radius8">
                                        <span class="yfkj-money-label">自定义</span>
                                        <img class="yfkj-money-icon" src="<?php echo get_plugin_url() . "/pages/img/6.webp" ?>" alt="爱心红包" draggable="false" />
                                        <b class="yfkj-money-name dsjb">爱心红包</b>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="yfkj-donate-programme mb20 main-bg main-shadow radius8">
                            <div class="yfkj-programme-content box-body theme-box">
                                <!--1-->
                                <section data-id="48353" class="yfkjeditor style_1" data-type="lspecial02,lspecial06" powered-by="#" draggable="true" data-md5="2ece3">
                                    <section style="box-sizing: border-box;padding-bottom:2px;" powered-by="#" data-md5="2ece3" class="style_2">
                                        <section style="display:-webkit-box;-webkit-box-pack:center;-webkit-box-align:end;" powered-by="#" data-md5="2ece3" class="style_3">
                                            <section class="wxqq-borderBottomColor wxqq-borderTopColor wxqq-borderRightColor wxqq-borderLeftColor style_4" style="box-sizing: border-box;border:2px solid #FF977B;padding:1px 0;transform:rotate(0deg);-ms-transform:rotate(0deg);-moz-transform:rotate(0deg);-webkit-transform:rotate(0deg);-o-transform:rotate(0deg);" powered-by="#" data-md5="2ece3">
                                                <section style="background-color:#FFDBBB;box-sizing: border-box;padding:0 5px;margin:1px -4px -6px 4px;" powered-by="#" class="yfkj-bacolor style_5" data-bastyle="background-color:#FFDBBB;box-sizing: border-box;padding:0 5px;margin:1px -4px -6px 4px;" data-md5="2ece3">
                                                    <section class="wxqq-Color style_6" style="color: #FF1856;letter-spacing: 1px;line-height: 24px;text-align:center;" powered-by="#" data-md5="2ece3">
                                                        <p class="yfkjbrush style_7" style="padding: 0px;margin: 0px;font-size: 14px;" data-md5="2ece3"><b>NO.</b><span class="autosort style_8" data-md5="2ece3"><b>01</b></span></p>
                                                    </section>
                                                </section>
                                            </section>
                                            <section style="-webkit-box-flex: 1;width: 0;margin-bottom:1px;" powered-by="#" data-md5="2ece3" class="style_9">
                                                <section class="wxqq-Color style_10" style="color: #FF1856;letter-spacing: 1px;line-height: 21px;text-align: justify;margin-left:8px;" powered-by="#" data-md5="2ece3">
                                                    <p class="yfkjbrush style_11" style="padding: 0px;margin: 0px;font-size: 18px;" data-md5="2ece3">
                                                        <b>本站会努力坚持做到：</b>
                                                    </p>
                                                </section>
                                                <section class="wxqq-borderTopColor style_12" style="width:100%;height:0px;box-sizing: border-box;border-top:2px solid #FF977B;" powered-by="#" data-md5="2ece3"></section>
                                            </section>
                                        </section>
                                    </section>
                                </section>
                                <hr />
                                <div class="yfkj-text-wrap">
                                    <div class="wp-block-zibllblock-feature feature yfkjco feature-default" data-icon="fa-flag">
                                        <div class="feature-icon"><img class="icon" src="<?php echo get_plugin_url() . "/pages/img/zhanzu1.svg" ?>" /></div>
                                        <div class="feature-title"><b>优质教程</b></b></div>
                                        <div class="feature-note">所有发布的教程几乎不收费</div>
                                    </div>
                                    <div class="wp-block-zibllblock-feature feature yfkjco feature-default" data-icon="fa-flag">
                                        <div class="feature-icon"><img class="icon" src="<?php echo get_plugin_url() . "/pages/img/zhanzu2.svg" ?>" /></div>
                                        <div class="feature-title"><b>更新维护</b></div>
                                        <div class="feature-note">定期更新与维护文章教程</div>
                                    </div>
                                    <div class="wp-block-zibllblock-feature feature yfkjco feature-default" data-icon="fa-flag">
                                        <div class="feature-icon"><img class="icon" src="<?php echo get_plugin_url() . "/pages/img/zhanzu3.svg" ?>" /></div>
                                        <div class="feature-title"><b>下载提速</b></div>
                                        <div class="feature-note">所有文件本地下载，高效提速</div>
                                    </div>
                                    <div class="wp-block-zibllblock-feature feature yfkjco feature-default" data-icon="fa-flag">
                                        <div class="feature-icon"><img class="icon" src="<?php echo get_plugin_url() . "/pages/img/zhanzu4.svg" ?>" /></div>
                                        <div class="feature-title"><b>永无广告</b></div>
                                        <div class="feature-note">网站几乎纯净无任何广告</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 支付弹窗 -->
                <div class="wp-block-zibllblock-modal yfkji-donate-modal">
                    <div class="modal fade" id="yfkj_donate-modal" aria-hidden="true" data-bkg1="false" aria-bkg2="false" role="dialog" tabindex="-1">
                        <div class="modal-dialog modal-mini" data-kd="modal-mini">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <strong class="modal-title">扫码赞助</strong>
                                    <button class="close" data-dismiss="modal">
                                        <div data-class="ic-close" data-svg="close" data-viewbox="0 0 1024 1024"></div>
                                    </button>
                                </div>
                                <div class="yfkj-modal-body modal-body">
                                    <div class="yfkj-donate-modal-zfm modal-body">
                                        <div class="yfkj-donate-modal-title dsjb">
                                            <b>赞助发电❤支持本站</b>
                                            <p class="yfkji_pay-title">加载中...</p>
                                        </div>
                                        <div class="yfkj-donate-modal-ewm">
                                            <img src="" draggable="false" />
                                        </div>
                                        <p>长按保存支付二维码</p>
                                        <div class="yfkj-donate-modal-btn">
                                            <div class="yfkj-donate-btns">
                                                <button data-type="wx" class="btn yfkj-zf-btn yfkj-active">微信支付</button>
                                                <button data-type="zfb" class="btn yfkj-zf-btn">支付宝支付</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var pay_money = 'zdy',
                        pay_type = "wx";

                    function actv_zf_func(pay_ty) {
                        $(".yfkj-zf-btn").each(function() {
                            $(this).attr("data-type") === pay_ty ? $(this).addClass('yfkj-active') : $(this).removeClass('yfkj-active');
                        });
                        $(".yfkj-donate-modal-ewm>img").attr("src", "/wp-content/plugins/Zibll-Extensions/pages/img/" + pay_ty + "/zdy.jpg");
                    }
                    $(".yfkj-programme-content").on("click", ".yfkj-money-item", function() {
                        pay_money = $(this).attr("data-pay");
                        pay_type = "wx";
                        var pay_title = $(this).find('.yfkj-money-name').text();
                        var pay_text = pay_money === 'zdy' ? '请扫码自定义金额' : "￥ " + pay_money;
                        $(".yfkj-donate-modal-title>.yfkji_pay-title").html(pay_title + "（" + pay_text + "）");
                        actv_zf_func(pay_type);
                        $('#yfkj_donate-modal').modal('show');
                    });
                    $(".yfkji-donate-modal").on("click", ".yfkj-zf-btn", function() {
                        pay_type = $(this).attr("data-type");
                        actv_zf_func(pay_type);
                    });
                </script>

        </div>
        </div>
        </div>
    </main>
<?php get_footer(); ?>