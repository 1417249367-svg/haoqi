function GetFolder(str){
    var p=str.lastIndexOf("/");
    return str.substr(0,p+1);
}

function getFullFileName(str){
    str=str.replace(/\\/g,"/");
    str=str.replace("}","");
    var p=str.lastIndexOf('/');
    return str.substr(++p,str.length-p);
}
//字符串逆转
function strturn(str) {
    if (str != "") {
        var str1 = "";
        for (var i = str.length - 1; i >= 0; i--) {
            str1 += str.charAt(i);
        }
        return (str1);
    }
}

function GetFileExt(filepath) {
    if (filepath != "") {
        var pos = "." + filepath.replace(/.+\./, "");
        return pos;
    }
}

//取文件名不带后缀
function GetFileNameNoExt(filepath) {
    var pos = strturn(GetFileExt(filepath));
    var file = strturn(filepath);
    var pos1 =strturn( file.replace(pos, ""));
    var pos2 = getFullFileName(pos1);
    return pos2;
}

function GetRandomNum(Min, Max) {
    var Range = Max - Min;
    var Rand = Math.random();
    return (Min + Math.round(Rand * Range));
}

function left(mainStr,lngLen) {
    //console.log(mainStr);
    if(mainStr) {
        if (lngLen > 0) {
            return mainStr.substring(0, lngLen)
        } else {
            return null
        }
    }
}
function right(mainStr,lngLen) {
    if(mainStr) {
        if (mainStr.length - lngLen >= 0 && mainStr.length >= 0 && mainStr.length - lngLen <= mainStr.length) {
            return mainStr.substring(mainStr.length - lngLen, mainStr.length)
        } else {
            return null
        }
    }
}
function mid(mainStr,starnum,endnum){
    if(mainStr) {
        if (mainStr.length >= 0) {
            return mainStr.substr(starnum, endnum)
        } else {
            return null
        }
    }
}

function PrefixInteger(num, length) {
    return (Array(length).join('0') + num).slice(-length);
}


function replaceAll(str,replaceStr,newStr)
{
    if (str == "")
        return str ;
    var reg = new RegExp("\\" + replaceStr,"g");
    return str.replace(reg,newStr);

}
function getClientIp(ip) {
    if (ip.indexOf('::ffff:') !== -1) {
        ip = ip.substring(7);
    }
    return ip;
}
//格林威治时间的转换
Date.prototype.format = function(format)
{
    var o = {
        "M+" : this.getMonth()+1, //month
        "d+" : this.getDate(), //day
        "h+" : this.getHours(), //hour
        "m+" : this.getMinutes(), //minute
        "s+" : this.getSeconds(), //second
        "q+" : Math.floor((this.getMonth()+3)/3), //quarter
        "S" : this.getMilliseconds() //millisecond
    }
    if(/(y+)/.test(format))
        format=format.replace(RegExp.$1,(this.getFullYear()+"").substr(4 - RegExp.$1.length));
    for(var k in o)
        if(new RegExp("("+ k +")").test(format))
            format = format.replace(RegExp.$1,RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
    return format;
}

function CurentDate(){
    var now = new Date();
    var year = now.getFullYear();       //年
    var month = now.getMonth() + 1;     //月
    var day = now.getDate();            //日
    var clock = year + "-";
    if(month < 10)
        clock += "0";
    clock += month + "-";
    if(day < 10)
        clock += "0";
    clock += day + " ";
    return(clock);
}

function CurentTime(){
    var now = new Date();
    var hh = now.getHours();            //时
    var mm = now.getMinutes();          //分
    var ss = now.getSeconds();
    var clock = "";
    if(hh < 10)
        clock = "0";
    clock += hh + ":";
    if (mm < 10) clock += '0';
    clock += mm + ":";
    if (ss < 10) clock += '0';
    clock += ss;
    return(clock);
}

function CurentDate2(){
    var now = new Date();
    var year = now.getFullYear();       //年
    var month = now.getMonth() + 1;     //月
    var day = now.getDate();            //日
    var clock = year + "";
    if(month < 10)
        clock += "0";
    clock += month + "";
    if(day < 10)
        clock += "0";
    clock += day + "";
    return(clock);
}

function chGMTDate(gmtDate){
    var mydate = new Date(gmtDate);
    //mydate.setHours(mydate.getHours()-8);
    return mydate.format("yyyy-MM-dd");
}

function chGMTTime(gmtDate){
    var mydate = new Date(gmtDate);
    //mydate.setHours(mydate.getHours()-8);
    return mydate.format("hh:mm:ss");
}

function addDate(ds){
    var d=new Date();
    d.setDate(d.getDate()+ds);
    return d;
}

function addHours(ds){
    var d=new Date();
    d.setHours(d.getHours()+ds);
    return d;
}

function getNewDay(dateTemp, days) {
    var dateTemp = dateTemp.split("-");
    var nDate = new Date(dateTemp[1] + '-' + dateTemp[2] + '-' + dateTemp[0]); //转换为MM-DD-YYYY格式
    var millSeconds = Math.abs(nDate) + (days * 24 * 60 * 60 * 1000);
    var rDate = new Date(millSeconds);
    var year = rDate.getFullYear();
    var month = rDate.getMonth() + 1;
    if (month < 10) month = "0" + month;
    var date = rDate.getDate();
    if (date < 10) date = "0" + date;
    return (year + "-" + month + "-" + date);
}

function isDefine(para) {
    if (typeof para == 'undefined' || para == '' || para == null || para == undefined) return false;
    else return true;
}


function guid32() {
    function S4() {
        return (((1+Math.random())*0x10000)|0).toString(16).substring(1).toUpperCase();
    }
    return (S4()+S4()+S4()+S4()+S4()+S4()+S4()+S4());
}

exports.GetFolder = GetFolder;
exports.getFullFileName = getFullFileName;
exports.GetFileExt = GetFileExt;
exports.GetFileNameNoExt = GetFileNameNoExt;
exports.GetRandomNum = GetRandomNum;
exports.left = left;
exports.right = right;
exports.mid = mid;
exports.PrefixInteger = PrefixInteger;
exports.replaceAll = replaceAll;
exports.getClientIp = getClientIp;
exports.CurentDate = CurentDate;
exports.CurentTime = CurentTime;
exports.CurentDate2 = CurentDate2;
exports.chGMTDate = chGMTDate;
exports.chGMTTime = chGMTTime;
exports.addDate = addDate;
exports.getNewDay = getNewDay;
exports.isDefine = isDefine;
exports.guid32 = guid32;