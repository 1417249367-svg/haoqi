<?php
	$admin = CurUser::isAdmin() ;
?>
    <ul>
		 <?php if ($admin) {?>
        <li>
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?=get_lang('menu_sup_org')?></a>
            <ul class="submenu">
               <li <?=MENU == "ORG"?"class='active'":""?> ><a href="../hs/org_list.html" 	class="menu-org"><?=get_lang('menu_sub_org')?></a></li>
               <li <?=MENU == "USER"?"class='active'":""?>><a href="../hs/user_list.html" 	class="menu-user"><?=get_lang('menu_sub_user')?></a></li>
               <li <?=MENU == "ROLE"?"class='active'":""?>><a href="../hs/role_list.html" 	class="menu-role"><?=get_lang('menu_sub_role')?></a></li>
               <li <?=MENU == "GRANT"?"class='active'":""?>><a href="../hs/grant_list.html" class="menu-grant"><?=get_lang('menu_sub_grant')?></a></li>
               <li <?=MENU == "GROUP"?"class='active'":""?>><a href="../hs/group_list.html" class="menu-group"><?=get_lang('menu_sub_group')?></a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?=get_lang('menu_sup_set')?></a>
            <ul class="submenu">
               <li <?=MENU == "SET"?"class='active'":""?>><a href="../set/set.html"  class="menu-set"><?=get_lang('menu_sub_set')?></a></li>
               <li <?=MENU == "WEBSERVER_SET"?"class='active'":""?>><a href="/admin/set/webserver_set.html"  class="menu-set"><?=get_lang('menu_sub_webserver')?></a></li>
               <li <?=MENU == "FILTER"?"class='active'":""?>><a href="/admin/tools/keywords_list.html"	class="menu-ext"><?=get_lang('menu_sub_filter')?></a></li>
               <?php if (! OEM) {?>
			   <li <?=MENU == "SET_CLIENT"?"class='active'":""?>><a href="../set/set_client.html"	class="menu-skin"><?=get_lang('set_legend_client')?></a></li>
               <?php }?>
			   <li <?=MENU == "APPLICATION"?"class='active'":""?>><a href="../set/application.html" 	class="menu-update"><?=get_lang('index_application')?></a></li>
			   <li <?=MENU == "ADDIN"?"class='active'":""?>><a href="../tools/addin_list.html"	class="menu-addin"><?=get_lang('menu_sub_addin')?></a></li>

            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?=get_lang('menu_sup_doc')?></a>
            <ul class="submenu">
               <li <?=MENU == "DOC_TREE"?"class='active'":""?>><a href="/admin/doc/doc_tree.html"	class="menu-doc-folder"><?=get_lang('menu_sub_store')?></a></li>
               <li <?=MENU == "DOC_LOG"?"class='active'":""?>><a href="/admin/doc/doc_log.html"		class="menu-doc-log"><?=get_lang('menu_sub_doclog')?></a></li>
            </ul>
        </li>
		<?php if (VERIFYUSERDEVICE){?>
        <li>
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?=get_lang('menu_sup_report')?></a>
            <ul class="submenu">
                <li <?=MENU == "MSG"?"class='active'":""?>><a href="/admin/report/msg_list.html" 		class="menu-msg"><?=get_lang('menu_sub_msg')?></a></li>
				<li <?=MENU == "CHATLIST"?"class='active'":""?>><a href="/admin/report/chat_list.html" 	class="menu-chat"><?=get_lang('menu_sub_chatlist')?></a></li>
                <li <?=MENU == "GROUPMSG"?"class='active'":""?>><a href="/admin/report/groupmsg_list.html" 		class="menu-groupmsg"><?=get_lang('menu_sub_groupmsg')?></a></li>
				<li <?=MENU == "GROUPCHATLIST"?"class='active'":""?>><a href="/admin/report/groupchat_list.html" 	class="menu-groupchatlist"><?=get_lang('menu_sub_groupchatlist')?></a></li>
				<li <?=MENU == "LIVECHATMSG"?"class='active'":""?>><a href="/admin/report/livechatmsg_list.html" class="menu-livechatmsg"><?=get_lang('menu_sub_livechatmsg')?></a></li>
				<li <?=MENU == "LIVECHATLIST"?"class='active'":""?>><a href="/admin/report/livechat_list.html" 	class="menu-livechat"><?=get_lang('menu_sub_livechatlist')?></a></li>
                <li <?=MENU == "BOARD"?"class='active'":""?>><a href="/admin/report/board_list.html" class="menu-board"><?=get_lang('menu_sub_board')?></a></li>
                <li <?=MENU == "SMS"?"class='active'":""?>><a href="/admin/report/sms_list.html" class="menu-sms"><?=get_lang('menu_sub_sms')?></a></li>
            	<li <?=MENU == "PUBLICFILE"?"class='active'":""?>><a href="/admin/report/public_file_list.html" class="menu-public-file"><?=get_lang('menu_sub_public_file')?></a></li>
            	<li <?=MENU == "PERSONFILE"?"class='active'":""?>><a href="/admin/report/person_file_list.html" class="menu-person-file"><?=get_lang('menu_sub_person_file')?></a></li>
            	<li <?=MENU == "GROUPFILE"?"class='active'":""?>><a href="/admin/report/group_file_list.html" class="menu-group-file"><?=get_lang('menu_sub_group_file')?></a></li>
            	<li <?=MENU == "LEAVEFILE"?"class='active'":""?>><a href="/admin/report/leave_file_list.html" class="menu-leave-file"><?=get_lang('menu_sub_leave_file')?></a></li>
				<li <?=MENU == "ONLINE"?"class='active'":""?>><a href="/admin/report/online_list.html" class="menu-online"><?=get_lang('menu_sub_online')?></a></li>
                <li <?=MENU == "LOG"?"class='active'":""?>><a href="/admin/report/log_list.html" class="menu-log"><?=get_lang('menu_sub_log')?></a></li>
            </ul>
        </li>
		<?php }?>
		<?php if (LIVECHAT){?>
        <li>
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?=get_lang('menu_sup_duty')?></a>
            <ul class="submenu">
                <li <?=MENU == "LIVECHAT_SET"?"class='active'":""?>><a href="/admin/lv_manager/livechat_config.html?flag=1" class="menu-lv-config"><?=get_lang('menu_sub_config_lv')?></a></li>
                <li <?=MENU == "LIVECHAT_CHATER"?"class='active'":""?>><a href="/admin/lv_manager/chater_list.html"	class="menu-lv-chater"><?=get_lang('menu_sub_operator')?></a></li>
                <li <?=MENU == "LIVECHAT_CHATER_RO"?"class='active'":""?>><a href="/admin/lv_manager/chater_ro_list.html" class="menu-lv-chater-ro"><?=get_lang('menu_sub_entrance')?></a></li>
                <li <?=MENU == "LIVECHAT_CHAT_RO"?"class='active'":""?>><a href="/admin/lv_manager/chat_ro_list.html?flag=1" class="menu-lv-chat-ro"><?=get_lang('menu_sub_dialog_analysis')?></a></li>
                <li <?=MENU == "LIVECHAT_CHAT"?"class='active'":""?>><a href="/admin/lv_manager/chat_list.html?flag=1" class="menu-lv-chat"><?=get_lang('menu_sub_dialog')?></a></li>
                <li <?=MENU == "LIVECHAT_MESSAGE"?"class='active'":""?>><a href="/admin/lv_manager/message_list.html?flag=1" class="menu-lv-message"><?=get_lang('menu_sub_livemsg')?></a></li>
                <li <?=MENU == "LIVECHAT_RATE"?"class='active'":""?>><a href="/admin/lv_manager/rate_list.html?flag=1"	class="menu-lv-rate"><?=get_lang('menu_sub_rate')?></a></li>
                <li <?=MENU == "LIVECHAT_TRANSFER"?"class='active'":""?>><a href="/admin/lv_manager/transfer_list.html?flag=1"	class="menu-lv-transfer"><?=get_lang('menu_sub_transfer')?></a></li>
                <li <?=MENU == "LIVECHAT_BLACKIP"?"class='active'":""?>><a href="/admin/lv_manager/blackip_list.html?flag=1"	class="menu-lv-blackip"><?=get_lang('menu_sub_blackip')?></a></li>
				<li <?=MENU == "LIVECHAT_ATTACH"?"class='active'":""?>><a href="/admin/lv_manager/file_list.html?flag=1"	class="menu-lv-attach"><?=get_lang('menu_sub_attach')?></a></li>
                <li <?=MENU == "LIVECHAT_QUESTION"?"class='active'":""?>><a href="/admin/lv_manager/question_list.html?flag=1" class="menu-lv-question"><?=get_lang('menu_sub_question')?></a></li>
                <li <?=MENU == "LIVECHAT_DOMAIN"?"class='active'":""?>><a href="/admin/lv_manager/chater_domain_list.html?flag=1" class="menu-lv-domain"><?=get_lang('menu_sub_domain')?></a></li>
                <li <?=MENU == "LIVECHAT_WECHAT"?"class='active'":""?>><a href="/admin/lv_manager/chater_wechat_list.html?flag=1" class="menu-lv-wechat"><?=get_lang('menu_sub_wechat')?></a></li>
                <li <?=MENU == "LIVECHAT_CHATER_THEME"?"class='active'":""?>><a href="/admin/lv_manager/chater_theme_list.html?flag=1"	class="menu-lv-chater_theme"><?=get_lang('menu_sub_dialog_theme')?></a></li>
                <li <?=MENU == "LIVECHAT_USER_RO"?"class='active'":""?>><a href="/admin/lv_manager/user_ro_list.html?flag=1"	class="menu-lv-user-ro"><?=get_lang('menu_sub_visitor_label')?></a></li>
                <li <?=MENU == "LIVECHAT_USER"?"class='active'":""?>><a href="/admin/lv_manager/user_list.html?flag=1"	class="menu-lv-user"><?=get_lang('menu_sub_visitor')?></a></li>
                <li <?=MENU == "LIVECHAT_LINK"?"class='active'":""?>><a href="/admin/lv_manager/link_list.html?flag=1" class="menu-lv-link"><?=get_lang('menu_sub_link')?></a></li>
            </ul>
        </li>
		<?php }?>
		<?php }else{ ?>
        <li>
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?=get_lang('menu_sup_org')?></a>
            <ul class="submenu">
               <li <?=MENU == "ORG"?"class='active'":""?>><a href="../hs/org_list.html" 		class="menu-org"><?=get_lang('menu_sub_org')?></a></li>
			   <li <?=MENU == "ROLE"?"class='active'":""?>><a href="../hs/role_list.html"  		class="menu-role"><?=get_lang('menu_sub_role')?></a></li>
               <li <?=MENU == "GRANT"?"class='active'":""?>><a href="../hs/grant_list.html"  	class="menu-grant"><?=get_lang('menu_sub_permission')?></a></li>
            </ul>
        </li>
		<?php } ?>
  </ul>
