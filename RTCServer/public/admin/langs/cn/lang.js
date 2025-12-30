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
    err_102007:"非管理帐号，不允许进入系统",

    err_102101:"用户不存在",
    err_102102:"用户已经存在",
    err_102103:"用户不能删除",
	err_102104:"用户名不能含有汉字！",

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


var cmds = {
    cmd_101:"开启消息服务器",
	cmd_102:"重启消息服务器",
	cmd_103:"关闭消息服务器",
    cmd_201:"开启语音服务器",
	cmd_202:"重启语音服务器",
	cmd_203:"关闭语音服务器",
    cmd_301:"开启文档服务器",
	cmd_302:"重启文档服务器",
	cmd_303:"关闭文件服务器",
    cmd_401:"开启文件服务器",
	cmd_402:"重启文件服务器",
	cmd_403:"关闭文件服务器",
	cmd_999:""
};

var langs = {

	sex_0:"--",
    sex_1:"男",
    sex_2:"女",
    yes:"是",
    no:"否",
	

    btn_create:"新增",
    btn_edit:"修改",
    btn_delete:"删除",
	btn_close:"关闭",
	btn_clear:"清除",
	btn_save:"保存", 
	btn_set:"设置",
	btn_cancel:"取消",
	
    text_loading:"正在加载中..." ,
	text_uploading:"正在上传中...",
    text_connecting:"正在连接中..." ,
	text_saveing:"正在保存中...",
	text_select_data:"请选择数据",
    text_delete_confirm:"确定要删除吗" ,
    text_clear_confirm:"确定要清除吗" ,
    text_norecord:"没有数据" ,
    text_user_count:"共%1个用户",
	text_op_success:"操作成功",
	text_set_success:"设置成功",
	text_tip:"提示",
	text_about:"关于",
	text_register:"注册信息",
	text_status_success:"成功",
	text_status_fail:"失败",
	text_allow:"允许",
	text_disabled:"禁用",
	text_no_power:"没有权限",
	
	pager_error_content:"输入内容不正确",
	pager_info:"第 {PageIndex} 页 / 共 {PageCount} 页 ，每页 {PageSize} 条 ",
 
	
	vaild_special_char:"请勿输入非法字符",
	valid_integer:"序号必须是正整数",
	valid_select_file:"请选择上传的文件",
	valid_select_pic:"请选择图片文件",
	valid_select_file_limit:"文件类型必须是[{FileType}]中的一种",
	
    field_loginname:"帐号",
    field_password:"密码",
    field_username:"姓名",
    field_sex:"性别",
    field_deparment:"部门",
    field_job:"职位",
    field_mobile:"手机",
    field_phone:"电话",
	field_expiretime:"长期有效",
	
	dept:"部门",
    dept_create:"新增部门",
    dept_edit:"编辑部门",
    dept_delete:"删除部门",
    dept_member:"部门成员",
	dept_move:"部门移动",
	dept_select:"选择部门",
	dept_set:"设置部门",
    dept_select_text:"请选择部门",
    dept_member_move:"移动到部门" ,
    dept_member_copy:"复制到部门",
    dept_set_member:"设置成员",
    dept_delete_confirm:"确定删除部门",
	dept_root_delete_error:"根结点不能删除",
	dept_move_error:"根结点不能移动",
	dept_move_target_root:"不能选择根结点",
	dept_move_target_self:"不能自己移到自己",
	
	user:"用户",
    user_create:"新增人员",
    user_edit:"编辑人员",
    user_delete:"删除人员",
	user_set:"设置人员",
    user_delete_confirm:"确定删除用户",
    user_select_text:"请选择用户",
	user_attr:"批量修改属性",
 	user_exists:"人员【{user}】已经存在",
	user_select:"选择的人数过多,请分级加载",
	
	role:"角色",
    role_create:"新增角色",
    role_edit:"编辑角色",
	role_copy:"克隆角色",
    role_delete:"删除角色",
	role_set:"设置角色",
	role_delete_system:"admin帐号不允许此操作",
	role_delete_default:"默认角色不允许此操作",
	role_create_batch_doing:"正在批量创建角色，请稍等...",
	
    group_create:"新增群组",
    group_edit:"编辑群组",
    group_delete:"删除群组",
	group_type_fixed:"固定群",
	group_type_temp:"个人群",
	group_name_require:"请输入群名称",
	group_order_require_integer:"排序号必须是正整数",
	group_diskspace_require_integer:"共享空间大小必须是正整数",
	group_warning:"群组成员必须2个人以上",
	
    grant_create:"新增授权",
    grant_edit:"编辑授权",
    grant_delete:"删除授权",
	
	import_user:"导入用户",
	import_txt:"导入验证文件",
	import_dept:"导入部门",
	import_ad:"导入域用户",
	import_rtx:"导入rtx用户",
	import_plugins:"导入插件",
	import_doing:"正在导入，请稍等...",
	import_success:"操作成功,请刷新页面查看内容",
	
	export_user:"导出用户",
	export_dept:"导出部门",
	export_doing:"正在导出，请稍等...",
	export_fail:"导出失败",
	export_user_require:"请选择导出的用户",
	
	syncpush_org_success:"推送完成",
	syncpush_org_doing:"正在推送，请稍等...",

	
	
	emp_pinyin_seting:"正在批量设置拼音，请稍等...",
	emp_deptpath_seting:"正在批量设置部门长路径，请稍等...",
	emp_order_seting:"正在批量设置人员排序，请稍等...",
    ace_set:"设置权限",

	hl_config_save:"保存配置信息",

    push_create:"新增推送",
    push_edit:"修改推送",

    reg_success:"注册成功",
	
	link_view:"查看链接",
	
    pos_edit:"编辑铭牌",
    pos_create:"新增铭牌",
    pos_delete:"删除铭牌",
	pos_icon_tip:"图标尺寸为16px*16px",
	pos_name_require:"请输入铭牌名称",
	pos_icon_require:"请上传铭牌图标",

    client_edit:"编辑客户端",
    client_create:"发布客户端",
	client_name_require:"请输入客户端名称",
	client_version_require:"请输入客户端版本",
	client_pack_require:"请上传客户端安装包！",
	client_uploading:"正在上传安装包，请稍候...",
	
	doc_root_create:"新增根目录",
	doc_root_edit:"新增根目录",
	doc_dir_create:"新增目录",
	doc_dir_edit:"修改目录",
	doc_dir_require:"请选择目录",
	doc_dir_delete_confirm:"你确定要删除{dir}吗?",
	doc_dir_delete_fail:"文档目录删除失败，可能有子目录",
	doc_dir_clean:"清理文件夹",
	doc_dir_warning1:"文件夹清理成功!",
	doc_dir_warning:"成员不能为空!",
	doc_public_file:"公共文档",
	
	livechat_status_open:"打开",
	livechat_status_close:"关闭",
	livechat_history_view:"查看谈话记录",
	livechat_chater_create:"新增客服",
	livechat_chater_edit:"编辑客服",
	livechat_user_edit:"编辑访客",
	livechat_code_bulid:"生成客服代码",
	livechat_code_bulid_tip:"请将输入框内的代码粘贴到网页中！",
	livechat_serverip:"请输入服务器地址",
	livechat_warning:"在线客服至少要有1人",
	livechat_edit:"在线客服",
	livechat_edit_reception_require_integer:"最大接待量必须是正整数",
	
	livechat_blackip_create:"新增黑名单ip记录",
	livechat_blackip_edit:"编辑黑名单ip记录",
	livechat_blackip_youid_require:"请输入访客ID",
	livechat_blackip_to_ip_require:"请输入IP",
	livechat_blackip_create_ok:"新增黑名单ip记录成功",
	livechat_blackip_to_type3:"单聊",
	livechat_blackip_to_type6:"群聊",
	
	livechat_chater_ro_create:"新增入口",
	livechat_chater_ro_edit:"编辑入口",
	livechat_chater_ro_name_require:"请输入入口名称",
	livechat_chater_ro_order_require_integer:"排序号必须是正整数",
	livechat_chater_ro_warning:"成员不能为空",
	
	livechat_user_ro_create:"新增访客标签",
	livechat_user_ro_edit:"编辑访客标签",
	livechat_user_ro_name_require:"请输入标签名称",
	livechat_user_ro_order_require_integer:"排序号必须是正整数",
	
	livechat_chater_theme_create:"新增会话主题",
	livechat_chater_theme_edit:"编辑会话主题",
	livechat_chater_theme_name_require:"请输入会话主题名称",
	livechat_chater_theme_order_require_integer:"排序号必须是正整数",
	livechat_chater_theme_ro1:"使用主题",
	livechat_chater_theme_ro2:"历史主题",
	
	livechat_chater_domain_create:"新增跳转后的域名",
	livechat_chater_domain_edit:"编辑跳转后的域名",
	livechat_chater_domain_name_require:"请输入页面跳转后域名地址",
	livechat_chater_domain_order_require_integer:"排序号必须是正整数",
	livechat_chater_domain_delete_default:"正在使用的域名不允许此操作",
	livechat_chater_domain_ro2:"历史主题",
	
	livechat_chater_wechat_create:"新增微信公众号/小程序",
	livechat_chater_wechat_edit:"编辑微信公众号/小程序",
	livechat_chater_domain_name_require:"请输入网页授权域名",
	livechat_chater_wechat_delete_default:"正在使用的微信公众号/小程序不允许此操作",
	
	link_create:"新增链接",
	link_edit:"修改链接",
	link_name_require:"请输入链接名称",
	link_url_require:"请输入链接地址",
	
	question_create:"新增问题",
	question_edit:"修改问题",
	question_subject_require:"请输入问题",
	question_usertext_require:"请输入答案",
	question_ord_require:"请输入排序号",
	
	quicktalk_create:"新增常用语",
	quicktalk_edit:"修改常用语",
	quicktalk_subject_require:"请输入标题",
	quicktalk_usertext_require:"请输入内容",
	quicktalk_ord_require:"请输入排序号",
	
	file_create:"新增文件",
	file_edit:"修改文件",
	file_name_require:"请输入文件名称",
	file_path_require:"请输入文件地址",
	
	service_port_set:"设置端口",
	service_select_tip:"请选择要操作的服务",
	
	config_ios_title:"iOS推送配置",
	config_clear_confim:"你确定要删除{days}天前的数据吗！",
	config_clear_tip:"数据删除后不能还原",
	config_clear_days_error:"请输入正确的天数",
	config_clear_doing:"正在清除中",
	config_clear_success:"清除完成",
	
	skin_cancel_doing:"正在取消皮肤应用",
	skin_set_doing:"正在应用皮肤设置",
	
	status_online:"在线",
	status_offline:"离线",
	status_go_away:"离开",
	status_mobile_online:"手机在线",
	
	software_upgrade:"软件升级",
	
    rtc_console:"数据目录不正确",
	
	doc_clipboardData:"复制链接成功",
	doc_jsclipboardData:"复制代码成功",
	
	text_delete_config:"是否删除文件?",
	
	lv_chat_file:"[文件]",
	lv_chat_location : "[位置]",
	lv_chat_pic:"[图片]",
	lv_chat_expression : "[表情]",
	lv_chat_video:"[视频]",
	lv_chat_voice:"[语音消息]",
	lv_chat_link:"[链接]",
	lv_chat_card:"[名片]",
	lv_voice_call:"[语音电话]",
	lv_video_call:"[视频电话]",
	
	lv_ChatGPT_warning:"ChatGPT apikey错误!",
	
	doc_set:"权限设置",
	user_select_text:"请选择用户",
 	user_exists:"人员【{user}】已经存在",
	user_curr_userid:"人员【{user}】不能为自己",
	text_loading:"正在加载中..." ,
	btn_delete:"删除",
	onlinefile_text:"在线文档不能为空",
	
    end:""
};


var serviceState = {

    running:"运行中",
    stop:"已停止",
    pause:"已暂停",
    error:"未知状态",
    unknown:"打开服务出错"

};


var pushDataType = {
	org:"组织",
    user:"人员",
    dept:"部门",
    group:"群组",
    msg:"消息"

};

