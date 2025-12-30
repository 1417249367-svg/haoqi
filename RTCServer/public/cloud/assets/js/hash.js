/**
 * 锚点动作的URL定位
 * 1)生成当前目录信息 root_type,root_id,parent_type,parent_id
 * 2) 生成导航地址 path
 
 * @date    20141205
 * 
 */
var hash = {"url":"","param":""};
var ispath = 0 ;
var path  = "" ;
var query = "" ;
var path_data = [] ;  //来用权限判断 [{"doc_type":105,"doc_id":1,"root_id":1},{"doc_type":102,"doc_id":1,"root_id":1}]
var power = -1 ; //当前目录的权限

function hash_init()
{
	$(window).bind("hashchange",function(){
		load_data();
	});
	
	load_data();
}

function hash_to(name,param)
{
	if (param == undefined)
		param = "" ;
		
	hash.url = hash.url + "/" + name ;
	hash.param = param ;
	var url = hash.url;
	if (hash.param != "")
		url += "?" + hash.param ;
	location.href = url ;
}

// all/test?id=1_1
function hash_get(url)
{
	var arr = url.split("?");
	hash.url = arr[0] ;
	if (arr.length>1)
		hash.param = arr[1] ;
	return hash ;
}

//加载数据
function load_data(url)
{
	if (url == undefined)
		url = location.hash ; 
	if(url == "#")
		return false;
	if (url == "")
		url = "#all" ;
//	if (url == "#person")
//		url = "#个人文档_102_" + my_root_id + "_" + my_root_id;

	//得到HASHURL
	hash = hash_get(url) ;
	var arr_url = hash.url.replace("#","").split("/") ;
	
	//创建地址，并生成相关数据parent_type,root_id...
	path_create(arr_url);
	
	//不能放到 doc_list,因为delete也会 doc_list
	if (show_type == 2)
		show_thumb();
	else
		show_list();
	
	//列出内容
	doc_list_init();
	doc_list();
	
	//重新按钮
	init_cmd_btn();
}



//创建导航路径
function path_create(arr_url)
{
	power = -1 ;
	path_data = [] ;
	root_type = 0 ;
	root_id = 0 ;
	parent_type = 0 ;
	parent_id ="0" ;
	file_type = 0 ;
	key = "" ;
	
	var path_html = "";
	label = arr_url[0] ;
	ispath = path_valid(arr_url);
	path = "" ;
	
	for(var i=0;i<arr_url.length;i++)
	{
		var arr_item = arr_url[i].split("_");
		
		//首项 取root_type
		if (i == 0)
		{
			if (arr_item[0] == "public")
				root_type = 1 ;
			if (arr_item[0] == "person")
				root_type = 3 ;
		}
		
		
		
		//最后一项 取parent_type,parent_id
		if (i == arr_url.length-1)
		{
			//按路径查询  name_doctype_docid_rootid
			if (arr_item.length >= 4) 
			{
				parent_type = arr_item[1] ;
				parent_id = arr_item[2] ;
				root_id = arr_item[3] ;

			}
			

		}
		
		//添加到路径
		if (arr_item.length >=4)
			path_data.push({"doc_type":arr_item[1],"doc_id":arr_item[2],"root_id":arr_item[3]});  

		//得到地址HTML 累加
		path += (path == ""?"":"/") + arr_url[i] ;
		
		var name = "" ;
		if (path_valid(arr_url,i))
			name = decodeURI(decode64(arr_item[0])) ;
		else
			name = path_getname(arr_item[0]) ;
		path_html += "<li><a href='#" + path + "?" + hash.param + "' >" +  name + "</a></li>" ;
	}
	//按类型查询
	if (! ispath) 
	{
		if (label == "search"){
			var arr_item = arr_url[1].split("-");
			key = decode64(arr_item[0]) ;
			root_type = arr_item[1] ;
			parent_id = arr_item[2] ;
		}else
		{
			if (parseInt(arr_url[1]))
				file_type = arr_url[1] ;
		}
	}

	$("#path ul").html(path_html);

	var lis= $("#path ul li");
	$("#path ul li").eq(lis.length-1).addClass("active");  //最后一项为选中
	
	if (lis.length>1)
		$("#path ul li").eq(lis.length-2).addClass("prev");  //前一项设置特殊的样式
	
	if ($("#search_key").val() != key)
		$("#search_key").val(key);
		
	//加入路径，服务端不用再取路径，提高效率
	var curr_path = "";

	for(var i=path_data.length-1;i>=0;i--)
		curr_path += (curr_path == ""?"":",") + path_data[i].doc_type + "_" + path_data[i].doc_id + "_" + path_data[i].root_id ;

	//每个ajax都带个这个，以便权限判断
	query = "parent_type=" + parent_type + "&parent_id=" + parent_id + "&root_id=" + root_id + "&curr_path=" +  curr_path + "&" + hash.param;

	//得到权限
	//power = get_power();
	
	

}

function path_valid(arr_url,i)
{
	if (i == undefined)
		i = arr_url.length-1 ; //最后
	var arr_item = arr_url[i].split("_") ;
	return (arr_item.length>1) ;
}

//得到解析名称
function path_getname(name)
{
	switch(name)
	{
		case "all":
			return langs.path_all;
		case "search":
			return langs.path_search;
		case "recent":
			return langs.path_recent;
		case "public":
			return langs.path_public;
		case "person":
			return langs.path_person;
		case "favitor":
			return langs.path_favitor;
		case "share":
			return langs.path_share;
		case "1":
			return langs.path_documents;
		case "2":
			return langs.path_picture;
		case "3":
			return langs.path_music;
		case "4":
			return langs.path_video;
		default:
			var arr = name.split("_");
			if (arr.length == 4)
				return decode64(arr[0]) ;
			else
				return decode64(name) ;
	}
}

