<?php  require_once("fun.php");?>
<?php
$optType = strtolower(g( 'opttype','' ));


switch ($optType) {
	case 'syncdata' :
		syncData ();
		break;
	case 'delete' :
	    delete();
		break;
}

//清空部门和用户的接口
function delete()
{
    $db = new DB();
    $arr_sql = array();
    $arr_sql[] = "delete from hs_relation where (col_dhsitemtype=1 or col_dhsitemtype=2) and col_viewid in (select col_id from hs_view where col_type=1)";
    $arr_sql[] = "delete from hs_group where col_id in (select col_hsitemid from hs_relation where (col_hsitemtype=2 or col_dhsitemtype=2) and col_viewid in (select col_id from hs_view where col_type=1)";
    $arr_sql[] = "delete from hs_view where col_type=1";
    $arr_sql[] = "delete from hs_user where col_issystem=0";
    $db->execute($arr_sql);
    $result = array("code" => 1,"message" => "数据清除成功");
    $result = array("result" => $result);
    $result = json_encode($result);
    ob_clean();
    print $result;
}


/*
method	同步数据
http://localhost:8041/fiberhome/sync_data.html?filename=syncdata-201505191046-request.zip
*/
function syncData(){
    error_reporting( E_ALL&~E_NOTICE );
    recordLog("开始时间：" . getNowTime());
    $result = array("code" => 1,"message" => "同步成功");
    $fileName = g('syncfilename','');

    //得到数据包下载地址
    $syncFileName = str_replace("api", "files/", FIBERHOME_API) . $fileName ;

    //得到文件名称
    $arr_tmp = explode("/", $fileName);
    $fileName = $arr_tmp[count($arr_tmp)-1];


    //开始下载文件到临时目录
    $data = send_http_request($syncFileName);
    $path = __ROOT__ . "/data/fiberhome";
    mkdirs($path);

    file_put_contents($path . "/" . $fileName, $data);

    //发送请求时设置超时时间1秒，立即返回
    send_http_request("http://localhost:" . $_SERVER['SERVER_PORT'] . "/fiberhome/sync_data.html?filename=" . $fileName,"1");

    $result = array("result" => $result);
    $result = json_encode($result);
    ob_clean();
    print $result;
}


