/*****************************************************
* 关系操作,适用于 hs_relation,hs_itemace,hs_biiace,hs_bioace,tab_bioace
* 输入参数
* 关系表名	table_name			hs_biiace 
* 关键字段	field_key_name		col_hsitemtype,col_hsitemid,col_funname,col_fungenre
* 关键值	field_key_value		3,'ProjectCreate','PM'
* 子字段	child_field			col_dhsitemid
* 当前值	child_ids			1,2
* 附加字段	field_other_name	col_power
* 附加值	field_other_value	1
* 初始模式  init   0 不初始 1 得到原来值
* 操作方式	flag   0 追加 	1 重置

* 方法 
* relation_get_data
* relation_set_data
* relation_picker
*****************************************************/

var relation_opts ={
		table_name:"tab_bioace",
		field_key_name:"col_funname,col_fungenre",
		field_key_value:"DocAce,",
		};

function relation_picker(picker_title,picker_url,opts)
{
    relation_opts = jQuery.extend(relation_opts,opts);
	dialog("picker",picker_title,picker_url) ;
}

function relation_set_data()
{
   setLoadingBtn($("#btn_picker_submit")) ;

   child_ids = getCheckValue("empid"); 

   var url = getAjaxUrl("relation","set_data") ;

   $.ajax({
	   type: "POST",
	   dataType:"json",
	   data:relation_opts,
	   url: url,
	   success: function(result){
			if (result.status)
			{
				myAlert("操作成功");
				dataList.reload();
				dialogClose("picker");
			}
			else
			{
				myAlert(getErrorText(result.errnum));
			}
	   }
   }); 
}