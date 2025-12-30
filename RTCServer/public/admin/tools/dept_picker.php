<?php  require_once("../include/fun.php");?>
              <div class="modal-body">
                    <div id="container_treepicker" class="container-tree" style="height:300px;"></div>
              </div>
              <div class="modal-footer clearfix">

			  		<div class="pull-left" id="options" style="display:none">
						<label><input type="checkbox" id="chk_reset" /> 删除以前的部门</label>
					</div>

			  		<div class="pull-right">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="submit" class="btn btn-primary" id="btn_picker_submit">确定</button>
					</div>
              </div>

<script type="text/javascript">
$(document).ready(function(){

    var action_type = "<?=g("action_type")?>";
    
    tree_picker=new dhtmlXTreeObject("container_treepicker","100%","100%",0);
    tree_picker.setImagePath(TREE_IMAGE_PATH);
    var url = getAjaxUrl("org","get_tree","") ;
    
    tree_picker.setXMLAutoLoading(url);
    tree_picker.loadXML(url ,function(){ });

	if (action_type == "user_dept_post")
		$("#options").show();

    $("#btn_picker_submit").click(function(){
        var picker_id = tree_picker.getSelectedItemId() ;
		var flag = $("#chk_reset").is(':checked')?1:0 ;
        if (picker_id == "")
        {
        	myAlert(langs.dept_select_text);
            return false ;
        }
        if (picker_id =="0_0_0")
        {
          	
            if(action_type=="dept_move_post")
            	myAlert(getErrorText("102205"));
            else if(action_type=="user_dept_post")
            	myAlert(getErrorText("102212"));
            else
            	myAlert(getErrorText("102204"));
            return ;
        }

		if(action_type == "dept_move_post")
		{
			var move_nodeId = "<?=g("deptid")?>";
			
	        var desPath = getTreePath(tree_picker,picker_id);
	        var movePath = getTreePath(tree_picker,move_nodeId);

	        if(desPath.indexOf(movePath)>=0)
	        {
	        	myAlert(getErrorText("102206"));
	        	return false ;
	        }
		}
        var str = action_type +"('" + picker_id + "','" + tree_picker.getSelectedItemText() + "'," + flag + ")" ;
        eval(str);

		setLoadingBtn(this) ;
    })
})

</script>

