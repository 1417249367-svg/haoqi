<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","TAG") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/tag.js"></script>
<style>
.tag_list dd {
	padding: 5px;
	clear: both;
}

.tag-item {
	float: left;
	margin: 0px;
	padding: 0px 10px 0px 2px;
	list-style-type: none;
	background: #dee7f8;
	border: 1px solid #cad8f3;
	border-radius: 4px;
	margin-right: 5px;
	width: 150px;
	margin-bottom: 5px;
}

.tag-item h4 {
	float: left;
	padding: 2px;
	line-height: 25px;
	margin: 0px;
	font-size: 12px;
}

.tag-item i {
	float: right;
	width: 15px;
	height: 20px;
	background: url(/static/img/delete.gif) center center no-repeat;
}

.btn-group .btn {
	margin: 5px 0px;
}
</style>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1>标签管理</h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                     <div class="pull-left">
                          <button type="button" class="btn btn-default" action-type="type_edit">新增分类</button>
                     </div>
				</div>
				<!--End SearchBar-->
				
				

				<!--List--->
				
				<div class="tag_list" id="tag_container">

				</div>
				
                <script type="text/x-jquery-tmpl" id="tmpl_type">
                    <dl id="type_${col_id}"  data-id="${col_id}" class="type-item">
                        <dt>
                            <div class="fl"><a href="#" action-data="${col_id}"  action-type="type_edit">${col_name}</a></div>
                            <span class="fr">
                                <a href="#" action-data="${col_id}"  action-type="type_edit">编辑</a>
                                <a href="#" action-data="${col_id}"  action-type="type_delete">删除</a>
                            </span>
                            <div class="clear"></div>
                        </dt>
                        <dd>
                           <div class="tags"></div> 
                        </dd>
                        <dd>
                            <input type="text"  class="form-control input-sm fl tag-name" style="width:150px;margin-right:5px;" placeholder="添加标签">
                            <button class="btn btn-default btn-sm fl" onclick="tag_add_post(${col_id})">+</button>
                            <div class="clear"></div>
                        </dd>
                    </dl>
                </script>
                
                <script type="text/x-jquery-tmpl" id="tmpl_tag">
                    <div id="tag_${col_id}" class="tag-item">
                        <h4><a href="#" action-data="${col_id},${col_type_id}"  action-type="tag_edit" class="tag_name_${col_id}">${col_name}</a></h4>
						<div class="btn-group pull-right">
						  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" role="menu">
							<li><a href="javascript:void(0);" action-data="'${col_name}'" action-type="tag_user">查看人员</a></li>
							<li><a href="javascript:void(0);" action-data="'${col_name}'" action-type="tag_group" >查看群组</a></li>
							<li><a href="javascript:void(0);" action-data="${col_id},${col_type_id}"   action-type="tag_edit" >修改标签</a></li>
							<li><a href="javascript:void(0);" action-data="${col_id}"   action-type="tag_delete" >删除标签</a></li>
						  </ul>
						</div>

                    </div>
                </script>
                

				<!--End List--->				
				<?php  require_once("../include/footer.php");?>
    

</body>
</html>


<script type="text/javascript">
    $(document).ready(function(){
        load_all();
    })
</script>

