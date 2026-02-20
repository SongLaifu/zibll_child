<?php
// Template name: Zibll-视频解析
get_header();?>
  <style>
    .container {
      max-width: 60%;
    }

    .well-lg {
      padding: 4px;
    }

    .form-control {
      border-color: rgba(128, 128, 128, 0.5);
      /* 设置边框颜色为透明灰色，其中RGB值为128,128,128，透明度为0.5 */
    }
  </style>
  <main class="container">
    <div class="content-wrap">
      <div class="content-layout">
        <!--主页-->
        <div id="kj" class="well-lg">
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.jq22.com/demo/threeDimensionalView202301302129/" style="background-color: black;" id="player" allowfullscreen="allowfullscreen"></iframe>
          </div>
        </div>
        <!--主页-->
        <div class="well-lg">
          <div class="input-group input-group-lg">
            <span class="input-group-addon">接口</span>
            <select id="jk" class="form-control">
              <option value="https://jx.xmflv.cc/?url=">推荐解析接口</option>
            </select>
          </div>
        </div>
        <!--主页-->
        <div class="well-lg">
          <div class="input-group input-group-lg">
            <span class="input-group-addon" id="basic-addon1">地址</span>
            <input id="url" type="text" class="form-control" placeholder="请输入播放地址(支持腾讯、爱奇艺、优酷等等VIP视频)" aria-describedby="basic-addon1">
            <span class="input-group-btn">
              <button id="bf" class="btn btn-default" type="button" onclick="dihejk()">播放</button>
            </span>
          </div>
        </div>
        <!--主页-->
      </div>
    </div>
  </main>
  <script type="text/javascript">
    eval(function(p, a, c, k, e, d) {
      e = function(c) {
        return (c < a ? "" : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
      };
      if (!''.replace(/^/, String)) {
        while (c--) d[e(c)] = k[c] || e(c);
        k = [function(e) {
          return d[e]
        }];
        e = function() {
          return '\\w+'
        };
        c = 1
      };
      while (c--)
        if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
      return p
    }('b a(){0 6=1.2("9").4;0 5=1.2("3");0 3=1.2("3").c;0 8=5.e[3].4;0 7=1.2("f");7.d=8+6}', 16, 16, 'var|document|getElementById|jk|value|jkurl|diz|cljurl|jkv|url|dihejk|function|selectedIndex|src|options|player'.split('|'), 0, {}))

    function dihejk2() {
      var diz = document.getElementById("url").value;
      var jkurl = document.getElementById("jk");
      var jk = document.getElementById("jk").selectedIndex;
      var jkv = jkurl.options[jk].value;
      var cljurl = document.getElementById("player");
      window.open(jkv + diz, "_blank");
    }
  </script>
<?php get_footer(); ?>