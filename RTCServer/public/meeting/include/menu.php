<ul style="list-style: none">
	<li><a href="create_meeting.html?<?=str_replace( "&groupid=".g("groupid"), "" ,$_SERVER['QUERY_STRING']) ?>"
		<?=MENU == "CREATE"?"class='selected'":""?>><i
			class="glyphicon glyphicon-plus">&nbsp;</i>创建会议</a></li>
	<li><a href="manage_meeting.html?<?=str_replace( "&groupid=".g("groupid"), "",$_SERVER['QUERY_STRING']) ?>"
		<?=MENU == "MANAGE"?"class='selected'":""?>><i
			class="glyphicon glyphicon-list">&nbsp;</i>会场管理</a></li>
</ul>