function formatDate(val) {
    // 格式化时间
    let start = new Date(val)
    let y = start.getFullYear()
    let m = (start.getMonth() + 1) > 10 ? (start.getMonth() + 1) : '0' + (start.getMonth() + 1)
    let d = start.getDate() > 10 ? start.getDate() : '0' + start.getDate()
    return y + '-' + m + '-' + d
}

function mistiming(sDate1, sDate2) {
    // 计算开始和结束的时间差
    let aDate, oDate1, oDate2, iDays
    aDate = sDate1.split('-')
    oDate1 = new Date(aDate[1] + '-' + aDate[2] + '-' + aDate[0])
    aDate = sDate2.split('-')
    oDate2 = new Date(aDate[1] + '-' + aDate[2] + '-' + aDate[0])
    iDays = parseInt(Math.abs(oDate1 - oDate2) / 1000 / 60 / 60 / 24)
    return iDays + 1
}

function countDate(start, end) {
    // 判断开始和结束之间的时间差是否在90天内
    let days = mistiming(start, end);
    let stateT = days > 90 ? Boolean(0) : Boolean(1);
    return {
        state: stateT,
        day: days
    }
}

function timeForMat(count, end = null) {
    let array = [];
    // 拼接时间
    if (count == 1) {
        let time = new Date();
        array.push(timess(time, 1));
    } else {
        for (let i = 0; i < count; i++) {
            let time = new Date();
            if (end != null) {
                time = new Date(end);
            }
            let timer = timess(time, i);
            array.push(timer)
        }
    }

    return array.reverse()
}

function timess(time, i) {
    time.setTime(time.getTime() - (24 * 60 * 60 * 1000 * i));
    let Y = time.getFullYear();
    let M = ((time.getMonth() + 1) > 10 ? (time.getMonth() + 1) : '0' + (time.getMonth() + 1));
    let D = (time.getDate() >= 10 ? time.getDate() : '0' + time.getDate());
    let timer = Y + '-' + M + '-' + D;// 之前的7天或者30天
    return timer;
}

function timeBetween(count, end) {
    let timer = timeForMat(count, end);
    return timer;

}

function yesterday(time, type = null) {
    // 校验是不是选择的昨天
    var now = new Date();
    var yesterday = now.getTime() - (24 * 60 * 60 * 1000 * 1);
    var day = new Date(time);
    day = day.getTime();
    if (type == 1) {
        yesterday = now.getTime();
    }
    if (day <= yesterday) {
        timer = 1;
    } else {
        timer = 0;
    }

    return timer;
}

function sevenDays() {
    // 获取最近7天
    let timer = timeForMat(7);
    return timer
}

function thirtyDays() {
    // 获取最近30天
    let timer = timeForMat(30);
    return timer
}

function betweenDays(start, end) {
    var first = new Date(start);
    first = first.getTime();
    var last = new Date(end);
    last = last.getTime();
    var days = ((last - first) / 1000 / 60 / 60 / 24)+1;
    return days;
}


