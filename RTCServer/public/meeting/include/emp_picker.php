        <div  class="mypanel box-select" class="fluent">
            <div class="mypanel-title">
                <input type="text" id="userkey" class="form-control input-search" placeholder="查找用户">
            </div>
			<div id="tabs_viewport" class="flat-tabs">
				<ul>
					<li for="container_org"><a href="###">组织结构</a></li>
					<li for="container_my"><a href="###">联系人</a></li>
					<li for="container_group"><a href="###">群组</a></li>
				</ul>
				<div class="clear"></div>
			</div>
            <div class="mypanel-body">
		        <div id="container_org" class="fluent">
		            <div id="container_org_tree" class="tree fluent"></div>
		        </div>
		        <div id="container_my" class="fluent">
		            <div id="container_my_tree" class="tree fluent"></div>
		        </div>
		        <div id="container_group" class="fluent">
		            <div id="container_group_tree" class="tree fluent"></div>
		        </div>
            </div>
        </div>

<script type="text/javascript">
var viewtype_group = "<?=VIEWTYPE_GROUP?>" ;
var viewtype_owner = "<?=VIEWTYPE_OWNER?>" ;
var owner_id = "<?=CurUser::getUserId()?>" ;
</script>
<script type="text/javascript" src="assets/js/emp_picker.js"></script>