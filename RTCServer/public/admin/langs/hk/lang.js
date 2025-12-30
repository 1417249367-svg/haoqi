var errors = {
    err_0:"未知錯誤",
    err_10000:"數據庫連接錯誤",
    err_10009:"{name}不能為空",
    err_10008:"{name}已經存在",

    err_101001:"沒有權限",
    err_102001:"帳號不存在",
    err_102002:"密碼錯誤",
    err_102003:"帳號被禁用",
    err_102004:"帳號不是管理員",
    err_102005:"驗證碼錯誤",
    err_102006:"錯誤次數超過，您已被限制登錄",
    err_102007:"非管理帳號，不允許進入系統",

    err_102101:"用戶不存在",
    err_102102:"用戶已經存在",
    err_102103:"用戶不能刪除",
    err_102104:"用戶名不能含有漢字！",

    err_102201:"部門不存在",
    err_102202:"部門已經存在",
    err_102203:"部門刪除失敗，可能有子部門",
    err_102204:"部門成員已經存在",
    err_102205:"不能移動部門到根節點下",
    err_102206:"不能移動部門到自己或子孫節點下",
    err_102211:"系統節點不能添加人員",
    err_102212:"不能將人員設置到根節點下",
    err_102213:"系統節點不能修改或刪除",
    err_102301:"角色已經存在",
    err_102302:"角色不能為空",
    err_102401:"視圖已經存在",
    err_102501:"授權已經存在",
    err_102601:"請選擇要設置的對象",
    err_102701:"此部門已經授權過",

    err_999999:""
};


var cmds = {
	cmd_101:"開啟消息服務器",
	cmd_102:"重啟消息服務器",
	cmd_103:"關閉消息服務器",
	cmd_201:"開啟語音服務器",
	cmd_202:"重啟語音服務器",
	cmd_203:"關閉語音服務器",
	cmd_301:"開啟文檔服務器",
	cmd_302:"重啟文檔服務器",
	cmd_303:"關閉文件服務器",
	cmd_401:"開啟文件服務器",
	cmd_402:"重啟文件服務器",
	cmd_403:"關閉文件服務器",
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
	btn_delete:"刪除",
	btn_close:"關閉",
	btn_clear:"清除",
	btn_save:"保存",
	btn_set:"設置",
	btn_cancel:"取消",
	
	text_loading:"正在加載中..." ,
	text_uploading:"正在上傳中...",
	text_connecting:"正在連接中..." ,
	text_saveing:"正在保存中...",
	text_select_data:"請選擇數據",
	text_delete_confirm:"確定要刪除嗎" ,
	text_clear_confirm:"確定要清除嗎" ,
	text_norecord:"沒有數據" ,
	text_user_count:"共%1個用戶",
	text_op_success:"操作成功",
	text_set_success:"設置成功",
	text_tip:"提示",
	text_about:"關於",
	text_register:"註冊信息",
	text_status_success:"成功",
	text_status_fail:"失敗",
	text_allow:"允許",
	text_disabled:"禁用",
	text_no_power:"沒有權限",
	
	pager_error_content:"輸入內容不正確",
	pager_info:"第 {PageIndex} 頁 / 共 {PageCount} 頁 ，每頁 {PageSize} 條 ",
	 
	
	vaild_special_char:"請勿輸入非法字符",
	valid_integer:"序號必須是正整數",
	valid_select_file:"請選擇上傳的文件",
	valid_select_pic:"請選擇圖片文件",
	valid_select_file_limit:"文件類型必須是[{FileType}]中的一種",

    field_loginname:"帳號",
    field_password:"密碼",
    field_username:"姓名",
    field_sex:"性別",
    field_deparment:"部門",
    field_job:"職位",
    field_mobile:"手機",
    field_phone:"電話",
	field_expiretime:"長期有效",

	dept:"部門",
	dept_create:"新增部門",
	dept_edit:"編輯部門",
	dept_delete:"刪除部門",
	dept_member:"部門成員",
	dept_move:"部門移動",
	dept_select:"選擇部門",
	dept_set:"設置部門",
	dept_select_text:"請選擇部門",
	dept_member_move:"移動到部門" ,
	dept_member_copy:"複製到部門",
	dept_set_member:"設置成員",
	dept_delete_confirm:"確定刪除部門",
	dept_root_delete_error:"根結點不能刪除",
	dept_move_error:"根結點不能移動",
	dept_move_target_root:"不能選擇根結點",
	dept_move_target_self:"不能自己移到自己",

	user:"用戶",
	user_create:"新增人員",
	user_edit:"編輯人員",
	user_delete:"刪除人員",
	user_set:"設置人員",
	user_delete_confirm:"確定刪除用戶",
	user_select_text:"請選擇用戶",
	user_attr:"批量修改屬性",
	user_exists:"人員【{user}】已經存在",
	user_select:"選擇的人數過多,請分級加載",
		
	role:"角色",
	role_create:"新增角色",
	role_edit:"編輯角色",
	role_copy:"克隆角色",
	role_delete:"刪除角色",
	role_set:"設置角色",
	role_delete_system:"admin帳號不允許此操作",
	role_delete_default:"默認角色不允許此操作",
	role_create_batch_doing:"正在批量創建角色，請稍等...",
	
	group_create:"新增群組",
	group_edit:"編輯群組",
	group_delete:"刪除群組",
	group_type_fixed:"固定群",
	group_type_temp:"個人群",
	group_name_require:"請輸入群名稱",
	group_order_require_integer:"排序號必須是正整數",
	group_diskspace_require_integer:"共享空間大小必須是正整數",
	group_warning:"群組成員必須2個人以上",
	 
	grant_create:"新增授權",
	grant_edit:"編輯授權",
	grant_delete:"刪除授權",
	
	import_user:"導入用戶",
	import_txt:"導入驗證文件",
	import_dept:"導入部門",
	import_ad:"導入域用戶",
	import_rtx:"導入rtx用戶",
	import_plugins:"導入插件",
	import_doing:"正在導入，請稍等...",
	import_success:"操作成功,請刷新頁面查看內容",
	
	export_user:"導出用戶",
	export_dept:"導出部門",
	export_doing:"正在導出，請稍等...",
	export_fail:"導出失敗",
	export_user_require:"請選擇導出的用戶",
	
	syncpush_org_success:"推送完成",
	syncpush_org_doing:"正在推送，請稍等...",



	emp_pinyin_seting:"正在批量設置拼音，請稍等...",
	emp_deptpath_seting:"正在批量設置部門長路徑，請稍等...",
	emp_order_seting:"正在批量設置人員排序，請稍等...",
	ace_set:"設置權限",
	
	hl_config_save:"保存配置信息",

    push_create:"新增推送",
    push_edit:"修改推送",

    reg_success:"註冊成功",

    link_view:"查看鏈接",

    pos_edit:"編輯銘牌",
    pos_create:"新增銘牌",
    pos_delete:"刪除銘牌",
	pos_icon_tip:"圖標尺寸為16px*16px",
	pos_name_require:"請輸入銘牌名稱",
	pos_icon_require:"請上傳銘牌圖標",

    client_edit:"編輯客戶端",
    client_create:"發布客戶端",
	client_name_require:"請輸入客戶端名稱",
	client_version_require:"請輸入客戶端版本",
	client_pack_require:"請上傳客戶端安裝包！",
	client_uploading:"正在上傳安裝包，請稍候...",
	
	doc_root_create:"新增根目錄",
	doc_root_edit:"新增根目錄",
	doc_dir_create:"新增目錄",
	doc_dir_edit:"修改目錄",
	doc_dir_require:"請選擇目錄",
	doc_dir_delete_confirm:"你確定要刪除{dir}嗎?",
	doc_dir_delete_fail:"文檔目錄刪除失敗，可能有子目錄",
	doc_dir_clean:"清理資料夾",
	doc_dir_warning1:"資料夾清理成功!",
	doc_dir_warning:"成員不能為空!",
	doc_public_file:"公共檔案",
	
	livechat_status_open:"打開",
	livechat_status_close:"關閉",
	livechat_history_view:"查看談話記錄",
	livechat_chater_create:"新增客服",
	livechat_chater_edit:"編輯客服",
	livechat_user_edit:"編輯訪客",
	livechat_code_bulid:"生成客服代碼",
	livechat_code_bulid_tip:"請將輸入框內的代碼粘貼到網頁中！",
	livechat_serverip:"請輸入服務器地址",
	livechat_warning:"在線客服至少要有1人",
	livechat_edit:"在線客服",
	livechat_edit_reception_require_integer:"最大接待量必須是正整數",
	
	livechat_blackip_create:"新增黑名單ip記錄",
	livechat_blackip_edit:"編輯黑名單ip記錄",
	livechat_blackip_youid_require:"請輸入會話ID",
	livechat_blackip_to_ip_require:"請輸入IP",
	livechat_blackip_create_ok:"新增黑名單ip記錄成功",
	livechat_blackip_to_type3:"單聊",
	livechat_blackip_to_type6:"群聊",
	
	livechat_chater_ro_create:"新增入口",
	livechat_chater_ro_edit:"編輯入口",
	livechat_chater_ro_name_require:"請輸入入口名稱",
	livechat_chater_ro_order_require_integer:"排序號必須是正整數",
	livechat_chater_ro_warning:"成員不能為空",
	
	livechat_user_ro_create:"新增訪客標籤",
	livechat_user_ro_edit:"編輯訪客標籤",
	livechat_user_ro_name_require:"請輸入標籤名稱",
	livechat_user_ro_order_require_integer:"排序號必須是正整數",
	
	livechat_chater_theme_create:"新增會話主題",
	livechat_chater_theme_edit:"編輯會話主題",
	livechat_chater_theme_name_require:"請輸入會話主題名稱",
	livechat_chater_theme_order_require_integer:"排序號必須是正整數",
	livechat_chater_theme_ro1:"使用主題",
	livechat_chater_theme_ro2:"歷史主題",
	
	livechat_chater_domain_create:"新增跳轉後的域名",
	livechat_chater_domain_edit:"編輯跳轉後的域名",
	livechat_chater_domain_name_require:"請輸入頁面跳轉後域名地址",
	livechat_chater_domain_order_require_integer:"排序號必須是正整數",
	livechat_chater_domain_delete_default:"正在使用的域名不允許此操作",
	livechat_chater_domain_ro2:"歷史主題",
	
	livechat_chater_wechat_create:"新增微信公眾號/小程式",
	livechat_chater_wechat_edit:"編輯微信公眾號/小程式",
	livechat_chater_domain_name_require:"請輸入網頁授權功能變數名稱",
	livechat_chater_wechat_delete_default:"正在使用的微信公眾號/小程式不允許此操作",
	
	link_create:"新增鏈接",
	link_edit:"修改鏈接",
	link_name_require:"請輸入鏈接名稱",
	link_url_require:"請輸入鏈接地址",
	
	question_create:"新增問題",
	question_edit:"修改問題",
	question_subject_require:"請輸入問題",
	question_usertext_require:"請輸入答案",
	question_ord_require:"請輸入排序號",
	
	quicktalk_create:"新增常用語",
	quicktalk_edit:"修改常用語",
	quicktalk_subject_require:"請輸入標題",
	quicktalk_usertext_require:"請輸入內容",
	quicktalk_ord_require:"請輸入排序號",
	
	file_create:"新增文件",
	file_edit:"修改文件",
	file_name_require:"請輸入文件名稱",
	file_path_require:"請輸入文件地址",
	
	service_port_set:"設置端口",
	service_select_tip:"請選擇要操作的服務",
	
	config_ios_title:"iOS推送配置",
	config_clear_confim:"你確定要刪除{days}天前的數據嗎！",
	config_clear_tip:"數據刪除後不能還原",
	config_clear_days_error:"請輸入正確的天數",
	config_clear_doing:"正在清除中",
	config_clear_success:"清除完成",
	
	skin_cancel_doing:"正在取消皮膚應用",
	skin_set_doing:"正在應用皮膚設置",
	
	status_online:"在線",
	status_offline:"離線",
	status_go_away:"離開",
	status_mobile_online:"手機在線",
	
	software_upgrade:"軟件升級",

	rtc_console:"數據目錄不正確",
	
	doc_clipboardData:"複製鏈接成功",
	doc_jsclipboardData:"複製代碼成功",
	
	text_delete_config:"是否刪除文件?",
	
	lv_chat_file:"[文件]",
	lv_chat_location : "[位置]",
	lv_chat_pic:"[圖片]",
	lv_chat_expression : "[表情]",
	lv_chat_video:"[視頻]",
	lv_chat_voice:"[語音消息]",
	lv_chat_link:"[鏈接]",
	lv_chat_card:"[名片]",
	lv_voice_call:"[語音電話]",
	lv_video_call:"[視頻電話]",
	
	lv_ChatGPT_warning:"ChatGPT apikey錯誤!",
	
	doc_set:"許可權設定",
	user_select_text:"請選擇用戶",
 	user_exists:"人員【{user}】已經存在",
	user_curr_userid:"人員【{user}】不能為自己",
	text_loading:"正在加載中…" ,
	btn_delete:"删除",
	onlinefile_text:"線上檔案不能為空",

    end:""
};


var serviceState = {

    running:"運行中",
    stop:"已停止",
    pause:"已暫停",
    error:"未知狀態",
    unknown:"打開服務出錯"

};


var pushDataType = {
	org:"組織",
    user:"人員",
    dept:"部門",
    group:"群組",
    msg:"消息"

};

