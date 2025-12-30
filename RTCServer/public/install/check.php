<?php
require_once("fun.php");


error_reporting(0);

function print_result($result)
{
	if ($result)
		print ('<div class="icon-success">' . get_lang("environment_success") . '</div>');
	else
		print ('<div class="icon-error">' . get_lang("environment_fail") . '</div>');
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
</head>
<body>

				<form  id="form1" method="post" action="db.html" class="form-horizontal">


				<div class="step" style="display:block">
					<div class="step-top"><?=get_lang("environment_check")?></div>
					<div class="step-body">
                        <div class="form-group">
                            <label class="control-label"><?=get_lang("environment_db")?></label>
                            <div class="control-value">
								<?php
									$db = new DB();
									$result = $db -> testConn();
									
									print_result($result);

								?>
							</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?=get_lang("environment_dll_antcom")?></label>
                            <div class="control-value">
								<?php
									$result = install_antcom() ;
									print_result($result);
								?>
							</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?=get_lang("environment_dll_ascom")?></label>
                            <div class="control-value">
								<?php
									$result = install_ascom() ;
									print_result($result);
								?>
							</div>
                        </div>
					</div>
					<div class="step-bottom">
						<a href='../admin/account/login.html' target='_blank' class='btn btn-primary'><?=get_lang("btn_login")?></a>
					</div>
				</div>

         </form>


</body>
</html>
