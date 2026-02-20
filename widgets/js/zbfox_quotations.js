/*
 * @Project     : 古诗一言
 * @Author      : 狐狸库
 * @Url         : https://www.huliku.com/
 * @Qq          : 577669882
 * @Email       : ihuliku@qq.com
 * @Remind      : 使用本代码请务必保留以上信息！
 */
document.addEventListener("DOMContentLoaded", function () {
  var wiiuiiYiYan = zbfoxQuotationsData.poems;
  var wiiuiiYiYanBg = zbfoxQuotationsData.bg_images;
  var wiiuiiYiMain = document.querySelector(".wiiuii-suiji-main"),
    wiuiSjMain = wiiuiiYiMain.parentNode.parentNode,
    date = new Date(),
    wiiuiiMonth = date.getMonth() + 1,
    wiiuiiDay = date.getDate();
  document.querySelector(".wiiuiiYear").innerHTML = date.getFullYear() + "年";
  10 > wiiuiiMonth
    ? (document.querySelector(".wiiuiiMonth").innerHTML =
        "0" + wiiuiiMonth + "月")
    : (document.querySelector(".wiiuiiMonth").innerHTML = wiiuiiMonth + "月");
  10 > wiiuiiMonth &&
    (document.querySelector(".wiiuiiDay").innerHTML = wiiuiiDay + "号");
  wiuiSjMain.style.padding = "0";
  var wiiuiiYyRanBtn = document.querySelector("#xingyu-qh-btn"),
    wiiuiiYiYinTextBox = document.querySelector(".xingyu-yiyin");
  function wiiuiiRanYiYin() {
    var a = Math.floor(Math.random() * wiiuiiYiYanBg.length);
    wiiuiiYiYinTextBox.innerHTML =
      wiiuiiYiYan[Math.floor(Math.random() * wiiuiiYiYan.length)];
    wiiuiiYiMain.style.backgroundImage = "url(" + wiiuiiYiYanBg[a] + ")";
  }
  wiiuiiRanYiYin();
  wiiuiiYyRanBtn.onclick = function () {
    wiiuiiRanYiYin();
  };
  wiiuiiYiYinTextBox.onclick = function () {
    var a = document.querySelector(".xingyu-yiyin").textContent.split("。")[0];
    open("https://so.gushiwen.cn/search.aspx?value=" + a);
  };
});
fetch("/wp-content/themes/zibll/js/yiyan.json")
  .then((response) => {
    if (!response.ok) {
      throw new Error("网络响应不正常");
    }
    return response.json();
  })
  .then((data) => {
    console.log(
      "%c" + data.message,
      "color: #fff;background: linear-gradient(55deg, #212121 0%, #323232 40%, #323232 calc(40% + 1px), #250095 60%, #250095 calc(60% + 1px), #950090 70%, #ff14ed calc(70% + 1px), #6414ff 100%);padding:5px; border-radius: 5px;line-height: 18px;"
    );
  })
  .catch((error) => {
    console.error("您的提取操作出现问题：", error);
  });
