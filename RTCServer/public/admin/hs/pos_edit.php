<?php  require_once("../include/fun.php");?>
<?php 
$db = new DB ();
$ord = $db->getMaxId("hs_pos_info", "col_pos_idx");
$ord++;
?>
           <form id="form-pos" method="post"  class="form-horizontal"   data-obj="pos"  data-table="hs_pos_info" data-fldid="col_pos_idx" data-fldname="col_pos_name" enctype="multipart/form-data">
              <div class="modal-body">
              			<div class="form-group form-group-left">
                            <label class="control-label" for="updatefile">图标</label>
							<div class="control-value"><input type="file"  class="form-control"  id="updatefile" name="updatefile" class="file-picture pic" style="height: 40px; " onchange="uploadFile(this)"  accept=".png,.jpg,.jpeg,.gif" /> </div>
                        </div>
                        <div class="form-group form-group-right">
                            <label class="control-label">预览</label>
							<div class="control-value"><img id="pos_img" name="pos_img" width="16" height="16" /></div>
                        </div>
             	 		<div class="form-group">
                            <label class="control-label" for="col_pos_idx">序号</label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field  data-keyfield digits" required id="col_pos_idx"  name="col_pos_idx" value="<?=$ord?>" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="col_pos_name">名称</label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field  specialCharValidate" required id="col_pos_name"  name="col_pos_name"   /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="col_pos_disp">描述</label>
                            <div class="control-value"><textarea rows="10" style="height:200px"  placeholder="" class="form-control data-field  specialCharValidate"  id="col_pos_disp" name="col_pos_disp" ></textarea> </div>
                        </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="btn_save">保存</button>
                <input type="hidden" id="filefactpath" name="filefactpath" />
                <input type="hidden" id="filesaveas" name="filesaveas" />
                <input type="hidden" id="col_pos_imgpath" name="col_pos_imgpath" class="data-field"/>
              </div>
            </form>

<script type="text/javascript">

var dataForm ;
var posidx = "<?=g("posidx") ?>" ;
var serverAddr = "<?=$_SERVER["SERVER_ADDR"] ?>";
var rtcPort = "<?=RTC_PORT?>";

$(document).ready(function(){
	$("#btn_save").click(function(){
        saveForm();
        return false ;
    })
   pos_detail_init();
})
</script>