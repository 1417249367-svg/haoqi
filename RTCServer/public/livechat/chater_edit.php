<?php  require_once("include/fun.php");?>
<?php
    $loginName = g("loginName","admin@rtcim.com");
	$dp = new Model("lv_chater");
	$dp -> addParamWhere("loginname",$loginName);
    $row = $dp-> getDetail();
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="/static/js/jquery.js" ></script>
    <script type="text/javascript" src="assets/js/site.js"></script>
    <script type="text/javascript" src="assets/js/set.js" ></script>
    <link  rel="stylesheet" href="assets/css/set.css">
</head>
<body>

        <dl>
            <dt>
                <h4 class="fl"><?=$row["username"]?></h4>
                <div class="fr">
                    <?php if ($row["status"] == 1){?>
                        <span class="status-on">状态：开放中</span>
                        <button class="btn" onclick="saveStatus('0')">关闭</button>
                    <?php }else { ?>
                        <span class="status-off">状态：关闭中</span>
                        <button class="btn" onclick="saveStatus('1')">打开</button>
                    <?php } ?>
                </div>
                <div class="clear"></div>
            </dt>
            <dd style="padding:10px">
                   <form id="form" method="post" class="form" data-table="lv_chater" data-fldid="id" data-fldname="loginname"  enctype="multipart/form-data" >      
                       <div class="col-photo">
                            <div class="user-photo">
                                
                                <input type="file" id="file_picture" name="file_picture"  class="file-picture" onchange="uploadPicture()"/>
                                <img id="img_picture" class="img-picture photo" src="<?=$row["picture"]?>"  />
                            </div>
                       </div>
                       <div class="col-info">

                            <div class="form-group"> 
                                <label class="control-label" for="dept">部门</label> 
                                <div class="control-value">
                                    <input type="text" name="deptname" id="deptname" placeholder="部门" class="form-control specialCharValidate data-field"   maxlength="50"   value="<?=$row["deptname"]?>" /> 
                                </div>
                                <div class="clear"></div>
                           </div> 
                           <div class="form-group"> 
                                <label class="control-label" for="jobtitle">职位</label> 
                                <div class="control-value">
                                    <input type="text" name="jobtitle" id="jobtitle" placeholder="职位" class="form-control specialCharValidate data-field"   maxlength="50"   value="<?=$row["jobtitle"]?>"  /> 
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="form-group"> 
                                <label class="control-label" for="phone">座机</label> 
                                <div class="control-value">
                                    <input type="text" name="phone" id="phone" placeholder="座机" class="form-control specialCharValidate data-field"   maxlength="50"    value="<?=$row["phone"]?>" /> 
                                </div>
                                <div class="clear"></div>
                           </div> 
                           <div class="form-group"> 
                                <label class="control-label" for="mobile">手机</label> 
                                <div class="control-value">
                                    <input type="text" name="mobile" id="mobile" placeholder="手机" class="form-control specialCharValidate data-field"   maxlength="50"    value="<?=$row["mobile"]?>" /> 
                                </div>
                                <div class="clear"></div>
                            </div>
                             <div class="form-group"> 
                                <label class="control-label" for="email">邮箱</label> 
                                <div class="control-value">
                                    <input type="text" name="email" id="email" placeholder="邮箱" class="form-control specialCharValidate data-field"  rows="3"   value="<?=$row["email"]?>" />
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="form-group"> 
                                <label class="control-label" for="welcome">欢迎语</label> 
                                <div class="control-value">
                                    <textarea name="welcome" id="welcome" placeholder="欢迎语" class="form-control specialCharValidate data-field"  rows="3"   ><?=$row["welcome"]?></textarea> 
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="form-group"> 
                                <label class="control-label">&nbsp;</label> 
                                <div class="control-value">
                                    <button  class="btn btn-primary" id="btn_save" onclick="saveUserInfo()">保存用户信息</button>
                                </div> 
                                <div class="clear"></div>
                            </div> 
                   </div>
                    <div class="clear"></div>
            </form>
            
            
            </dd>
        </dl>



    
    
</body>
</html>
 
 <script type="text/javascript">
    var loginName = "<?=$row["loginname"]?>" ;
	var appPath = "<?=getRootPath() ?>";
	var defaultImg = appPath + "/livechat/assets/img/default.png" ;
	
	$(document).ready(function(){
		$(".photo").bind("error",function(){   
			this.src= defaultImg;   
		});
	})
 </script>