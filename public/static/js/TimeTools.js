var timeTools={
    /**
     * 返回秒时间戳
     * return number
     * */
    timeStamp:function () {
        return parseInt(new Date().getTime()/1000);
    },
    /**
     * 格式化时间 默认返回格式:2018-8-15 9:15:15
     * return string
     * */
    formatTime:function (cFormat) {
        var format=cFormat || 'Y-m-d H:i:s',date;
        date=new Date();

        var formatObj={
            Y:date.getFullYear(),
            m:date.getMonth()+1,
            d:date.getDate(),
            H:date.getHours(),
            i:date.getMinutes(),
            s:date.getSeconds()
        };
        var time_str=format.replace(/(Y|m|d|H|i|s)+/g,(result,key)=>{
            var value=formatObj[key];
            if (result.length>0&&value<10){
                value='0'+value;
            }
            return value ||0;
        });
        return time_str;
    }
};