var funName = "DocAce" ;
var funGenre = "" ;
var classId = "102" ;
var objId = 0 ;
var dataList ;

function ace_load(objId)
{
    var where = ace_getWhere() ;
    
    if (dataList == undefined)
        dataList = $("#datalist").attr("data-where",where).dataList(ace_formatData);
    else
        dataList.search(where);
}

function ace_getWhere()
{
	var where = "" ;
	where = getWhereSql(where,"col_funName='" + funName + "'") ;
	where = getWhereSql(where,"col_funGenre='" + funGenre + "'") ;
	where = getWhereSql(where,"col_classId='" + classId + "'") ;
	where = getWhereSql(where,"col_objId='" + objId + "'") ;
	return where ;
}

function ace_formatData(data)
{
	for (var i = 0; i < data.length; i++) {
		if (data[i].to_type == 1)
			data[i].col_hsitemtype_name = langs.user ;
		else
			data[i].col_hsitemtype_name = langs.dept ;
	}
	return data ;
}

function ace_callback(data)
{
	//设置权限显示
	for (var i = 0; i < data.length; i++) {
		var row = $("#ace_" + data[i].id);
		$(".chk_power",row).each(function(){
			var my_power = $(this).val() ;
			if (ace_is(data[i].docace,my_power))
				$(this).attr("checked",true);
			else
				$(this).attr("checked",false);
		})
	}
	
	//点击保存权限
	$(".chk_power").click(function(){
		var row = $(this).parent().parent();
		ace_save(row);
	})
}

function ace_save(row)
{
	//得到本行的ID
	var id = $(row).attr("data-id") ;
	
	var power = 0 ;
	//统计权限
	if($(".chk_power",row).eq(2).is(":checked")){
		$(".chk_power",row).eq(1).prop("checked",true);
	}
	$(".chk_power",row).each(function(){
		if ($(this).is(":checked")){
			power += parseInt($(this).val());
		}
	})

	//保存权限
   var url = getAjaxUrl("bioace","set_power","id=" + id) ;
   //document.write(url+"&power="+power);
   $.ajax({
       type: "POST",
	   data:{power:power},
       dataType:"json",
       url: url,
       success: function(result){

       }
   }); 
}

function ace_is(power,ispower)
{
	return (power & ispower) == ispower ;
}

function ace_user_picker()
{
	var arr_node = nodeId.split("_");
	user_picker(arr_node[0],arr_node[1],1,"tab_bioace");
}

function ace_user_picker1()
{
	user_picker(parent_type,parent_id,1,"tab_bioace");
}

function ace_role_picker()
{
	dialog("picker",langs.role_set,"../hs/role_picker.html") ;
}

function postUserList()
{
   	setLoadingBtn($("#btn_picker_submit")) ;
   	var vals = "" ;
   	var texts = "" ;
	$("#tbl_member tbody tr").each(function(){
		vals += (vals == ""?"":",") + $(this).attr("data");
		texts += (texts == ""?"":",") + $(".col_name",this).html();
	})
   ace_add(1,vals,texts);
}

function postRoleList()
{
   setLoadingBtn($("#btn_picker_submit")) ;
   var vals = "" ;
   var texts = "" ;
   $("input[name='empid']").each(function(){ 
		if (this.checked){
			vals += (vals == ""?"":",") + $(this).val();
			texts += (texts == ""?"":",") + $(this).attr("data-name");
		}
	});

   ace_add(3,vals,texts);
}

function ace_add(empType,empIds,empNames)
{
	var arr_node = nodeId.split("_");
	var url = getAjaxUrl("bioace","set_data") ;
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{classId:arr_node[0],objId:arr_node[1],empType:empType,empIds:empIds,empNames:empNames},
	   url: url,
	   success: function(result){
			if (result.status)
			{
				dataList.reload() ;
				myAlert(langs.text_op_success);
				dialogClose("picker");
				
			}
			else
			{
				myAlert(getErrorText(result.errnum));
			}
	   }
	}); 
}

var id = "" ;
function ace_delete(_id)
{
	id = getSelectedId(_id) ;

	if (id == "")
		return ;
	if (confirm(langs.text_delete_confirm))
		dataList.del(id,{"classid":classId,"objid":objId}) ;
}

function batch_import(_id)
{
	var url = "http://addon.hqn100.cn/android.php?ac=detail&cname=guanfang&id=14" ;
	window.open(url);
}


function chk_power_All(value,ischeck)
{
	if(value=="16384"&&$(".chk_power16384").is(":checked")){
		 $(".chk_power").each(function(){
		  if($(this).val()==2) this.checked = true;
		});
	}
   $(".chk_power").each(function(){
	if($(this).val()==value) this.checked = ischeck;
  });

	//保存权限
   var url = getAjaxUrl("bioace","set_powers") ;
   //document.write(url+"&power="+power);
   $.ajax({
       type: "POST",
	   data:{power:getaceIds()},
       dataType:"json",
       url: url,
       success: function(result){

       }
   }); 
  
}


function getaceIds()
{
	var aceIds = "" ;
	
	$(".doc_ace").each(function(){
		if (aceIds != "")
			aceIds += "," ;
		//得到本行的ID
		var id = $(this).attr("data-id") ;
		var power = 0 ;
		//统计权限
		$(".chk_power",$(this)).each(function(){
			if ($(this).is(":checked"))
				power += parseInt($(this).val());
		})
		aceIds += id + "-" + power;
	})
	
	return aceIds ;
}