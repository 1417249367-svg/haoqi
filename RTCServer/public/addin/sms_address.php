				<script type="text/javascript" src="assets/js/sms_address.js?v=1"></script>
                <style>
					.form_address_switch{margin-bottom:5px;}
					.form-address{background:#eee;padding:10px;}
					.form-address .form-group{padding:5px;margin:0px;}
					.form-address .control-label{width:50px;}
					.form-address .control-value{margin-left:50px;}
					.form-address .form-control{margin:0px;padding:4px;height:25px;}
					.form-address .btn{margin:0px;}
					.table tr .a-delete{display:none; background:url(/static/img/delete.gif) center center no-repeat;padding:5px;margin-top:4px;}
					.table tr:hover .a-delete{display:block;}
				</style>
                <div id="form_address_switch">
                    <div class="fr"><a href="###" onclick="address_add_show()">添加联系人</a></div>
                    <div class="clear"></div>
                </div>

                <div class="form-address" id="form_address" style="display:none;">
                    <div class="form-group"> 
                        <label class="control-label" for="col_name">姓名</label> 
                        <div class="control-value">
                            <input type="text" placeholder="姓名" class="form-control"  id="address_name" maxlength="20" />
                        </div> 
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="col_mobile">手机</label> 
                        <div class="control-value">
                            <input type="text" placeholder="手机" class="form-control"  id="address_mobile"   maxlength="20" /> 
                        </div> 
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="col_mobile"></label> 
                        <div class="control-value">
                            <button type="button" class="btn btn-primary" id="btn_add" onclick="address_add()" >添加联系人</button>
                           <a href="###" onclick="address_add_hide()">关闭</a>
                        </div> 
                    </div>
                    <div class="clear"></div>
                </div>
				<!--List--->
				<table  id="datalist" class="table table-hover data-list" data-ispage="0"  data-tmpid="tmpl_list"  data-table="rtc_sms_address" data-fldid="col_id" data-fldsort="col_id desc" data-fldsortdesc="col_id asc" data-where=""  data-fldlist="*">
				  <tbody>
				  </tbody>
				</table>

				<script type="text/x-jquery-tmpl" id="tmpl_list">
					<tr class="row-${col_id}" id="user_${col_id}">
						<td>
							<div class="fl"><a href="###" onclick="address_select('${col_name}','${col_mobile}')">${col_name}(${col_mobile})</a></div>
							<div class="fr"><a href="###" onclick="address_delete('${col_id}')" class="a-delete"></a></div>
							<div class="clear"></div>
						</td>
					</tr>
				</script>
				<!--End List--->
                
