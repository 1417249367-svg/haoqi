<?php
/*
 *
 * (c) Copyright Ascensio System Limited 2010-2017
 *
 * The MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
*/
?>

<?php
/**
 * WebEditor AJAX Process Execution.
 */
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/config/config.inc.php");
require_once (__ROOT__ . "/class/common/Site.inc.php");
require_once (__ROOT__ . "/class/common/lang.php"); //添加语言管理模块
require_once (__ROOT__ . "/class/common/Printer.class.php");
require_once (__ROOT__ . "/class/common/define.inc.php");
require_once (__ROOT__ . "/class/common/CurUser.class.php");
require_once (__ROOT__ . "/class/common/Application.class.php");
require_once (__ROOT__ . "/class/os/os.php"); 	// os 要在 db 类之前(db类用到os
require_once (__ROOT__ . "/class/db/DB.class.php");
require_once (__ROOT__ . "/class/db/Model.class.php");
require_once (__ROOT__ . "/class/ant/AntLog.class.php");
require_once (__ROOT__ . "/class/ant/AntSync.class.php");
require_once (__ROOT__ . "/class/hs/EmpRelation.class.php");
require_once (__ROOT__ . "/class/hs/Department.class.php");
require_once (__ROOT__ . "/class/hs/Passport.class.php");
require_once(__ROOT__ . "/class/common/Ziper.class.php");
require_once(__ROOT__ . "/class/common/ThumbHandler.class.php");
require_once(__ROOT__ . "/class/doc/DocXML.class.php");
require_once(__ROOT__ . "/class/doc/DocDir.class.php");
require_once(__ROOT__ . "/class/doc/DocFile.class.php");
require_once(__ROOT__ . "/class/doc/DocRelation.class.php");
require_once(__ROOT__ . "/class/doc/Doc.class.php");
require_once(__ROOT__ . "/class/doc/DocAce.class.php");
require_once(__ROOT__ . "/class/doc/DocSubscribe.class.php");
require_once(__ROOT__ . "/class/im/Msg.class.php");
require_once( dirname(__FILE__) . '/config.php' );
require_once( dirname(__FILE__) . '/ajax.php' );
require_once( dirname(__FILE__) . '/common.php' );
require_once( dirname(__FILE__) . '/functions.php' );

// 自动登录
$uri_loginname = g ( "loginname" );
$uri_password = g ( "password" );
$uri_ismanager = g ( "ismanager",0 );

function getAppValue($name = "",$defaultValue = "")
{
	global $arrSysConfig ;
	
	$name = strtolower($name);
	$value = "" ;

	if (isset($arrSysConfig[$name]))
		$value = $arrSysConfig[$name] ;

	if ($value == "")
		$value = $defaultValue ;

	return trim($value) ;

}

if (($uri_loginname != "") && ($uri_password != "")) {
	if ($uri_loginname != CurUser::getLoginName ()) {
		$uri_loginname = js_unescape ( $uri_loginname ); // 中文解码
		//if(getAppValue("Type")=="0"){
			$passport = new Passport ();
			$result = $passport->login ( $uri_loginname, $uri_password, $uri_ismanager,0,1); // 密码为加密过的
		//}

//		if ($result ["status"] == 0) {
//			print ('{"status":0,"errnum":' . $result ["errnum"] . '}') ;
//			die ();
//		}
	}
}

//加载基础语言
addLangModel1("cloud");


$_trackerStatus = array(
    0 => 'NotFound',
    1 => 'Editing',
    2 => 'MustSave',
    3 => 'Corrupted',
    4 => 'Closed'
);


if (isset($_GET["type"]) && !empty($_GET["type"])) { //Checks if type value exists
    $response_array;
    @header( 'Content-Type: application/json; charset==utf-8');
    @header( 'X-Robots-Tag: noindex' );
    @header( 'X-Content-Type-Options: nosniff' );

    nocache_headers();

	//sendlog(serialize($_GET), getStoragePath("OnlineFile/2/2/webedior-ajax10.log"));

    $type = $_GET["type"];

    switch($type) { //Switch case for value of type
        case "upload":
            $response_array = upload();
            $response_array['status'] = isset($response_array['error']) ? 'error' : 'success';
            die (json_encode($response_array));
        case "download":
            download();
            exit;
        case "convert":
            $response_array = convert();
            $response_array['status'] = 'success';
            die (json_encode($response_array));
        case "track":
            $response_array = track();
            $response_array['status'] = 'success';
            die (json_encode($response_array));
        case "delete":
            $response_array = delete();
            $response_array['status'] = 'success';
            die (json_encode($response_array));
        default:
            $response_array['status'] = 'error';
            $response_array['error'] = '404 Method not found';
            die(json_encode($response_array));
    }
}

function upload() {
    $result; $filename;

    if ($_FILES['files']['error'] > 0) {
        $result["error"] = 'Error ' . json_encode($_FILES['files']['error']);
        return $result;
    }

    $tmp = $_FILES['files']['tmp_name'];

    if (empty($tmp)) {
        $result["error"] = 'No file sent';
        return $result;
    }

    if (is_uploaded_file($tmp))
    {
        $filesize = $_FILES['files']['size'];
        $ext = strtolower('.' . pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION));

        if ($filesize <= 0 || $filesize > $GLOBALS['FILE_SIZE_MAX']) {
            $result["error"] = 'File size is incorrect';
            return $result;
        }

        if (!in_array($ext, getFileExts())) {
            $result["error"] = 'File type is not supported';
            return $result;
        }

        $filename = GetCorrectName($_FILES['files']['name']);
        if (!move_uploaded_file($tmp,  getStoragePath($filename)) ) {
            $result["error"] = 'Upload failed';
            return $result;
        }

    } else {
        $result["error"] = 'Upload failed';
        return $result;
    }

    $result["filename"] = $filename;
    return $result;
}

function download() {
    $fileName = $_GET["filename"];

    $filePath = getStoragePath($fileName);
    if (!file_exists($filePath)) {
        http_response_code(404);
        return;
    }
    header("Content-Length: " . filesize($filePath));
    header("Content-Type: " . mime_content_type($fileName));

    header("Content-Disposition: attachment; filename=\"".get_basename($filePath)."\"");
    readfile($filePath);
}

function track() {
//    sendlog("Track START", getStoragePath("OnlineFile/2/2/webedior-ajax.log"));
//    sendlog("_GET params: " . serialize( $_GET ), getStoragePath("OnlineFile/2/2/webedior-ajax1.log"));
    global $_trackerStatus;
    $data;
    $result["error"] = 0;

    if (($body_stream = file_get_contents('php://input'))===FALSE) {
        $result["error"] = "Bad Request";
        return $result;
    }

    $data = json_decode($body_stream, TRUE); //json_decode - PHP 5 >= 5.2.0

    if ($data === NULL) {
        $result["error"] = "Bad Response";
        return $result;
    }

//    sendlog("InputStream data: " . serialize($data), getStoragePath("OnlineFile/2/2/webedior-ajax2.log"));

    $status = $_trackerStatus[$data["status"]];

    switch ($status) {
        case "MustSave":
        case "Corrupted":

            //$userAddress = $_GET["userAddress"];
            $fileName = g("fileName");

            $downloadUri = $data["url"];

            $curExt = strtolower('.' . pathinfo($fileName, PATHINFO_EXTENSION));
            $downloadExt = strtolower('.' . pathinfo($downloadUri, PATHINFO_EXTENSION));

//            sendlog($downloadExt."|".$curExt, getStoragePath("OnlineFile/2/2/webedior-ajax4.log"));
//			if ($downloadExt != $curExt) {
//                $key = getDocEditorKey1($downloadUri);
//				//$key = "707087345";
//
//                try {
//                    //sendlog("Convert " . $downloadUri . " from " . $downloadExt . " to " . $curExt, getStoragePath("OnlineFile/2/2/webedior-ajax.log"));
//                    $convertedUri;
//                    $percent = GetConvertedUri($downloadUri, $downloadExt, $curExt, $key, FALSE, $convertedUri);
//                    $downloadUri = $convertedUri;
//					//sendlog($downloadUri, getStoragePath("OnlineFile/2/2/webedior-ajax.log"));
//                } catch (Exception $e) {
//                    //sendlog("Convert after save ".$e->getMessage(), getStoragePath("OnlineFile/2/2/webedior-ajax.log"));
//                    $result["error"] = "error: " . $e->getMessage();
//                    return $result;
//                }
//            }

            $saved = 1;

            if (($new_data = file_get_contents($downloadUri)) === FALSE) {
                $saved = 0;
            } else {
				//sendlog(g("doc_id"), getStoragePath("OnlineFile/2/2/webedior-ajax5.log"));
				$onlineid = g("doc_id");
				$doc = new Doc();
				$sql = " select count(*) as c from OnlineRevisedFile where OnlineID=" . $onlineid ;
				$recordcount = $doc -> db -> executeDataValue($sql);
				$recordcount +=2;
				$row = $doc -> db -> executeDataRow("select * from OnlineFile where OnlineID = ".$onlineid);
				//sendlog(var_dump($row), getStoragePath("OnlineFile/2/2/webedior-ajax7.log"));
				if (count($row)) {
					$typepath=str_replace(strrchr($row["typepath"], "."),"",$row["typepath"]).$downloadExt;
					$storagePath = $doc  -> modify_file(getStoragePath('OnlineFile/'.$row["myid"].'/'.$recordcount.'/'.$typepath),$typepath) ;
					//sendlog($storagePath."|".$filpath, getStoragePath("OnlineFile/2/2/webedior-ajax8.log"));
					$filpath = 'OnlineFile/'.$row["myid"].'/'.$recordcount.'/'.iconv_str(get_basename($storagePath),'gbk', 'utf-8');
					//sendlog($storagePath."|".$filpath, getStoragePath("OnlineFile/2/2/webedior-ajax6.log"));
					$file_item = $doc -> save_file4($onlineid,$filpath,$row["typepath"],$row["pcsize"],$row["myid"],$row["usname"],CurUser::GetUserName().get_lang('doceditor_edited_document'),$body_stream);
					switch ($row["formfiletype"]) {
						case 1 :
							$nformfiletype = get_lang("menu_sub_ptp_file");
							$sql = "update PtpFile set FilPath='".$filpath."' where OnlineID=" . $row["onlineid"];
							$doc -> db -> execute($sql) ;
							break;
						case 2 :
							$nformfiletype = get_lang("menu_sub_leave_file");
							$sql = "update LeaveFile set FilPath='".$filpath."' where OnlineID=" . $row["onlineid"];
							$doc -> db -> execute($sql) ;
							break;
						case 4 :
							$nformfiletype = get_lang("menu_sub_group_file");
							$sql = "update ClotFile set FilPath='".$filpath."' where OnlineID=" . $row["onlineid"];
							$doc -> db -> execute($sql) ;
							break;	
					}
	//$storagePath = getStoragePath('OnlineFile/2/2/'.date("Y").date("m").date("d").date("H").date("i").date("s").$downloadExt);
					file_put_contents($storagePath, $new_data, LOCK_EX);
					$doc -> save_file6($filpath,$row["typepath"],$row["pcsize"],$parent_type,$parent_id,$root_id,7);
					
					if((int)$row["authority3"]){
						$msg = new Msg ();
						$result = $doc -> onlineform_username($row["onlineid"],$row["formfiletype"]) ;
						switch ($row["formfiletype"]) {
							case 4 :
								$msg ->sendRTCMessge(CurUser::getLoginName (),$result["ptpform"],"", get_lang("menu_sub_file_alert1").$nformfiletype."<".$row["typepath"].">,{m@".$row["onlineid"]."}".get_lang("menu_sub_file_alert2"),"",1);
								break;
							default:
								$msg ->sendRTCMessge(CurUser::getLoginName (),$result["ptpform"],"", get_lang("menu_sub_file_alert1").$nformfiletype."<".$row["typepath"].">,{m@".$row["onlineid"]."}".get_lang("menu_sub_file_alert2"),"",0);
								break;
						}
					}
				}


            }

            $result["c"] = "saved";
            $result["status"] = $saved;
            break;
    }

    //sendlog("track result: " . serialize($result), "logs/webedior-ajax.log");
    return $result;
}

function convert() {
    $fileName = $_GET["filename"];
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $internalExtension = trim(getInternalExtension($fileName),'.');

    if (in_array("." + $extension, $GLOBALS['DOC_SERV_CONVERT']) && $internalExtension != "") {

        $fileUri = $_GET["fileUri"];
        if ($fileUri == NULL || $fileUri == "") {
            $fileUri = FileUri($fileName, TRUE);
        }
        $key = getDocEditorKey($fileName);

        $newFileUri;
        $result;
        $percent;

        try {
            $percent = GetConvertedUri($fileUri, $extension, $internalExtension, $key, TRUE, $newFileUri);
        }
        catch (Exception $e) {
            $result["error"] = "error: " . $e->getMessage();
            return $result;
        }

        if ($percent != 100)
        {
            $result["step"] = $percent;
            $result["filename"] = $fileName;
            $result["fileUri"] = $fileUri;
            return $result;
        }

        $baseNameWithoutExt = substr($fileName, 0, strlen($fileName) - strlen($extension) - 1);

        $newFileName = GetCorrectName($baseNameWithoutExt . "." . $internalExtension);

        if (($data = file_get_contents(str_replace(" ","%20",$newFileUri))) === FALSE) {
            $result["error"] = 'Bad Request';
            return $result;
        } else {
            file_put_contents(getStoragePath($newFileName), $data, LOCK_EX);
        }

        unlink(getStoragePath($fileName));

        $fileName = $newFileName;
    }

    $result["filename"] = $fileName;
    return $result;
}

function delete() {
    try {
        $fileName = $_GET["fileName"];

        $filePath = getStoragePath($fileName);

        unlink($filePath);
    }
    catch (Exception $e) {
        //sendlog("Deletion ".$e->getMessage(), "logs/webedior-ajax.log");
        $result["error"] = "error: " . $e->getMessage();
        return $result;
    }
}

?>