<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","GRANT") ;
$issuper = 0 ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/user.js"></script>
	<script type="text/javascript" src="../assets/js/grant.js?ver=20141118"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>

				<div class="page-header"><h1><?=get_lang("grant_title")?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <button type="button" class="btn btn-default" action-type="grant_edit"><?=get_lang("btn_addgrant")?></button>
                    
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table  id="datalist" class="table table-striped table-hover data-list"  data-tmpid="tmpl_list"  data-table="AdminGrant" data-fldid="id" data-fldsort="id" data-fldsortdesc="id desc" data-where=""  data-fldlist="*">
                    <thead>
                        <tr>
                            <td><?=get_lang("field_id")?></td>
                            <td><?=get_lang("field_username")?></td>
                            <td><?=get_lang("field_grant")?></td>
                            <td><?=get_lang("field_usercount")?></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="list"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr class="row-${id}" data-name="${fcname}">
                        <td>${id}</td>
                        <td>${fcname}</td>
                        <td>${deptname}</td>
                        <td>${countuser}</td>
                        <td>
                            <a href="javascript:void(0);" action-data="${id}" action-type="grant_edit" ><?=get_lang("btn_change")?></a>
                            <a href="javascript:void(0);" action-data="${id}" action-type="grant_delete" ><?=get_lang("btn_delete")?></a>
                        </td>
                    </tr>
                </script>
				<!--End List--->
				
				<?php  require_once("../include/footer.php");?>
    

</body>
</html>

<script language="javascript" >

var dataList ;

$(document).ready(function(){

	 grant_list_init();

})

</script>