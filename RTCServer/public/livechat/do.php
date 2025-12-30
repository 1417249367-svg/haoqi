<?php  require_once("../class/fun.php");?>
<?php
        $userId = getValue("BIGANTLIVE_USERID"); //是否注册过
        $status = g("status"); //客服是否在线
		$query =  "?" . $_SERVER['QUERY_STRING'];
		

        //测试
        header("Location:index.html" . $query); 

//        if ($status == 3)
//        {
//            if ($userId == "")
//                header("Location:register.html" . $query); 
//            else
//                header("Location:index.html" . $query); 
//        }
//        else
//            header("Location:message.html" . $query); 

		
?>