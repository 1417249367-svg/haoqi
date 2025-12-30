var errors = {
    err_0:"未知错误",
    err_10000:"数据库连接错误",
    err_10009:"{name}不能为空",
    err_10008:"{name}已经存在",

    err_101001:"没有权限",
    err_102001:"帐号不存在",
    err_102002:"密码错误",
    err_102003:"帐号被禁用",
	err_102004:"帐号不是管理员",
    err_102005:"验证码错误",
    err_102006:"错误次数超过，您已被限制登录",
    err_102007:"用户帐号只允许在指定mac或ip电脑登录，请与管理员联系!",

    err_102101:"用户不存在",
    err_102102:"用户已经存在",
    err_102103:"用户不能删除",

    err_102201:"部门不存在",
    err_102202:"部门已经存在",
    err_102203:"部门删除失败，可能有子部门",
    err_102204:"部门成员已经存在",
    err_102205:"不能移动部门到根节点下",
    err_102206:"不能移动部门到自己或子孙节点下",
    err_102211:"系统节点不能添加人员",
    err_102212:"不能将人员设置到根节点下",
    err_102213:"系统节点不能修改或删除",
    err_102301:"角色已经存在",
    err_102302:"角色不能为空",
    err_102401:"视图已经存在",
    err_102501:"授权已经存在",
    err_102601:"请选择要设置的对象",
    err_102701:"此部门已经授权过",

    err_999999:""
};

var langs ={
	
    text_loading:"正在加载中..." ,
    text_norecord:"没有数据" ,
	
	pager_error_content:"输入内容不正确",
	pager_info:"第 {PageIndex} 页 / 共 {PageCount} 页 ，每页 {PageSize} 条 ",
	
	userpicker_exist:"人员【{User}】已经存在",
	
	sms_require_mobile:"用户没有登记手机号码，不能选择",
	sms_require_recver:"请选择接收的人员",
	sms_require_content:"请输入短信的内容",
	sms_require_sendtime:"请输入定时发送的时间",
	sms_recver_count_over:"一次人员不得超过{Count}人",
	sms_content_over:"短信内容最长{Max}个字",
	sms_content_length:"短信内容最长{Max}个字，还剩{Last}个字",
	sms_content_specialchar:"短信内中不能包含以下字符",
	sms_send_success:"短信发送成功",
	sms_send_fail:"短信发送失败：{Error}",
	
	board_create:"新增",
	board_edit:"修改",
	
	user:"用户",
	user_create:"新增人员",
	user_edit:"编辑人员",
	user_delete:"删除人员",
	user_set:"设置人员",
	user_delete_confirm:"确定删除用户",
	user_select_text:"请选择用户",
	user_attr:"批量修改属性",
	user_exists:"人员【{user}】已经存在",
	user_curr_userid:"人员【{user}】不能为自己",
	
	user_phpform_name_text:"共享名称不能为空",
	user_phpform_text:"共享成员不能为空",
	
	board_list_code_bulid_tip:"复制链接成功,请粘贴到浏览器下载",
	
	pic:"[图片]",
	video:"[视频]",
	
	doc_clipboard:"复制",
	doc_clipboardData:"请复制url粘贴到IE浏览器打开!",
	
	end:""
}

