function TimeGeneration() {}

TimeGeneration.prototype = {
  constructor: TimeGeneration,

  WEEKDAY_NAME: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
  NUMBER_STRING: "一二三四五六七八九十",
  MONTH_STRING: "正二三四五六七八九十冬腊",
  MONTH_ADD: [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334],
  CALENDAR_DATA: [
    0xa4b, 0x5164b, 0x6a5, 0x6d4, 0x415b5, 0x2b6, 0x957, 0x2092f, 0x497,
    0x60c96, 0xd4a, 0xea5, 0x50da9, 0x5ad, 0x2b6, 0x3126e, 0x92e, 0x7192d,
    0xc95, 0xd4a, 0x61b4a, 0xb55, 0x56a, 0x4155b, 0x25d, 0x92d, 0x2192b, 0xa95,
    0x71695, 0x6ca, 0xb55, 0x50ab5, 0x4da, 0xa5b, 0x30a57, 0x52b, 0x8152a,
    0xe95, 0x6aa, 0x615aa, 0xab5, 0x4b6, 0x414ae, 0xa57, 0x526, 0x31d26, 0xd95,
    0x70b55, 0x56a, 0x96d, 0x5095d, 0x4ad, 0xa4d, 0x41a4d, 0xd25, 0x81aa5,
    0xb54, 0xb6a, 0x612da, 0x95b, 0x49b, 0x41497, 0xa4b, 0xa164b, 0x6a5, 0x6d4,
    0x615b4, 0xab6, 0x957, 0x5092f, 0x497, 0x64b, 0x30d4a, 0xea5, 0x80d65,
    0x5ac, 0xab6, 0x5126d, 0x92e, 0xc96, 0x41a95, 0xd4a, 0xda5, 0x20b55, 0x56a,
    0x7155b, 0x25d, 0x92d, 0x5192b, 0xa95, 0xb4a, 0x416aa, 0xad5, 0x90ab5,
    0x4ba, 0xa5b, 0x60a57, 0x52b, 0xa93, 0x40e95,
  ],

  _getBit: function (m, n) {
    return (m >> n) & 1;
  },

  // 获取时间 array
  getTime: function () {
    var time = new Date();
    return [
      parseInt(time.getHours() / 10),
      parseInt(time.getHours() % 10),
      parseInt(time.getMinutes() / 10),
      parseInt(time.getMinutes() % 10),
      parseInt(time.getSeconds() / 10),
      parseInt(time.getSeconds() % 10),
    ];
  },

  // 获取公历日期 array
  getDate: function () {
    var date = new Date();
    return [
      date.getMonth() + 1,
      date.getDate(),
      this.WEEKDAY_NAME[date.getDay()],
    ];
  },

  // 获取农历日期 string
  getCalendarDate: function () {
    var calendar = new Date();
    var tmp = calendar.getFullYear();

    if (tmp < 1900) {
      tmp += 1900;
    }

    var total =
      (tmp - 1921) * 365 +
      Math.floor((tmp - 1921) / 4) +
      this.MONTH_ADD[calendar.getMonth()] +
      calendar.getDate() -
      38;
    if (calendar.getFullYear() % 4 == 0 && calendar.getMonth() > 1) {
      total++;
    }

    var isEnd = false;
    var n, m, k;
    for (m = 0; ; m++) {
      k = this.CALENDAR_DATA[m] < 0xfff ? 11 : 12;
      for (n = k; n >= 0; n--) {
        if (total <= 29 + this._getBit(this.CALENDAR_DATA[m], n)) {
          isEnd = true;
          break;
        }
        total = total - 29 - this._getBit(this.CALENDAR_DATA[m], n);
      }
      if (isEnd) break;
    }

    var month = k - n + 1;
    var day = total;

    if (k == 12) {
      if (month == Math.floor(this.CALENDAR_DATA[m] / 0x10000) + 1) {
        month = 1 - month;
      }
      if (month > Math.floor(this.CALENDAR_DATA[m] / 0x10000) + 1) {
        month--;
      }
    }

    var tmp = "";
    if (month < 1) {
      tmp += "(闰)";
      tmp += this.MONTH_STRING.charAt(-month - 1);
    } else {
      tmp += this.MONTH_STRING.charAt(month - 1);
    }

    tmp += "月";
    tmp += day < 11 ? "初" : day < 20 ? "十" : day < 30 ? "廿" : "三十";
    if (day % 10 != 0 || day == 10) {
      tmp += this.NUMBER_STRING.charAt((day - 1) % 10);
    }
    return tmp;
  },
};
