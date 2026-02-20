if (window.location.hostname != 'localhost') {
  
  ((function () {
    var callbacks = [],
      timeLimit = 50,
      open = false;
    setInterval(loop, 1);
    return {
      addListener: function (fn) {
        callbacks.push(fn);
      },
      cancleListenr: function (fn) {
        callbacks = callbacks.filter(function (v) {
          return v !== fn;
        });
      }
    }
    function loop() {
      var startTime = new Date();
      debugger;
      if (new Date() - startTime > timeLimit) {
        if (!open) {
          callbacks.forEach(function (fn) {
            fn.call(null);
          });
        }
        open = true;
        window.stop();
        alert('禁止查看');
        window.location.reload();
      } else {
        open = false;
      }
    }
  })())
  .addListener(function () {
    window.location.reload();
  });
    
  document.oncontextmenu = new Function("event.returnValue=false"); //禁用右键
  document.onselectstart = new Function("event.returnValue=false"); //禁用选择
  document.οnkeydοwn = new Function("event.returnValue=false"); //禁止f12
  
  // 上面的禁止f12那段代码没有生效，但是加了下面这段就能生效。
  document.onkeydown = function (e) {
    if (e && e.keyCode === 123 || e && e.keyCode === 85 || e && e.keyCode === 83) {
      e.returnValue = false;
      // e.keyCode = 0   //去掉也可以的，倘若要写，则需要setter 以及 getter配合使用，不配合，会报错
      return false;
    }
  };
  
}