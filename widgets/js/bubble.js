(function () {
  var canvas,
    ctx,
    width,
    height,
    bubbles,
    animateHeader = true;
  function initHeader() {
    canvas = document.getElementById("bubble_canvas");
    window_resize();
    ctx = canvas.getContext("2d");
    bubbles = [];
    var num = width * 0.04;
    for (var i = 0; i < num; i++) {
      var c = new Bubble();
      bubbles.push(c);
    }
    animate();
  }
  function animate() {
    if (animateHeader) {
      ctx.clearRect(0, 0, width, height);
      for (var i in bubbles) {
        bubbles[i].draw();
      }
    }
    requestAnimationFrame(animate);
  }
  function window_resize() {
    width = window.innerWidth;
    height = canvas.offsetHeight;
    canvas.width = width;
    canvas.height = height;
  }
  window.onresize = window_resize;
  function Bubble() {
    var _this = this;
    (function () {
      _this.pos = {};
      init();
    })();
    function init() {
      _this.pos.x = Math.random() * width;
      _this.pos.y = height + Math.random() * 100;
      _this.alpha = 0.2 + Math.random() * 0.5;
      _this.scale = 0.5 + Math.random() * 0.5;
      _this.speed = 0.5 + Math.random() * 0.005;
      _this.maxAlpha = _this.alpha;
      _this.fadeStart = height * 0.3 + Math.random() * height * 0.3;
    }
    this.draw = function () {
      if (_this.alpha <= 0 || _this.pos.y < -10) {
        init();
      }
      _this.pos.y -= _this.speed;
      if (_this.pos.y < _this.fadeStart) {
        _this.alpha = Math.max(0, _this.alpha - 0.005);
      }
      ctx.beginPath();
      ctx.arc(
        _this.pos.x,
        _this.pos.y,
        _this.scale * 10,
        0,
        2 * Math.PI,
        false
      );
      ctx.fillStyle = "rgba(255, 255, 255," + _this.alpha + ")";
      ctx.fill();
    };
  }
  initHeader();
})();
