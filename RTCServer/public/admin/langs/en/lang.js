var errors = {
    err_0:"Unknow Error", //"未知错误",
    err_10000:"Error connecting to database", //"数据库连接错误",
    err_10009:"{name} cannot be empty", //"{name}不能为空",
    err_10008:"{name} is already exist", //"{name}已经存在",

    err_101001:"Permission denied", //"没有权限",
    err_102001:"Account is not exist", //"帐号不存在",
    err_102002:"Invalid password", //"密码错误",
    err_102003:"The account is disabled", //"帐号被禁用",
	err_102004:"The account is not the administrator", //"帐号不是管理员",
    err_102005:"Wrong captcha", //"验证码错误",
    err_102006:"You have been restricted to login since the error number exceeds limits", //"错误次数超过，您已被限制登录",
	err_102007:"Non-administrative account does not allow access to the system",

    err_102101:"The user is not exist", //"用户不存在",
    err_102102:"The user is already exist", //"用户已经存在",
    err_102103:"The User cannot be deleted", //"用户不能删除",
	err_102104: "The username cannot contain Chinese characters!",

    err_102201:"The department is not exist", //"部门不存在",
    err_102202:"The department is already exist", //"部门已经存在",
    err_102203:"Delete the department failed due to having sub-department", //"部门删除失败，可能有子部门",
    err_102204:"Department member is already exist", //"部门成员已经存在",
    err_102205:"Cannot move the department to the root directory", //"不能移动部门到根节点下",
    err_102206:"Cannot move department behind its own or sub-department", //"不能移动部门到自己或子孙节点下",
    err_102211:"Cannot add user under root directory", //"系统节点不能添加人员",
    err_102212:"Cannot set people to the root node", //"系统节点不能设置成员",
    err_102213:"Cannot change or delete the root directory", //"系统节点不能修改或删除",
    err_102301:"The role is already exist", //"角色已经存在",
	err_102302:"Role cannot be empty",
    err_102401:"The chart is already exist", //"视图已经存在",
    err_102501:"The authorization is already exist", //"授权已经存在",
    err_102601:"Please select the object you want to set", //"请选择要设置的对象",
    err_102701:"This department has been authorized.",
    
    err_999999:""
};


var cmds = {
    cmd_101:"Launch message server", //"开启消息服务器",
	cmd_102:"Restart message server", //"重启消息服务器",
	cmd_103:"Shut down message server", //"关闭消息服务器",
    cmd_201:"Launch audio server", //"开启语音服务器",
	cmd_202:"Restart audio server", //"重启语音服务器",
	cmd_203:"Shut down audio server", //"关闭语音服务器",
    cmd_301:"Launch document server", //"开启文档服务器",
	cmd_302:"Restart document server", //"重启文档服务器",
	cmd_303:"Shut down document server", //"关闭文件服务器",
    cmd_401:"Launch file server", //"开启文件服务器",
	cmd_402:"Restart file server", //"重启文件服务器",
	cmd_403:"Shut down file server", //"关闭文件服务器",
	cmd_999:""
};

var langs = {

	sex_0:"--",
    sex_1:"Male", //"男",
    sex_2:"Female", //"女",
    yes:"Yes", //"是",
    no:"No", //"否",


    btn_create:"Add", //"新增",
    btn_edit:"Edit", //"修改",
    btn_delete:"Delete", //"删除",
	btn_close:"Close", //"关闭",
	btn_clear:"Clear", //"清除",
	btn_save:"Save", //"保存",
	btn_set:"Setting", //"设置",
	btn_cancel:"Cancel", //"取消",
	
    text_loading:"Loading", //"正在加载中" ,
	text_uploading:"Uploading...", //"正在上传中...",
    text_connecting:"Connecting...", //"正在连接中..." ,
	text_saveing:"Saving...", //"正在保存中...",
	text_select_data:"Please select data", //"请选择数据"
    text_delete_confirm:"Are you sure to delete?", //"确定要删除吗" ,
    text_clear_confirm:"Are you sure to clear?", //"确定要删除吗" ,
    text_norecord:"No data", //"没有数据" ,
    text_user_count:"Total %1 users", //"共%1个用户",
	text_op_success:"Operate successfully", //"操作成功",
	text_set_success:"Set successfully", //"设置成功",
	text_tip:"Tip", //"提示",
	text_about:"About", //"关于",
	text_register:"Registered Information", //"注册信息",
	text_status_success:"Success", //"成功",
	text_status_fail:"Fail", //"失败",
	text_allow:"Allow", //"允许",
	text_disabled:"Disabled", //"禁用",
	text_no_power:"no power",
	
	pager_error_content: "Incorrect input content",
	pager_info: "Page {PageIndex} of {PageCount} pages, {PageSize} per page",


	vaild_special_char:"Please do not enter the illegal characters", //"请勿输入非法字符",
	valid_integer:"The number must be a positive integer", //"序号必须是正整数",
	valid_select_file:"please select file to upload", 
	valid_select_pic:"please select picture",
	valid_select_file_limit:"The file type should be one of the [{FileType}]" ,
	
    field_loginname:"Account", //"帐号",
    field_password:"Password", //"密码",
    field_username:"Name", //"姓名",
    field_sex:"Gender", //"性别",
    field_deparment:"Department", //"部门",
    field_job:"Job", //"职位",
    field_mobile:"Mobile", //"手机",
    field_phone:"Telephone", //"电话",
	field_expiretime: "Long-term effective",
	
	dept:"Department", //"部门",
    dept_create:"Add Department", //"新增部门",
    dept_edit:"Edit Department", //"编辑部门",
    dept_delete:"Delete Dept.", //"删除部门",
    dept_member:"Dept. Member", //"部门成员",
	dept_move:"Move Department", //"部门移动",
	dept_select:"Select Department", //"选择部门",
	dept_set:"Set Department", //"设置部门",
    dept_select_text:"Please select the department", //"请选择部门",
    dept_member_move:"Move to department", //"移动到部门" ,
    dept_member_copy:"Copy to department", //"复制到部门",
    dept_set_member:"User Setup", //"设置成员",
    dept_delete_confirm:"Are you sure to delete the department?", //"确定删除部门",
	dept_root_delete_error:"The root node can not be deleted", //"根结点不能删除",
	dept_move_error:"The root node can not be moved", //"根结点或一级结点不能移动",
	dept_move_target_root:"Unable to select the root node", //"不能选择根结点",
	dept_move_target_self:"Can not to move to the original location", //"不能自己移到自己",
	
	user:"User", //"用户",
    user_create:"Add User", //"新增人员",
    user_edit:"Edit User", //"编辑人员",
    user_delete:"Delete User", //"删除人员",
	user_set:"Set User", //"设置人员",
    user_delete_confirm:"Are you sure to delete the user", //"确定删除用户",
    user_select_text:"Please select the user", //"请选择用户",
	user_attr:"Batch edit properties", //"批量修改属性",
 	user_exists:"The user 【{user}】already exist", //"人员【{user}】已经存在",
 	user_select:"Select the number of too much, please load classification",//选择的人数过多,请分级加载
	
	role:"Role", //"角色",
    role_create:"Add Role", //"新增角色",
    role_edit:"Edit Role", //"编辑角色",
	role_copy: "Clone Role",
    role_delete:"Delete Role", //"删除角色",
	role_set:"Set Roles", //"设置角色",
	role_delete_system:"The account of admin has no permission to do this.", //"everyone角色不允许此操作",
	role_delete_default: "The default role does not allow this operation",
	role_create_batch_doing:"Batch creating roles, please wait...", //"正在批量创建角色，请稍等...",
	
    group_create:"Add Group", //"新增群组",
    group_edit:"Edit Group", //"编辑群组",
    group_delete:"Delete Group", //"删除群组",
	group_type_fixed:"Assigned Group", //"固定群",
	group_type_temp:"Personal Group", //"个人群",
	group_name_require:"Please enter the group name", //"请输入群名称",
	group_order_require_integer:"The sequence number must be positive integer", //"排序号必须是正整数",
	group_diskspace_require_integer:"The shared space size must be positive integer", //"共享空间大小必须是正整数",
    group_warning: "Group members must be more than 2 people",
 
    grant_create:"Add Permission", //"新增授权",
    grant_edit:"Edit Permission", //"编辑授权",
    grant_delete:"Delete Permission", //"删除授权",
	
	import_user:"Import User", //"导入用户",
	import_txt: "Import verification file",
	import_dept:"Import Department", //"导入部门",
	import_ad:"Import Domain User", //"导入域用户",
	import_rtx: "Import rtx user",
	import_plugins:"Import plugins",
	import_doing:"Importing, please wait...", //"正在导入，请稍等...",
	import_success:"Import successfully, please refresh the page to view the content", //"操作成功,请刷新页面查看内容",
	
	export_user:"Export User", //"导出用户",
	export_dept:"Export Department", //"导出部门",
	export_doing:"Exporting, please wait", //"正在导出，请稍等...",
	export_fail:"Failed to export", //"导出失败",
	export_user_require:"Please select the user you want to export", //"请选择导出的用户",
	
	syncpush_org_success:"Syncpush success", //"推送完成",
	syncpush_org_doing:"Syncpush, please wait...", //"正在推送，请稍等...",

	
	
	emp_pinyin_seting:"Batch setting spelling, please wait...", //"正在批量设置拼音，请稍等...",
	emp_deptpath_seting:"Batch setting spelling, please wait...", //"正在批量设置拼音，请稍等...",
	emp_order_seting:"Batch sorting users, please wait...", //"正在批量设置人员排序，请稍等...",
    ace_set:"Set Permission", //"设置权限",

	hl_config_save:"Save the configuration information", //"保存配置信息",

    push_create:"Add access system", //"新增推送",
    push_edit:"Edit access system", //"修改推送",

    reg_success:"Register successfully", //"注册成功",
	
	link_view:"Check links", //"查看链接",
	
    pos_edit:"Edit Tag", //"编辑铭牌",
    pos_create:"Add Tag", //"新增铭牌",
    pos_delete:"Delete Tag", //"删除铭牌",
	pos_icon_tip:"The icon size is 16px*16px", //"图标尺寸为16px*16px",
	pos_name_require:"Please enter tag name", //"请输入铭牌名称",
	pos_icon_require:"Please upload the tag icon", //"请上传铭牌图标",

    client_edit:"Edit Client", //"编辑客户端",
    client_create:"Publish Client", //"发布客户端",
	client_name_require:"Please enter client name", //"请输入客户端名称",
	client_version_require:"Please enter client version", //"请输入客户端版本",
	client_pack_require:"Please upload client installer package", //"请上传客户端安装包！",
	client_uploading:"Upoading installer package, please wait...", //"正在上传安装包，请稍候...",
	
	doc_root_create:"Add Root Directory", //"新增根目录",
	doc_root_edit:"Edit Root Directory", //"新增根目录",
	doc_dir_create:"Add Directory", //"新增目录",
	doc_dir_edit:"Edit Directory", //"修改目录",
	doc_dir_require:"Please select directory", //"请选择目录",
	doc_dir_delete_confirm:"Are you sure to delete {dir}?", //"你确定要删除{dir}吗?",
	doc_dir_delete_fail:"Failed to delete file directory due to having sub-directory", //"文档目录删除失败，可能有子目录",
	doc_dir_clean:"Clean folder",
	doc_dir_warning1:"Folder cleanup successful!",
	doc_dir_warning:"Members cannot be empty!",
	doc_public_file:"Public documents",
	
	livechat_status_open: "Open",
	livechat_status_close: "Close",
	livechat_history_view: "View conversation history",
	livechat_chater_create: "Add new customer service",
	livechat_chater_edit: "Edit Support",
	livechat_user_edit: "Edit Guest",
	livechat_code_bulid: "Generate customer service code",
	livechat_code_bulid_tip: "Please paste the code in the input box into the web page!",
	livechat_serverip: "Please enter the server address",
	livechat_warning: "Online customer service must have at least 1 person",
	livechat_edit: "Online Support",
	livechat_edit_reception_require_integer: "The maximum number of receptions must be a positive integer",
	
	livechat_blackip_create: "Add blacklist ip record",
	livechat_blackip_edit: "Edit blacklist ip record",
	livechat_blackip_youid_require: "Please enter the visitor ID",
	livechat_blackip_to_ip_require: "Please enter the IP",
	livechat_blackip_create_ok: "Added blacklist ip record successfully",
	livechat_blackip_to_type3:"Single Chat",
	livechat_blackip_to_type6:"Group Chat",
	
	livechat_chater_ro_create: "Add Entry",
	livechat_chater_ro_edit: "Edit Entry",
	livechat_chater_ro_name_require: "Please enter the entrance name",
	livechat_chater_ro_order_require_integer: "The sort number must be a positive integer",
	livechat_chater_ro_warning: "Member cannot be empty",
	
	livechat_user_ro_create: "Add guest tag",
	livechat_user_ro_edit: "Edit Guest Tag",
	livechat_user_ro_name_require: "Please enter the tag name",
	livechat_user_ro_order_require_integer: "Sort number must be a positive integer",
	
	livechat_chater_theme_create: "New Session Theme",
	livechat_chater_theme_edit: "Edit conversation theme",
	livechat_chater_theme_name_require: "Please enter the name of the session theme",
	livechat_chater_theme_order_require_integer: "The sort number must be a positive integer",
	livechat_chater_theme_ro1: "Use theme",
	livechat_chater_theme_ro2: "History Theme",
	
	livechat_chater_domain_create: "Add a domain name after redirection",
	livechat_chater_domain_edit: "Edit the domain name after redirection",
	livechat_chater_domain_name_require: "Please enter the domain name address after the page is redirected",
	livechat_chater_domain_order_require_integer: "The order number must be a positive integer",
	livechat_chater_domain_delete_default: "The domain name being used does not allow this operation",
	livechat_chater_domain_ro2: "Historical Theme",
	
	livechat_chater_wechat_create: "Add a new WeChat official account/applet",
	livechat_chater_wechat_edit: "Edit WeChat official account/applet",
	livechat_chater_domain_name_require: "Please enter the authorized domain name for the webpage",
	livechat_chater_wechat_delete_default: "This operation is not allowed for the WeChat official account/applet being used",
	
	link_create:"Add Link", //"新增链接",
	link_edit:"Edit Link", //"修改链接",
	link_name_require:"Please enter link name", //"请输入链接名称",
	link_url_require:"Please enter link address", //"请输入链接地址",
	
	question_create: "New Question",
	question_edit: "Edit Question",
	question_subject_require: "Please enter a question",
	question_usertext_require: "Please enter an answer",
	question_ord_require:"Please enter the serial number",
	
	quicktalk_create: "New common words",
	quicktalk_edit: "Modify common words",
	quicktalk_subject_require: "Please enter a title",
	quicktalk_usertext_require: "Please enter content",
	quicktalk_ord_require: "Please enter the sort number",
	
	file_create:"Add File", //"新增文件",
	file_edit:"Edit File", //"修改文件",
	file_name_require:"Please enter file name", //"请输入文件名称",
	file_path_require:"Please enter file address", //"请输入文件地址",
	
	service_port_set:"Set Port", //"设置端口",
	service_select_tip:"Please select the server you want to set", //"请选择要操作的服务",
	
	config_ios_title:"Configuration of iOS push", //"iOS推送配置",
	config_clear_confim:"Are you sure to delete the data earlier than {days} days!", //"你确定要删除{days}天前的数据吗！",
	config_clear_tip:"The data can not be recovered after deletion", //"数据删除后不能还原",
	config_clear_days_error:"Please enter the correct number of days", //"请输入正确的天数",
	config_clear_doing:"Clearing", //"正在清除中",
	config_clear_success:"Clear completely", //"清除完成",
	
	skin_cancel_doing:"Canceling skin usage", //"正在取消皮肤应用",
	skin_set_doing:"Applyig skin settings", //"正在应用皮肤设置",
	
	status_online:"online",
	status_offline:"offline",
	status_go_away: "leave",
	status_mobile_online: "mobile online",

	software_upgrade:"software upgrade",
	
	rtc_console: "Data directory is incorrect",
	
	doc_clipboardData: "Copy link succeeded",
	doc_jsclipboardData: "Copy code succeeded",
	
	text_delete_config: "Delete file?",
	
	lv_chat_file: "[FILE]",
	lv_chat_location: "[location]",
	lv_chat_pic: "[Picture]",
	lv_chat_expression: "[[Expression]",
	lv_chat_video: "[Video]",
	lv_chat_voice: "[Voice Message]",
	lv_chat_link: "[link]",
	lv_chat_card: "[business card]",
	lv_voice_call: "[Voice Call]",
	lv_video_call: "[Video Call]",
	
	lv_ChatGPT_warning:"ChatGPT apikey error!",
	
	doc_set:"Permission Settings",
	user_select_text:"Please select a user",
 	user_exists:"Personnel [{user}] already exists",
	user_curr_userid:"Personnel [{user}] cannot be themselves",
	text_loading:"Loading..." ,
	btn_delete:"Delete",
	onlinefile_text:"Online document cannot be empty",
	
    end:""
};


var serviceState = {

    running:"Running", //"运行中",
    stop:"Stop", //"已停止",
    pause:"Pause", //"已暂停",
	error:"Error", //"打开服务出错"
    unknown:"Unknow", //"未知状态",
    
};


var pushDataType = {
	org:"Org",
    user:"User",
    dept:"Dept",
    group:"Group",
    msg:"Msg"

};
