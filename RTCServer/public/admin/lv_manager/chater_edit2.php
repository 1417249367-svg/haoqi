<?php  require_once("../include/fun.php");?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/livechat.js"></script>
</head>
<body>

           <form id="form" method="post" class="form-horizontal" data-obj="livechat_kf" data-table="lv_chater" data-fldid="id" data-fldname="loginname" data-label="lv_chater" enctype="multipart/form-data" >
              <div class="modal-body" style="padding-top:0px;">
                    <div class="form-group form-group-left">
                        <label class="control-label" for="defaultreception"><?=get_lang('chater_list_chatgpt_reception')?></label>
                        <div class="control-value">
                            <select name="defaultreception" id="defaultreception" class="form-control data-field form-control"  >
                                <option value="0"><?=get_lang('chater_list_chatgpt_reception3')?></option>
                                <option value="1"><?=get_lang('chater_list_chatgpt_reception1')?></option>
                                <option value="2"><?=get_lang('chater_list_chatgpt_reception2')?></option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
<!--                    <div class="form-group form-group-left">
                        <label class="control-label" for="freetime"><?=get_lang('chater_edit_end_conversation')?></label>
                        <div class="control-value">
                            <select name="freetime" id="freetime" class="form-control data-field form-control"  >
                                <option value="0"><?=get_lang('chater_edit_end_conversation0')?></option>
                                <option value="1"><?=get_lang('chater_edit_end_conversation1')?></option>
                                <option value="2"><?=get_lang('chater_edit_end_conversation2')?></option>
                            </select>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label class="control-label" for="endsession"><?=get_lang('chater_edit_lb_endsession')?></label>
                        <div class="control-value">
                            <label class="checkbox-inline"><input class="data-field" type="checkbox" id="endsession" name="endsession" value="1" value-unchecked="0"/> <?=get_lang("chater_edit_lb_endsession_alert")?></label>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="form-group form-group-left">
                        <label class="control-label" for="defaulttargetlanguage"><?=get_lang('chater_edit_defaulttargetlanguage')?></label>
                        <div class="control-value">
                            <select name="defaulttargetlanguage" id="defaulttargetlanguage" class="form-control data-field form-control"  >
                                <option value="zh"><?=get_lang('chater_edit_language_zh')?></option>
                                <option value="en"><?=get_lang('chater_edit_language_en')?></option>
                                <option value="yue"><?=get_lang('chater_edit_language_yue')?></option>
                                <option value="wyw"><?=get_lang('chater_edit_language_wyw')?></option>
                                <option value="jp"><?=get_lang('chater_edit_language_jp')?></option>
                                <option value="kor"><?=get_lang('chater_edit_language_kor')?></option>
                                <option value="fra"><?=get_lang('chater_edit_language_fra')?></option>
                                <option value="spa"><?=get_lang('chater_edit_language_spa')?></option>
                                <option value="th"><?=get_lang('chater_edit_language_th')?></option>
                                <option value="ara"><?=get_lang('chater_edit_language_ara')?></option>
                                <option value="ru"><?=get_lang('chater_edit_language_ru')?></option>
                                <option value="pt"><?=get_lang('chater_edit_language_pt')?></option>
                                <option value="de"><?=get_lang('chater_edit_language_de')?></option>
                                <option value="it"><?=get_lang('chater_edit_language_it')?></option>
                                <option value="el"><?=get_lang('chater_edit_language_el')?></option>
                                <option value="nl"><?=get_lang('chater_edit_language_nl')?></option>
                                <option value="pl"><?=get_lang('chater_edit_language_pl')?></option>
                                <option value="bul"><?=get_lang('chater_edit_language_bul')?></option>
                                <option value="est"><?=get_lang('chater_edit_language_est')?></option>
                                <option value="dan"><?=get_lang('chater_edit_language_dan')?></option>
                                <option value="fin"><?=get_lang('chater_edit_language_fin')?></option>
                                <option value="cs"><?=get_lang('chater_edit_language_cs')?></option>
                                <option value="rom"><?=get_lang('chater_edit_language_rom')?></option>
                                <option value="slo"><?=get_lang('chater_edit_language_slo')?></option>
                                <option value="swe"><?=get_lang('chater_edit_language_swe')?></option>
                                <option value="hu"><?=get_lang('chater_edit_language_hu')?></option>
                                <option value="cht"><?=get_lang('chater_edit_language_cht')?></option>
                                <option value="vie"><?=get_lang('chater_edit_language_vie')?></option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="form-group form-group-left">
                        <label class="control-label" for="userautotranslate"><input type="checkbox" class="fl data-field" id="userautotranslate" name="userautotranslate" value="1"><?=get_lang('chater_edit_usertargetlanguage')?></label>
                        <div class="control-value">
                            <select name="usertargetlanguage" id="usertargetlanguage" class="form-control data-field form-control"  >
                                <option value="zh"><?=get_lang('chater_edit_language_zh')?></option>
                                <option value="en"><?=get_lang('chater_edit_language_en')?></option>
                                <option value="yue"><?=get_lang('chater_edit_language_yue')?></option>
                                <option value="wyw"><?=get_lang('chater_edit_language_wyw')?></option>
                                <option value="jp"><?=get_lang('chater_edit_language_jp')?></option>
                                <option value="kor"><?=get_lang('chater_edit_language_kor')?></option>
                                <option value="fra"><?=get_lang('chater_edit_language_fra')?></option>
                                <option value="spa"><?=get_lang('chater_edit_language_spa')?></option>
                                <option value="th"><?=get_lang('chater_edit_language_th')?></option>
                                <option value="ara"><?=get_lang('chater_edit_language_ara')?></option>
                                <option value="ru"><?=get_lang('chater_edit_language_ru')?></option>
                                <option value="pt"><?=get_lang('chater_edit_language_pt')?></option>
                                <option value="de"><?=get_lang('chater_edit_language_de')?></option>
                                <option value="it"><?=get_lang('chater_edit_language_it')?></option>
                                <option value="el"><?=get_lang('chater_edit_language_el')?></option>
                                <option value="nl"><?=get_lang('chater_edit_language_nl')?></option>
                                <option value="pl"><?=get_lang('chater_edit_language_pl')?></option>
                                <option value="bul"><?=get_lang('chater_edit_language_bul')?></option>
                                <option value="est"><?=get_lang('chater_edit_language_est')?></option>
                                <option value="dan"><?=get_lang('chater_edit_language_dan')?></option>
                                <option value="fin"><?=get_lang('chater_edit_language_fin')?></option>
                                <option value="cs"><?=get_lang('chater_edit_language_cs')?></option>
                                <option value="rom"><?=get_lang('chater_edit_language_rom')?></option>
                                <option value="slo"><?=get_lang('chater_edit_language_slo')?></option>
                                <option value="swe"><?=get_lang('chater_edit_language_swe')?></option>
                                <option value="hu"><?=get_lang('chater_edit_language_hu')?></option>
                                <option value="cht"><?=get_lang('chater_edit_language_cht')?></option>
                                <option value="vie"><?=get_lang('chater_edit_language_vie')?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-right">
                        <label class="control-label" for="chaterautotranslate"><input type="checkbox" class="fl data-field" id="chaterautotranslate" name="chaterautotranslate" value="1"><?=get_lang('chater_edit_chatertargetlanguage')?></label>
                        <div class="control-value">
                            <select name="chatertargetlanguage" id="chatertargetlanguage" class="form-control data-field form-control"  >
                                <option value="zh"><?=get_lang('chater_edit_language_zh')?></option>
                                <option value="en"><?=get_lang('chater_edit_language_en')?></option>
                                <option value="yue"><?=get_lang('chater_edit_language_yue')?></option>
                                <option value="wyw"><?=get_lang('chater_edit_language_wyw')?></option>
                                <option value="jp"><?=get_lang('chater_edit_language_jp')?></option>
                                <option value="kor"><?=get_lang('chater_edit_language_kor')?></option>
                                <option value="fra"><?=get_lang('chater_edit_language_fra')?></option>
                                <option value="spa"><?=get_lang('chater_edit_language_spa')?></option>
                                <option value="th"><?=get_lang('chater_edit_language_th')?></option>
                                <option value="ara"><?=get_lang('chater_edit_language_ara')?></option>
                                <option value="ru"><?=get_lang('chater_edit_language_ru')?></option>
                                <option value="pt"><?=get_lang('chater_edit_language_pt')?></option>
                                <option value="de"><?=get_lang('chater_edit_language_de')?></option>
                                <option value="it"><?=get_lang('chater_edit_language_it')?></option>
                                <option value="el"><?=get_lang('chater_edit_language_el')?></option>
                                <option value="nl"><?=get_lang('chater_edit_language_nl')?></option>
                                <option value="pl"><?=get_lang('chater_edit_language_pl')?></option>
                                <option value="bul"><?=get_lang('chater_edit_language_bul')?></option>
                                <option value="est"><?=get_lang('chater_edit_language_est')?></option>
                                <option value="dan"><?=get_lang('chater_edit_language_dan')?></option>
                                <option value="fin"><?=get_lang('chater_edit_language_fin')?></option>
                                <option value="cs"><?=get_lang('chater_edit_language_cs')?></option>
                                <option value="rom"><?=get_lang('chater_edit_language_rom')?></option>
                                <option value="slo"><?=get_lang('chater_edit_language_slo')?></option>
                                <option value="swe"><?=get_lang('chater_edit_language_swe')?></option>
                                <option value="hu"><?=get_lang('chater_edit_language_hu')?></option>
                                <option value="cht"><?=get_lang('chater_edit_language_cht')?></option>
                                <option value="vie"><?=get_lang('chater_edit_language_vie')?></option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
              </div>
            </form>
            <iframe id="frm_Upload" name="frm_Upload" style="display: none;"></iframe>
</body>
</html>

<script type="text/javascript">
var dataForm ;
var userId = "<?=g("id") ?>";
var appPath = "<?=getRootPath() ?>";
var defaultImg = appPath + "/livechat/assets/img/default.png" ;

$(document).ready(function(){
   dataForm = $("#form").attr("data-id",userId).dataForm({getcallback:chater_getCallBack1,savecallback:chater_saveCallBack1});
    $("#btn_save").click(function(){
        saveUserInfo();
        return false ;
    })
})

//控制backspace
$(document).keydown( function(e)
		{
	//获取键盘的按键CODE
	var k=e.keyCode;
	if(k == 8){
		//获取操作的标签对象
		var act = document.activeElement.tagName.toLowerCase();
		//如果按键为“backspace”并且标签对象为body或html时，返回false
		if(act.indexOf("body") != -1 || act.indexOf("html") != -1 || act == 'a')
		{
		   return false;
		}
		return true;
	}
	return true;
});


function chater_saveCallBack1()
{
	window.parent.postMessage({
			  cmd: 'endchater_edit',
			  params: ''
			}, '*');
}

function saveUserInfo()
{
    var endsession = $("#endsession").is(":checked")?1:0 ;
	$("#endsession").val(endsession);
	var userautotranslate = $("#userautotranslate").is(":checked")?1:0 ;
	$("#userautotranslate").val(userautotranslate);
    var chaterautotranslate = $("#chaterautotranslate").is(":checked")?1:0 ;
	$("#chaterautotranslate").val(chaterautotranslate);
	dataForm.save();
}
</script>