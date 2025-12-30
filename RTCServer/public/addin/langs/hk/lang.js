var errors = {
	err_0:"未知錯誤",
	err_10000:"資料庫連接錯誤",
	err_10009:"{name}不能為空",
	err_10008:"{name}已經存在",
	
	err_101001:"沒有許可權",
	err_102001:"帳號不存在",
	err_102002:"密碼錯誤",
	err_102003:"帳號被禁用",
	err_102004:"帳號不是管理員",
	err_102005:"驗證碼錯誤",
	err_102006:"錯誤次數超過，您已被限制登入",
	err_102007:"用戶帳號只允許在指定mac或ip電腦登入，請與管理員聯系！",
	
	err_102101:"用戶不存在",
	err_102102:"用戶已經存在",
	err_102103:"用戶不能删除",
	
	err_102201:"部門不存在",
	err_102202:"部門已經存在",
	err_102203:"部門删除失敗，可能有子部門",
	err_102204:"部門成員已經存在",
	err_102205:"不能移動部門到根節點下",
	err_102206:"不能移動部門到自己或子孫節點下",
	err_102211:"系統節點不能添加人員",
	err_102212:"不能將人員設定到根節點下",
	err_102213:"系統節點不能修改或删除",
	err_102301:"角色已經存在",
	err_102302:"角色不能為空",
	err_102401:"視圖已經存在",
	err_102501:"授權已經存在",
	err_102601:"請選擇要設定的對象",
	err_102701:"此部門已經授權過",

    err_999999:""
};

var langs ={

    text_loading:"正在加載中..." ,
    text_norecord:"沒有數據" ,

	pager_error_content:"輸入內容不正確",
	pager_info:"第 {PageIndex} 頁 / 共 {PageCount} 頁 ，每頁 {PageSize} 條 ",
	
	userpicker_exist:"人員【{User}】已經存在",
	
	sms_require_mobile:"用戶沒有登記手機號碼，不能選擇",
	sms_require_recver:"請選擇接收的人員",
	sms_require_content:"請輸入短信的內容",
	sms_require_sendtime:"請輸入定時發送的時間",
	sms_recver_count_over:"一次人員不得超過{Count}人",
	sms_content_over:"短信內容最長{Max}個字",
	sms_content_length:"短信內容最長{Max}個字，還剩{Last}個字",
	sms_content_specialchar:"短信內中不能包含以下字符",
	sms_send_success:"短信發送成功",
	sms_send_fail:"短信發送失敗：{Error}",
	
	board_create:"新增",
	board_edit:"修改",
	
	user:"用戶",
	user_create:"新增人員",
	user_edit:"編輯人員",
	user_delete:"刪除人員",
	user_set:"設置人員",
	user_delete_confirm:"確定刪除用戶",
	user_select_text:"請選擇用戶",
	user_attr:"批量修改屬性",
	user_exists:"人員【{user}】已經存在",
	user_curr_userid:"人員【{user}】不能為自己",
	
	user_phpform_name_text:"共享名稱不能為空",
	user_phpform_text:"共享成員不能為空",
	
	board_list_code_bulid_tip:"複製鏈接成功,請粘貼到瀏覽器下載",
	
	pic:"[圖片]",
	video:"[視頻]",
	
	doc_clipboard:"複製",
	doc_clipboardData:"請複制url粘貼到IE瀏覽器打開!",
	
	end:""
}