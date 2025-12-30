/****************************************************************************
    JS Library for iform平台 ,Rising.co.cn
*   Copyright (C) 2005 沈永生
*   本脚本文件与ifrom平台一起发布
*   文件路径/iform/js,文件名rspublic.js
*   功能：主要是在iform平台里所使用的公共函数与全局变量
*   Made by 沈永生 2005
***************************************************************************/
//rspublicdata 是存放基本配置的全局变量
var rspublicdata={
	servletPath		: "",
	Path			: "/iform",
	dotnetVersion		: "",
	databaseTypeName	: "sqlServer",
	pub_sendhttp_errmsg	: ":与后台连接出错:",
	pub_sendhttp_h_errcode	: "003",
	pub_sendhttp_sql_errcode: "002",
	pub_sendhttp_io_errcode	: "001",
	pub_sendhttp_ap_errcode	: "004",
	pub_sendhttp_success	: "100",
	gridno_fieldname	: "fsn",
	FormOpenWinName		: "mainarea",
	LoginUrl		: "login.jsp",
	sessionid		: ""
} ;
// rspubvar是默认数据集合的ID
var rspubvar={
	DsMain			: "DsMain"
}

function getErrorMsg(errcode){
	if(errcode==rspublicdata.pub_sendhttp_h_errcode){
		return "后台hibernate异常！";
	}else if(errcode==rspublicdata.pub_sendhttp_sql_errcode){
		return "后台执行Sql时出错!";
	}else if(errcode==rspublicdata.pub_sendhttp_io_errcode){
		return "后台文件操作时出错！";
	}else if(errcode==rspublicdata.pub_sendhttp_ap_errcode)
	{
		return "后台产生末知错误!";
	}else if(errcode==rspublicdata.pub_sendhttp_success){
		return "保存成功！";
	}
}
var popUpWin=0;

function popUpWindow(URLStr, left, top, width, height)

{

  if(popUpWin)

  {

    if(!popUpWin.closed) popUpWin.close();

  }

  popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menub ar=no,scrollbar=no,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');

}

var oPubPopup = window.createPopup();
var oPubPopupBody = oPubPopup.document.body;
function ShowWait(displaystr){
	if(displaystr=="end") {
		oPubPopup.hide() ;
	}else{
		if(event != null){
			if(event.srcElement != null){
				if(event.srcElement.tagName.toUpperCase() == "SELECT" ) return
			}
		}
		var strHTML =""
		strHTML+="<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0><TR><td width=0%></td>";
		strHTML+="<TD bgcolor=#ff9900><TABLE WIDTH=100% height=60 BORDER=0 CELLSPACING=2 CELLPADDING=0>";
		strHTML+="<TR><td bgcolor=#eeeeee align=center>"+displaystr+"</td></tr></table></td>";
		strHTML+="<td width=0%></td></tr></table>";
		oPubPopupBody.innerHTML = strHTML ;
		var iwidth=300 ;
		var iheight=60 ;
		var ileft=(screen.availWidth-iwidth)/2 ;
		var itop=(screen.availHeight- iheight)/2 ;
		oPubPopup.show( ileft,itop, iwidth, iheight);
	}
}

//SaveUserData（Main,Sub,strContent）保存用户数据
function SaveUserData(Main,Sub,strContent){
	if(IsSpace(parent.pubdata)==false){
		userData=parent.pubdata.oForm.oInput;
	}else{
		userData = top.pubdata.oForm.oInput;
	}
	userData.setAttribute(Main+userData.value,strContent);
	userData.save(Sub+userData.value) ;
}

//LoadUserData(Main,Sub)加载用户数据
function LoadUserData(Main,Sub){
	if(IsSpace(parent.pubdata)==false){
		userData=parent.pubdata.oForm.oInput;
	}else{
		userData = top.pubdata.oForm.oInput;
	}
	userData.load(Sub+userData.value);
	var sTmp=userData.getAttribute(Main+userData.value);
	if (sTmp==null) { sTmp="" ; }
	return sTmp ;
}



/****************************************************************
*	与后台交换底层函数
****************************************************************/

/***************************************************************
*	SendHttp(sAspFile,sSend) 执行xmlhttp.send()
*	sAspFile，请求url
*	sSend，请求参数
****************************************************************/
function SendHttp(sAspFile,sSend){
	var sRet="";
	var iLen = sAspFile.indexOf("?");
	//alert(iLen);
	if(IsSpace(rspublicdata.sessionid)==false){
		if(iLen>0){
			sAspFile = sAspFile.substring(0,iLen)+";jsessionid="+rspublicdata.sessionid+sAspFile.substring(iLen);
		}else{
			sAspFile +=";jsessionid="+rspublicdata.sessionid;
		}
	}
	//alert(sAspFile);
	if(isWINNTUp()  ){
		sRet = SendHttpSubNt(sAspFile,sSend)
	}else {
		sRet = SendHttpold(sAspFile,sSend)
	}
	sRet = getMessage(sRet);
	//alert(sRet)
	return sRet;
}

/***************************************************************
*	SendHttpold(sAspFile,sSend) 用Microsoft.XMLHTTP 版本执行xmlhttp.send()
*	sAspFile，请求url
*	sSend，请求参数
****************************************************************/
function SendHttpold(sAspFile,sSend)
{
	if (navigator.onLine==false)
	{
		return "你现在处于脱机状态,请联机后再试!"
	}
	var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.Open("POST", sAspFile, false,"","");
	var rootname=""
	rootname="root"
	try
	{
		xmlhttp.Send("<"+rootname+">"+sSend+"</"+rootname+">");
	}
	catch (exception)
	{
		if(sSend!='不提示')
			alert("服务器忙!")
	}
	try
	{
		var str11=xmlhttp.responseText
	}
	catch (exception)
	{
		if (exception.description=='系统错误: -1072896748。')
		{
			str11=""
		}
	}
	return str11
}

/***************************************************************
*	SendHttpSubNt(sAspFile,sSend) NT操作系统下执行xmlhttp.send()
*	先用Msxml2.ServerXMLHTTP 版本执行xmlhttp.send(),如果有异常
*	用Microsoft.XMLHTTP 版本执行xmlhttp.send()
*	sAspFile，请求url
*	sSend，请求参数
****************************************************************/
function SendHttpSubNt(sAspFile,sSend) {
	try{
		var xmlhttp = new ActiveXObject("Msxml2.ServerXMLHTTP");
	}catch(E){
		return SendHttpold(sAspFile,sSend)
	}
	xmlhttp.setTimeouts(20000, 20000, 50000,100000);
	try{
		xmlhttp.open("POST", sAspFile, false,"","");
	}catch (E){
		if(sSend!='不提示')
			alert(E.description)
	}
	try{
		xmlhttp.send("<root>"+sSend+"</root>");
	}catch (E){
		if(sSend!='不提示')
			alert("错误信息:"+E.description)
		return rspublicdata.pub_sendhttp_errmsg ;
	}
	try{
		var str11=xmlhttp.responseText
	}
	catch (E){
		if(sSend!='不提示')
			alert("错误:"+E.description)
		str11="";
	}
	return str11
}

//判断是否是nt操作系统
function isWINNTUp() {
	var agt = navigator.userAgent.toLowerCase();
	if ( (agt.indexOf("winnt") != -1) || (agt.indexOf("windows nt") != -1) )
		return 	true;
	return false;
}



/****************************************************************
*	与后台交换函数
****************************************************************/

/***********************************************************
*	SqlToField(sql)查找Sql语句里的Field字段
*	sql Sql语言字符串
*	注意本函数与后台Servlet 相结后，返回相应字段内容
***********************************************************/
function SqlToField(sql) {
	var sXml="<sql>"+RepXml(sql)+"</sql>"
	var retX=SendHttp(location.protocol+"//"+location.host + rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?SqlToField",sXml)
	return retX
}
/***********************************************************
*	SelectSql(sql,Sql,PageNo,PageSize)查找大文本内容
*	sql Sql语言字符串
*	注意本函数与后台Servlet 相结后，返回大文本内容
***********************************************************/
function SelectSql(sSql,PageNo,PageSize) {
	if(rspublicdata.databaseTypeName == "mysql" && sSql.substring(0,4).toUpperCase() == "EXEC" ){
		alert("因mysql数据库不支持存储过程!故无法使用此功能!")
	}		
	var sql1 = RepXml(sSql);
	var sXml="<sql>"+sql1+"</sql>"+"<PageNo>"+PageNo+"</PageNo>"+"<PageSize>"+PageSize+"</PageSize>"
	var retX=SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?SelectSql",sXml)
	return retX
}

/********************************************************************
*	InsertSqls(sSql)执行插入更新语句
*	注意与后台Servlet相结合，返回提示语句
*********************************************************************/
function InsertSqls(sSql) {	
	var sSql="<sql>"+sSql+"</sql>";
	var retX=SendHttp(location.protocol+"//"+location.host + rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?InsertSqls",sSql)
	return retX
}

/********************************************************************
*	InsertSql(sSql)执行插入更新语句
*	参数以xml的形式传递
*	注意与后台Servlet相结合，返回提示语句
*********************************************************************/
function InsertSql(sSql,arr) {
	if(rspublicdata.databaseTypeName == "mysql" && sSql.substring(0,4).toUpperCase() == "EXEC" ){
		alert("因mysql数据库不支持存储过程!故无法使用此功能!")
		return ""
	}
	var sXml="<sql>"+sSql+"</sql>";
	if(arr!=null){
		for(var i=0;i<arr.length;i++){
			sXml+="<no>"+arr[i]+"</no>";
		}
	}
	var retX=SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?InsertSql",sXml)
	return retX
}

/********************************************************************
*	saveformhtml(sXml),保存设计的html源代码
*	参数以xml的形式传递
*	注意与后台Servlet相结合，返回提示语句
*********************************************************************/
function saveformhtml(sXml) {
	return SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?saveformhtml",sXml)
}

/********************************************************************
*	readdesignhtml(sXml),读取设计的html源代码
*	参数以xml的形式传递
*	注意与后台Servlet相结合，返回提示语句
*********************************************************************/
function readformhtml(sXml) {
	return SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?readformhtml",sXml)
}

/********************************************************************
*	loadClob(sXml),加载Clob字段的内容
*	参数以xml的形式传递
*	注意与后台Servlet相结合，返回提示语句
*********************************************************************/
function loadClob(sXml) {
	var retX=SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?loadClob",sXml)
	return retX
}

/********************************************************************
*	designformsave(sXml),保存设计源代码
*	参数以xml的形式传递
*	注意与后台Servlet相结合，返回提示语句
*********************************************************************/
function designformsave(sXml) {
	var retX=SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?designformsave",sXml)
	return retX
}

/********************************************************************
*	getMaxNo(sTag,strMK),最大记录编号,sTage编号前序
*	参数以xml的形式传递
*	注意与后台Servlet相结合，返回提示语句
*********************************************************************/
function getMaxNo(sTag,strMK) {
	return SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?getRecnum","<tag>"+sTag+"</tag>")
}

/********************************************************************
*	selecttext(sSql,PageNo,PageSize),获取text文本内容
*	参数以xml的形式传递
*	注意与后台Servlet相结合，返回提示语句
*********************************************************************/
function selecttext(sSql,PageNo,PageSize) {
	var sql1=""
	for(var i=0;i<sSql.length;i++) {
	switch (sSql.charAt(i)) {
		case "<" :
			sql1=sql1+"&lt;";
			break;
		case ">" :
			sql1=sql1+"&gt;";
			break;
		default:
			sql1=sql1+sSql.charAt(i);
		}
	}
	var sXml="<sql>"+sql1+"</sql>"+"<PageNo>"+PageNo+"</PageNo>"+"<PageSize>"+PageSize+"</PageSize>"
	var retX=SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?selecttext",sXml)
	return retX
}

//发送邮件
function SendEmail(to,title,body,sip,sfrom,susername,spassword,copyto,sData,sFileName,sBcc) {
	if(IsSpace(sip)){ sip="smtp.sina.com.cn"}
	if(IsSpace(sfrom)){ sfrom="82645151@sina.com"}
	if(IsSpace(susername)) {susername="82645151" }
	if(IsSpace(spassword)) {spassword="8264"}
	title=escape(title)
	body=escape(body)
	sData=escape(sData)
	sFileName=escape(sFileName)
	var sXml="<no>"+to+"</no>"+"<no>"+title+"</no>"+"<no>"+body+"</no>"
	+"<no>"+sip+"</no>"+"<no>"+sfrom+"</no>"+"<no>"+susername+"</no>"+"<no>"+spassword+"</no>"
	+"<no>"+copyto+"</no>"+"<no>"+sData+"</no>"+"<no>"+sFileName+"</no>"+"<no>"+sBcc+"</no>"
	var retX=SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?autosendmail",sXml)
	return retX
}

//sXml格式为<no>a</no>b<no>c</no><no>d</no>
function zl_select(sXml) {
	var retX=SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?zl_select",sXml)
	return retX
}

//获取所有表单文件名
function GetAllFormFileName() {
	return SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?GetAllFormFileName","")
}


function CrossTab(sXml){
	var posStart=sXml.indexOf("<sql>")
	var posEnd=sXml.indexOf("</sql>")
	var sql=sXml.substring(posStart+5,posEnd)
	sql=RepOpenSql(sql)
	sXml=sXml.substring(0,posStart)+"<sql>"+sql+sXml.substr(posEnd)
	return SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?crosstab",sXml)
}
/********************************************************************
*	loadhtml(sql,djsn),生成jsp文件,并返回xml的相关内容
*	参数以xml的形式传递
*	注意与后台Servlet相结合，返回提示语句
*********************************************************************/
function loadhtml(sql,formid) {
	var sXml="<sql>"+RepXml(sql)+"</sql>"+"<id>"+formid+"</id>"+"<dbtype>"+rspublicdata.databaseTypeName+"</dbtype>"
	return SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?loadhtml",sXml)
}

/********************************************************************
*	GetFormType(),获取表单类别,在下拉菜单里使用
*	参数以xml的形式传递
*	注意与后台Servlet相结合，返回提示语句
*********************************************************************/
function GetFormType() {
	//alert(location.protocol+"//"+location.host+  rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?GetFormType")
	var sRet = SendHttp(location.protocol+"//"+location.host+  rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?GetFormType","");
	return sRet
}

function form_select(sSql,PageNo,PageSize) {
	if(rspublicdata.databaseTypeName == "mysql" && sSql.substring(0,4).toUpperCase() == "EXEC" ){
		alert("因mysql数据库不支持存储过程!故无法使用此功能!")
	}
	var sql1 = RepXml(sSql) ;
	var sXml="<sql>"+sql1+"</sql>"+"<PageNo>"+PageNo+"</PageNo>"+"<PageSize>"+PageSize+"</PageSize>"
	var retX=SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?form_select",sXml)
	//alert(retX);
	return retX
}

function GetListItem(sSql){
	var sql = RepXml(sSql);
	var sXml="<sql>"+sql1+"</sql>";
	var retX=SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?ListItem",sXml)
	return retX
}

//用于select列表
function GetOrgRole(orgId,memberId){
	var sXml = "<orgId>"+orgId+"</orgId><memberId>"+memberId+"</memberId>";
	var retX=SendHttp(location.protocol+"//"+location.host+ rspublicdata.servletPath + "/webform"+rspublicdata.dotnetVersion+"?OrgRole",sXml)
	return retX
}
/***********************************************************
*	常用工具函数
***********************************************************/
function FillList(listBox,sSql){
	if(IsSpace(listBox)) return;
	if(IsSpace(sSql)) return;
	var ss=listBox.outerHTML ;
	var sHtml = GetListItem(sSql);
	listBox.outerHTML=ss.substring(0,ss.length-9)+sHtml+"</select>";	
}
/***********************************************************
*	RepOpenSql(sql,slikevalue) 解析Sql语句
*	对Sql语句进行解析,允许一变量的传递，如时间，数据集等在Sql里
***********************************************************/
function RepOpenSql(sql,slikevalue) {
	if(IsSpace(sql)){ return "" }
	if(rspublicdata.databaseTypeName == "mysql"){
		sql=Trim(sql)
		if(sql.substring(0,4).toUpperCase() == "EXEC"){
			alert("因mysql数据库不支持存储过程!故无法使用此功能!")
			return sql;
		}
	}
	sql=RepStr(sql,"\r\n"," ");
	var posStart=0;
	var posEnd=0;
	var ret="";
	var re = new RegExp();
	re.compile("(:[a-zA-Z0-9_\.]*)([), =+%]|$|\s)","gi");
	var sInput=sql;
	var nextpoint=0;
	while ((arr = re.exec(sInput)) != null) {
		posEnd=arr.index;
		var s1=RegExp.$1;
		var sRep="";
		if(s1==":get_userid"){
			sRep="'"+Trim(getCurUserId())+"'";
		}else if(s1==":v_get"){
			sRep=slikevalue;
		}else if(s1==":get_date"){
			sRep="'"+GetDate()+"'";
		}else if(s1==":get_time"){
			sRep="'"+getTime()+"'";
		}else if(s1==":get_datetime"){
			sRep="'"+GetDatetime()+"'";
		}else if(s1==":getCurUserId"){
			sRep=""+getCurUserId();
		}else if(s1==":keyfield"){
			if(IsSpace(objId)) 
			    return "";
			sRep = ""+objId;
		}else {
			var arr2=s1.split(".");
			if(arr2.length == 1){
				sRep="'"+pubdjbh+"'";
			}else {
				var stmp1=arr2[0].substring(1,arr2[0].length);
				var oDs=eval(stmp1);
				if(oDs != null) {
					if(oDs.Empty=="null"){
						sRep="''";
					}else {
						try{
							sRep="'"+oDs.Fields.Field[arr2[1]].Value+"'";
						}catch(E){ alert(stmp1+"中不存在字段"+arr2[1]);sRep="'"+"'"};
					}
				}
			}
		}
		ret+=sql.substring(posStart+nextpoint,posEnd+nextpoint)
		ret+=sRep
		posStart=arr.index+s1.length
	}
	if(ret == ""){
		ret=sql
	}else if(posStart<=sql.length) {
		ret+=sql.substring(posStart,sql.length)
	}
	if(IsSpace(ret)) { ret="" }
	return ret;
}

/**************************************************************
*	ContDec(sValue,sPointNum)格式化一个数据显示
*	sValue 要格式化的数值
*	sPointNum 小数点后的位置，即精确度
*	注意：sValue后的小数点sPointNum位进行四五入处理
***************************************************************/
function ContDec(sValue,sPointNum) {
	var dblValue=parseFloat(sValue) ;
	if (isNaN(dblValue)) {return sValue ;}
	var iPointNum=parseInt(sPointNum);
	if (isNaN(iPointNum)) { iPointNum=0 ;}
	if (iPointNum>9){ iPointNum=9 ;}
	if (iPointNum<0){ iPointNum=0 ;}
	var dbl1=Math.round(dblValue*Math.pow(10,iPointNum))/Math.pow(10,iPointNum) ;
	var s1=dbl1+"" ;
	var num0=0 ;
	if(s1.indexOf(".")==-1){
		num0=iPointNum ;
	}else{
		var num1=s1.length-s1.indexOf(".")-1 ;
		if(num1<iPointNum ){
			num0=iPointNum-num1 ;
		}
	}
	if (num0>0) {
		var s2="000000000000000" ;
		if(num0==iPointNum) {
			s1=s1+"."+s2.substring(0,num0) ;
		}else {
			s1=s1+s2.substring(0,num0);
		}
	}
	return s1 ;
}

/***********************************************************
*格式化金额,保留二们有效数字*
***********************************************************/
function formatMoney(obj){
	if(!IsNum(obj.value)){
		alert("必须输入数值型!");
		obj.focus();
		return;
	}
	if(IsSpace(obj.value)){
	   obj.value="0.00";
	   return;
	}
	obj.value=ContDec(obj.value,2);		
}

//判断是否是数值型
function IsNum(sValue){
	if(IsSpace(sValue))
	    return true;
	if (parseFloat(sValue)==NaN || isNaN(sValue)){
		return false;
	}
	return true;
}
/************************************************************
*	RepXml(sSql) 解决sSql中的xml标识
*	sSql语句中的<>&字符串替换成相应的字符
*************************************************************/
function RepXml(sSql) {
	if(IsSpace(sSql)) return "";
	var sql1=""
	for(var i=0;i<sSql.length;i++) {
		switch (sSql.charAt(i)) {
			case "<" :
				sql1=sql1+"&lt;";
				break;
			case ">" :
				sql1=sql1+"&gt;";
				break;
			case "&" :
				sql1=sql1+"&amp;";
			break;
			default:
				sql1=sql1+sSql.charAt(i);
		}
	}
	return sql1
}



/************************************************************
*	UnRepXml(sSql) 反向解析sSql中的xml标识
*************************************************************/
function UnRepXml(sSql) {
	sSql = RepStr(sSql,"&lt;","<") ;
	sSql = RepStr(sSql,"&gt;",">")
	sSql = RepStr(sSql,"&amp;","&")
	return sSql ;
}

/*************************************************************
*	IsSpace(strMain)	判断对象是否为空
*	当空格，空，null,对象类型undefined，undefined都返回true
*************************************************************/
function IsSpace(strMain){
	var strComp=strMain;
	try{
		if (strComp=="　" || strComp=="" || strComp==" " || strComp==null || strComp=="null" || strComp.length==0 || typeof strMain == "undefined" || strMain == "undefined" ) {
			return true;
		}else{
			return false;
		}
	}catch(e){return false; }
}

//当前日期，以2005-05-19的格式显示
function curDate() {
	var dDate=new Date()
	var s1=""+dDate.getYear()
	var s2=dDate.getMonth()+1
	if (s2<10) {
		s2="0"+s2
	}else {
	s2=""+s2
	}
	var s3=dDate.getDate()
	if (s3<10) {
		s3="0"+s3
	}else{
		s3=""+s3
	}
	return s1+"-"+s2+"-"+s3
}

//剪切首尾字符串空格
function Trim(strMain) {
	if (strMain==null) {return ""}
	strMain=strMain+""
	var str1=strMain
	for (var i=0;i<=str1.length-1;i++) {
		var mychar=str1.charAt(i);
		if ((mychar!=" ") && (mychar!="　" && mychar != "\r" && mychar != "\n" )) {
			break;
		}
	}
	str1=str1.substring(i,str1.length);
	for (var i=str1.length-1;i>0;i--) {
		var mychar=str1.charAt(i);
		if ((mychar!=" ")  && (mychar!="　") && mychar != "\r" && mychar != "\n" ) {
			break;
		}
	}
	str1=str1.substring(0,i+1);
	return str1;
}


/*********************************************************************
*	RepStr(mainStr,findStr,replaceStr) 替换字符串
*	manStr 要替换的字符串
*	findStr 被替换的字符串
*	relplaceStr 替换的字符串
*********************************************************************/
function RepStr(mainStr,findStr,replaceStr){
	if(typeof mainStr=="undefined") {return ""}
	var iStart=0
	var iEnd=0
	var sRet=""
	while (iStart<mainStr.length) {
		iEnd=mainStr.indexOf(findStr,iStart)
		if (iEnd<0) {
			iEnd=mainStr.length
			sRet=sRet+mainStr.substring(iStart,iEnd)
		} else {
			sRet=sRet+mainStr.substring(iStart,iEnd)+replaceStr
		}
		iStart=iEnd+findStr.length
	}
	if(sRet=="") { return mainStr}
	return sRet
}

//如果是sqlserver数据库，通过Sql查询获取日期，否则curDate(),日期格式为:2005-05-19
function GetDate(){
	if(rspublicdata.databaseTypeName != "sqlserver") return curDate() ;
	var sql="select convert(varchar(10),GetDate(),20) "
	var s1=SqlToField(sql)
	return s1
}

//向剪贴板保存数据
function CopyToPub(str){
	window.clipboardData.setData("Text",str)
}

//通过字符串设置xml
function SetDom(sXml) {
	var oXml=new ActiveXObject("Microsoft.XMLDOM")
	oXml.async=false
	oXml.loadXML (sXml)
	return oXml
}

//通过xml文件,设置xml
function SetDomFile(sPath) {
	var oXml=new ActiveXObject("Microsoft.XMLDOM")
	oXml.async=false
	oXml.load (sPath)
	return oXml
}

//删除xml的根<root>与</root>
function RemoveRoot(strX){
	if (strX.length>13){
		strX=strX.substring(6,strX.length-7)
		return strX
	}else {
		return ""
	}
}

//css过滤
function CssPart(csstext){
	if(typeof csstext == "undefined" ) return ""
	var sRet=""
	var arr=csstext.split(";")
	var l=arr.length
	for(var i=0;i<l;i++){
		var arr1=arr[i].split(":")
		if(arr1.length != 2) continue ;
		var stitle=Trim(arr1[0])
		var svalue=Trim(arr1[1])
		if(stitle == "FONT-WEIGHT" || stitle == "FONT-SIZE" || stitle == "COLOR" || stitle == "FONT-STYLE" || stitle == "FONT-FAMILY" || stitle == 	"BACKGROUND-COLOR" || stitle =="TEXT-DECORATION" ){
			sRet+=stitle+":"+svalue+";"
		}
	}
	return sRet;
}

//判断是否已经存在文件上传控件
function HaveUpload() {
try{
	var s1=uploadfile1.id
	if(s1!="uploadfile1") {return false}
	}catch(e){
		return false
	}
	return true
}

function upload_save(formSn){
	try{
		var s1=uploadfile1.id
		if(s1!="uploadfile1") {return}
	}catch(e){
		return
	}
	var sql=""
	var tb=uploadfile1.children[0]
	for(var i=0;i<tb.rows.length-1;i++){
		var sTag = tb.rows(i).cells(4).innerText
		if(sTag == "新增" ){
			var filename = tb.rows(i).cells(1).innerText
			if(IsSpace(filename)==false){
				filename=Trim(filename)
				var extname=filename.substring(filename.length-4,filename.length)
				extname=extname.toLowerCase();
				filename=tb.rows(i).cells(1).title
				var m_attachid = tb.rows(i).cells(3).innerText
				sql+="<no>insert wf_attach (attachid,formSn,filename,extend) values ('"+m_attachid+"','"+formSn+"','"+filename+"','"+extname+"') </no>"
			}
		}else if(sTag == "删除"){
			var m_attachid = tb.rows(i).cells(3).innerText
			if(IsSpace(m_attachid)==false){
				sql+="<no>delete from wf_attach where attachid='"+m_attachid+"' </no>"
			}
		}
	}
	if(sql!=""){
		var sRet1=InsertSql(sql);
		if(IsSpace(sRet1)==false){
			alert(sRet1);
			return
		}
	}
	for(var i=0;i<tb.rows.length-1;i++){
		var sTag = tb.rows(i).cells(4).innerText
		if(sTag == "新增" ){
			var filename = tb.rows(i).cells(1).title
			var m_attachid = tb.rows(i).cells(3).innerText
			if(IsSpace(filename)==false && IsSpace(m_attachid)==false ){
				filename=trim(filename)
				try{
					var st = new ActiveXObject("adodb.stream")
					st.Type=1
					st.Open()
					st.LoadFromFile(filename)
					var pic = st.Read()
					st.Close()
					var oHTTP2 = new ActiveXObject("Microsoft.XMLHTTP");
					if(servletPath==""){
						oHTTP2.open("POST","http://"+location.host+"/servlet/uploaddoc?key=writeimage&sTablename=wf_attach&sImgname=attach&sKeyname=attachid&sKeyvalue="+m_attachid,false);
					}else{
						oHTTP2.open("POST","http://"+location.host+"/" + servletPath+"/uploaddoc.aspx?key=writeimage&sTablename=wf_attach&sImgname=attach&sKeyname=attachid&sKeyvalue="+m_attachid,false);
					}
					oHTTP2.send(pic);
				}catch(e){ alert("文件上传失败!");return;}
			}
		}
	}
}

//判断是否为true，true,"true",1,"1","True","yes","T","y","Y","on", "是"为true
function IsTrue(svalue) {
	if(svalue == true || svalue == "true" || svalue == "True" || svalue == "yes"  || svalue == 1  || svalue == "1"  || svalue == "T"  || svalue == "on"  || svalue == "是" || svalue == "y" || svalue == "Y")
		return true
	else
		return false
}

//获取字符串长度，非asii码时，一个字符算二位
function GetLength(str){
	var i,rt=0;
	for(i=0;i<str.length;i++)
	{
		rt++;
		if(str.charCodeAt(i)>256)rt++;
	}
	return rt;
}

//反向解决字符内容,即''替为'
function UnTransSql(sRun){
	sRun=RepStr(sRun,"''","'");
	return sRun ;
}
//解析xml特殊字符
function TransXml(sRun){
	sRun=RepStr(sRun,"&","&amp;");
	sRun=RepStr(sRun,">","&gt;");
	sRun=RepStr(sRun,"'","&apos;&apos;");
	sRun=RepStr(sRun,"<","&lt;");
	sRun=RepStr(sRun,"\r\n","&#13;&#10;");
	return sRun ;
}

//反向解析xml特殊字符
function UnTransXml(sRun){
	sRun=RepStr(sRun,"&amp;","&");
	sRun=RepStr(sRun,"&gt;",">");
	sRun=RepStr(sRun,"&apos;","'");
	sRun=RepStr(sRun,"&lt;","<");
	return sRun ;
}

//解析Sql结果内容的字符串,'转换为''
function TransSql(sRun){
	sRun=RepStr(sRun,"'","''");
	return sRun ;
}
//获取数据源
function GetDsMain(bUseSelect) {
	var sRet = "DsMain" ;
	if(bUseSelect == true ) {
		var oContXml = SetDom(Parent.Formsheet.contxml);
	}else{
		var oContXml = SetDom(Formsheet.contxml);
	}
	var oNode = oContXml.documentElement.selectSingleNode("webgrid") ;
	var oNodeDs = oContXml.documentElement.selectSingleNode("dataset") ;
	if(oNodeDs != null ){
		for(var i=0;i<oNodeDs.childNodes.length;i++){
			var bool = false ;
			var s = oNodeDs.childNodes(i).text
			if(oNode != null ){
				for(var j=0;j<oNode.childNodes.length;j++){
					var s1 = oNode.childNodes(j).text ;
					if(bUseSelect == true ) s1="Parent."+s1
					var otmp = eval(s1) ;
					if(s == otmp.dataset ){
						bool=true
						break
					}
				}
			}
			if(bool == false){
				var s1=oNodeDs.childNodes(i).text ;
				if(bUseSelect == true ) s1="Parent."+s1 ;
				sRet = eval(s1).id;
				break;
			}
		}
	}
	return sRet ;
}

//上传图片
function uploadImg(){
	var oImg=event.srcElement
	var ods=eval(rspubvar.DsMain)
	var arr = new Array();
	arr[0]=oImg;
	arr[1]=ods;	
	if(oImg.isContentEditable) return	
	if(IsSpace(Formsheet.keyfield)) return;
	arr[2]=Formsheet.keyfield;
	if(IsSpace(Formsheet.table)) return;
	arr[3]=Formsheet.table;
	if(IsTrue(Formsheet.native)){
		arr[4]=true;
	}else{
		arr[4]=false;
	}
	var sRet=window.showModalDialog("/iform/common/uploadimg.htm",arr,"status:no;dialogHeight:105px;dialogWidth:470px;dialogTop:180;dialogLeft:250px");	
	pubdjbh=ods.Fields.Field[Formsheet.keyfield].Value	
	ods.Fields.Field[oImg.field].Value=oImg.src
}

//过滤结果
function getMessage(s){
	var sRet = "";
	if(s=="102"){
		sRet = "非法用户!";
		processError(sRet)
		return;
	}else if(s=="001"){
		sRet = "程序在读取属性文件时出错了,请联系管理员!";
		processError(sRet)
		
	}else if(s=="002"){
		sRet = "在执行SQL时出错了,请联系管理员!";
		processError(sRet)
	}else if(s=="003"){		
		sRet = "在Hibernate层运行时出错了,请联系管理员!";
		processError(sRet)
	}else if(s=="004"){
		sRet = "应用程序后台出错,请联系管理员!";
		processError(sRet)
	//}else if(s=="100"){
		//sRet = "操作成功!";		
	}else if(s=="101"){
		sRet = "操作失败,请重试!";
		//processError(sRet)
	}else{
		sRet = s;
	}
	return sRet;
}

function processError(sRet){
	if(top.opener==null){
		if(top.dialogArguments==null){
			alert("href="+top.location.href);
			top.location.href=location.protocol+"//"+location.host+ rspublicdata.servletPath + "/"+rspublicdata.LoginUrl;
			return;
		}else{
			var parented = top.dialogArguments[10];
			parented.execScript('try{processLogin();}catch(e){}');
			CloseBill();
			return;
		}
		top.location.href=location.protocol+"//"+location.host+ rspublicdata.servletPath + "/"+rspublicdata.LoginUrl;
		return;
	}else{
		top.opener.execScript('try{processLogin();}catch(e){}');
		CloseBill();
	}
}

function processLogin(){
	top.location.href=location.protocol+"//"+location.host+ rspublicdata.servletPath + "/"+rspublicdata.LoginUrl;
}

//设置cookies
function setCookies(cookie_name,cookie_value,cookie_expire,cookie_path,cookie_domain,cookie_secure){
	var cookie_string = cookie_name+"="+cookie_value;
	if(cookie_expire){
		var expire_date=new Date();
		var ms_from_now=cookie_expire*24*60*60*1000;
		expire_date.setTime(expire_date.getTime()+ms_from_now);
		var expire_string=expire_date.toGMTString();
		cookie_string+=";expires="+expire_string;
	}
	if(cookie_path){
		cookie_string+=";path="+cookie_path;
	}
	if(cookie_domain){
		cookie_string+=";domain="+cookie_domain;
	}
	if(cookie_secure){
		cookie_string+=";true";
	}
	document.cookie=cookie_string;
}

function setCookie(cookie_name,cookie_value){
	setCookies(cookie_name,cookie_value);
}
//获取cookie 值
function getCookie(cookiename){
	var cookie_pair;
	var cookie_name;
	var cookie_value;
	var cookie_array=getCookieStr().split(";");
	for(var counter=0;counter<cookie_array.length;counter++){
		cookie_pair=cookie_array[counter].split("=");
		cookie_name=Trim(cookie_pair[0]);
		cookie_value=cookie_pair[1];
		if(cookie_name==cookiename){
			return cookie_value ;
		}
	}
	return null;
}

//把cookie对应的值删除
function delCookie(cookiename){
	setCookies(cookiename,"",-1,"/");
}
//清空cookie里所有值
function clearCookie(){
	var cookie_pair;
	var cookie_name;
	var cookie_array=getCookieStr().split(";");
	for(var counter=0;counter<cookie_array.length;counter++){
		cookie_pair=cookie_array[counter].split("=");
		cookie_name=cookie_pair[0];
		setCookies(cookie_name,"",-1);
	}
}

//获取cookie字符串
function getCookieStr(){
	return document.cookie+"";
}

//应用controlHead中,每个页面加载是可以执行的JS接口函数
function before_load_do(){
	if( typeof initPage =='function')
	{
		initPage();	
	}
}

function GetFieldValue(tableName,fieldName,contFieldName,ds,isGrig){
   if(IsSpace(tableName)||IsSpace(fieldName)||IsSpace(contFieldName)||IsSpace(ds))
   	   return "";
   var contFieldValue;
   if(isGrig){	//用于表格的临时计算项
   	  var arr=new Array();
   	  arr[0]=true;
   	  arr[1]= "select "+fieldName+" from "+tableName+" where "+contFieldName+" =";
   	  arr[2]=contFieldName;   	  
   	  return arr;
	}else{
		try{	  
		  //if(IsTrue(ds.Fields.Field[contFieldName].isKey)&&IsSpace(ds.Fields.Field[contFieldName].Value))
		  //		return "主键值不存在";//特殊情况
		  contFieldValue = ds.Fields.Field[contFieldName].Value;  
		}catch(E){return "";}
		if(IsSpace(contFieldValue)){
	      return "";
	   }
	   
	   return SqlToField("select "+fieldName+" from "+tableName+" where "+contFieldName+" ="+contFieldValue);
	}   
}
