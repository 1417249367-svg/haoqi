var errors = {
	err_0:"Unknown error",
	err_10000:"Database connection error",
	err_10009:"{name} cannot be empty",
	err_10008:"{name} already exists",
	
	err_101001:"No permission",
	err_102001:"Account number does not exist",
	err_102002:"Password error",
	err_102003:"Account is disabled",
	err_102004:"The account is not an administrator",
	err_102005:"verification code error",
	err_102006:"The number of errors has exceeded. You have been restricted from logging in",
	err_102007:"The user account is only allowed to log in on the specified mac or ip computer. Please contact the administrator!",
	
	err_102101:"User does not exist",
	err_102102:"User already exists",
	err_102103:"User cannot delete",
	
	err_102201:"Department does not exist",
	err_102202:"The department already exists",
	err_102203:"Department deletion failed. There may be sub-departments",
	err_102204:"Department member already exists",
	err_102205:"Cannot move a department to the root node",
	err_102206:"Cannot move a department to its own or descendant node",
	err_102211:"The system node cannot add personnel",
	err_102212:"Cannot set personnel under the root node",
	err_102213:"The system node cannot be modified or deleted",
	err_102301:"Role already exists",
	err_102302:"Role cannot be empty",
	err_102401:"View already exists",
	err_102501:"Authorization already exists",
	err_102601:"Please select the object to set",
	err_102701:"This department has been authorized",

    err_999999:""
};

var langs ={
	
    text_loading:"Loading..." , //"正在加载中..."
    text_norecord:"No data" , //"没有数据"
	
	pager_error_content:"Please do not enter the illegal characters",
	pager_info:"Page {PageIndex} of {PageCount} pages, {PageSize} msgs per page ",
	
	userpicker_exist:"The user 【{User}】 already exists", //"人员【{User}】已经存在"
	
	sms_require_mobile:"Cannot select the user since the user is not registered mobile phone number", //"用户没有登记手机号码，不能选择"
	sms_require_recver:"Please select the recipient", //"请选择接收的人员"
	sms_require_content:"Please enter the sms content", //"请输入短信的内容"
	sms_require_sendtime:"Please enter the setted send time", //"请输入定时发送的时间"
	sms_recver_count_over:"The number of user cannot exceed {Count} at a time", //"一次人员不得超过{Count}人"
	sms_content_over:"The longest length of the sms content is {Max} words", //"短信内容最长{Max}个字"
	sms_content_length:"The longest length of the sms content is {Max} words，with {Last} words remaining", //"短信内容最长{Max}个字，还剩{Last}个字"
	sms_content_specialchar:"SMS and cannot contain the following characters",
	sms_send_success:"Send sms successfully", //"短信发送成功"
	sms_send_fail:"Failed to send sms：{Error}", //"短信发送失败：{Error}"
	
	board_create:"New",
	board_edit:"Modify",
	
	user:"User",
	user_create:"Add Person",
	user_edit:"Editor",
	user_delete:"Delete person",
	user_set:"Set People",
	user_delete_confirm:"OK to delete the user",
	user_select_text:"Please select a user",
	user_attr:"Edit attributes in bulk",
	user_exists:"Person [{user}] already exists",
	user_curr_userid:"Person [{user}] cannot be himself",
	
	user_phpform_name_text:"Share name cannot be empty",
	user_phpform_text:"Shared members cannot be empty",
	
	board_list_code_bulid_tip:"Copy link successfully, please paste it into your browser to download",
	
	pic:"[picture]",
	video:"[video]",
	
	doc_clipboard:"Copy",
	doc_clipboardData:"Please copy and paste the url to IE browser to open!",
	
	end:""
}
