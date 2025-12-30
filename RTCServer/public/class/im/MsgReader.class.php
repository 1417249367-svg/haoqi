<?php  require_once(__ROOT__ . "/class/common/RTF.inc.php");?>
<?php  require_once(__ROOT__ . "/class/common/Ziper.class.php");?>
<?php
/**
 * 消息查看 读取消息内容  解析消息内容  下载附件
 * 文件操作用 gbk ,输出用utf-8    -----------------------重要重要重要重要重要

 * @date    20140325
 */

class MsgReader
{
	public $datapath = "" ;
	public $msgid = "" ;
	public $attrs = array();
	public $params = array();
	public $content_type = "" ;
	public $content = "" ;
	public $html = "" ;
	public $package = array();
	public $db ;
	public $msgTitle;
	public $msgType;


	function __construct()
	{
		$this -> db = new DB();
	}
	
	/*
	method	得到属性数组中的值
	param	$attr_name 属性名称
	param	$defaultValue 缺省值
	*/
	function get_attr($attr_name,$defaultValue = "")
	{
		return get_array_value($this -> attrs,$attr_name,$defaultValue) ;
	}


	//加载消息文件
	function load($file)
	{
		$this -> clear();
		$flag =1 ;
		while(!feof($file))
		{
			$line = fgets($file);
            if ($line == "")
                continue;
			if ($flag == 1)
			{
				$sp = strpos($line ,":");
				if ($sp > 0)
				{
					//read attr
					$name = substr($line,0,$sp) ;
					$value = substr($line,$sp+1) ;
					$this -> attrs[$name] = $value ;
				}
				else
				{
					//read content
					$flag = 2 ;
				}
			}
			if ($flag == 2)
			{
				$this -> content .= $line ;
			}
		}

	}

	//读取消息
	function read($_msgid,$_datapath)
	{
		$this -> msgid = $_msgid ;
		$this -> datapath = $_datapath ;
		$this -> package = array() ;

		if (strpos($_msgid,"{") == -1)
			$_msgid = "{" . $_msgid . "}";

		$path = RTC_DATADIR . "/" . $_datapath . "/" .  $_msgid . ".msg";

		if(!file_exists($path))
		{
			$this -> content = "" ;
			$this -> html = get_lang("msg_file_error") ;
			return 0;
		}


		$file = fopen($path,"r") ;
		$this -> load($file) ;
		fclose($file);


		$this -> content_type = trim($this -> attrs["content-type"]);
		$this -> html = $this -> content ;

		switch($this -> content_type)
		{
			case "Text/Btf":
				$this -> html = $this -> format_btf();
				break;
			case "Text/Rtf":
				$this -> html = $this -> format_rtf();
				break;
		}
		return 1 ;
	}



	function format_btf()
	{
		$this -> html = $this -> btf2html($this -> content,$this -> msgid,$this -> datapath);
 		return $this -> html;
	}



	function format_rtf()
	{
		$this -> html = $this -> rtf2html($this -> content);
		return $this -> html ;
	}

	function btf2html($content,$msgid,$datapath)
	{

		//20150706 替换  ]]&gt; 为 ]]> ，再取<Text>的内容
		$content = str_replace("]]&gt;","]]>",$content);
		
		$doc = xml_parser_create();
		xml_parse_into_struct($doc, $content, $data, $index);
		xml_parser_free($doc);

		$html = "";
		foreach($data as $item)
		{
			if ($item["tag"] == "FILE")
			{
				$file = "" ;
				$this -> package["datapath"] = str_replace("Message","UploadFile",$datapath);
				$this -> package["name"] = $item["attributes"]["NAME"] ;
				$this -> package["type"] = $item["attributes"]["TYPE"] ;
				$this -> package["size"] = $item["attributes"]["SIZE"] ;
				$this -> package["content"] = str_replace("\n", "|",$item["value"]);

				if ($this -> package["type"] == 2)
				{
					//folder
					$html .= $this -> get_file_html($msgid,$this -> package["type"],$this -> package["name"],$this -> package["size"],$datapath) ;
				}
				else
				{
					//file
					$data = $this -> get_package_data($this -> package["content"]);

					foreach($data as $row)
					{
						$fileType = $this -> ispic($row["file_name"])?0:1;
						$this->msgType = $fileType;
                        if($fileType == 0)
                        {
                            $this->msgTitle = get_lang("msg_recv_pic");
                        }
                        else
                        {
                            if($this->isSound($row["file_name"])==1)
                            {
                                $this->msgTitle = get_lang("msg_recv_sound");
                                $this->msgType = 2;
                            }
                            else
                            {
                                $this->msgTitle = get_lang("msg_recv_attach");
                            }

                        }

						$html .= $this -> get_file_html($msgid,$fileType,$row["file_name"],$row["file_size"],$row["file_path"],$row["file_guid"]) ;
					}
				}

			}

			if ($item["tag"] == "TEXT")
			{
			    $this->msgType = 3;
				$text = $item["value"] ;
				if (strpos($text,"rtf") > -1)
					$text = $this -> rtf2html($text);
				$html .= $text ;
			}
		}

		return $html ;
	}
	//jc 20150116
	//得到文件HTML
	//$fileType  0 pic  1 file 2 folder
	function PastImgEx($RTB,$totype,$YID)
	{
		$html = "" ;
		$fileUrl = "" ;
		//echo $RTB;
		$RTB=js_unescape($RTB);
		$arrEx = explode ( "{", $RTB );
		$arrcount=count($arrEx);
		for ($i=0; $i<$arrcount-1; $i++) {
		  $m=strpos($RTB,"{")+1;
		  $n=strpos($RTB,"}")-$m;
		  $TempString=substr($RTB, $m, $n);
		  $tType=substr($TempString,0,2);
		  $tString=substr($TempString,2);
		  $arrfile = explode ( "/", $tString );
		  $fileName=$arrfile[count($arrfile)-1];
		  //$src = $uc_url."Data/".$tString;
		  //$fileUrlPath=str_replace("\\","/",$tString);
		  $filepath = RTC_CONSOLE .'/' . $tString;
          $fileSize = filesize($filepath);
		  $imgsrc = '';
		  $imgid = '';
		  $res = '';
		  $res1 = '';
		  switch($tType)
		  {
//			  case "b@":
//			      $fileType=1;
//				  $RTB = str_replace("{".$TempString."}","附件:《" . $fileName . "》<span class='file-size'>大小:" .  getSizeExp($fileSize) ."</span> <a href=\"#\" onclick=\"get_filepath(this,'" . $filepath. "')\">下载</a>",$RTB) ;
//				  $RTB = "<div  class='file-item file-type-" . $fileType . "' msg-datapath='" . $fileUrlPath . "'  file-name='" . $fileName. "'  file-size='" .$fileSize. "'>" . $RTB . "</div>" ;
//				  break ;
			  case "h@":
			      if($totype==1) $res=get_lang("class_msgreader_warning");
				  $tString1=utf8_unicode($tString);
				  $res1 = '<div ontouchstart="zy_touch(\'btn-act1\')" class="kl_box21b">
                      <div class="kc_box50 clearfix" onclick="javascript:cmd([\'ptpfile\']);">
                          <div class="zs2tb_box15 clearfix">
                          <img class="ktx image" src="MyPic/FileRecv/File-Sucess.png"/>
                          </div>
                          <img class="ktx image" src="/Data/ico/'.get_extension($fileName).'.png" onerror="this.src=\'/Data/ico/weizhi.png\'"/>
                      </div>
                      <p class="kc_text7c" onclick="javascript:cmd([\'ptpfile\']);">'.$fileName.'</p>
                      <p class="kc_text10c" onclick="javascript:cmd([\'ptpfile\']);">'.$res.get_lang("cloud_file").'</p>
                      <br><br>
                      <p class="kc_text10d"><a href="javascript:cmd([\'go2new6\',14,\''.$tString1.'\','.$YID.']);">' . get_lang("download") . '</a>&nbsp;&nbsp<a href="javascript:cmd([\'go2new6\',15,\''.$tString1.'\']);">'. get_lang("class_msgreader_warning1") .'</a>&nbsp;&nbsp<a href="javascript:cmd([\'ptpfile\']);">'. get_lang("class_msgreader_warning2") .'</a>&nbsp;&nbsp</p>
                  </div>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "c@":
			      $fileType=0;
				  $aa = strpos($tString, ":");
				  $x = substr($tString, 2, $aa - 2);
				  $y = substr($tString, $aa + 3);
				  
				  $fileUrl = "FileRecv/map_located.png";
				  //$fileUrl = str_replace("\\","/",$fileUrl);
				  $fileUrl = "/public/msg.html?op=getimg&url=" . $fileUrl ;
				  
				  $RTB = str_replace("{".$TempString."}","<a href=\"#\" onclick=\"get_urlpath(this,'" . $x . "','" . $y . "')\"><img class='thumbpic' src='" . $fileUrl . "'></a>",$RTB) ;
				  $RTB = "<div  class='file-item file-type-" . $fileType . "'  file-name='" . $fileName. "'  file-size='" .$fileSize. "'>" . $RTB . "</div>" ;
				  break ;
			  case "d@":
			      $arr_item = explode("|",$tString);
				  $target_file = $arr_item[0];
				  $fileSize = $arr_item[1];
				  $duration = $arr_item[2];
				  $filePic = $arr_item[3];
				  $tString1=utf8_unicode($tString);
				  $res1 = '<a href="javascript:cmd([\'go2new6\',2,\''.$tString1.'\',\''.$YID.'\']);PlaySound(\''.base64_encode($TempString).'\');"><img src="MyPic/FileRecv/record_other_normal.png" id="'.$TempString.'" alt="'.$totype.'" ontouchstart="zy_touch(\'btn-act\')"/></a>'+$duration;
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "e@":
			      $arr_item = explode("|",$tString);
				  $target_file = $arr_item[0];
				  $fileSize = $arr_item[1];
				  $duration = $arr_item[2];
				  $filePic = $arr_item[3];
				  $fileUrl = str_replace("\\","/",$target_file);
				  $fileUrl = "/public/msg.html?op=getimg1&url=" . $fileUrl ;
				  $res1 = '<a href="javascript:cmd([\'go2new6\',3,\''.utf8_unicode($target_file).'\']);"><img class="kl_img" data-type="'.$tType.'" data-target="'.$tString.'" data-filesize="'.$fileSize.'" src="'.$fileUrl.'" ontouchstart="zy_touch(\'btn-act\')" ondblclick="cmd([\'go2new6\',3,\''.utf8_unicode($target_file).'\']);"/></a>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "f@":
				  $res1 = '<img class="kl_img" data-type="'.$tType.'" data-target="'.$tString.'" src="/Data/'.$tString.'" ontouchstart="zy_touch(\'btn-act1\')"/>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "i@":
			      $arr_item = explode("|",$tString);
				  $target_file = $arr_item[0];
				  $fileSize = $arr_item[1];
				  $duration = $arr_item[2];
				  $filePic = $arr_item[3];  
				  $fileUrl = str_replace("\\","/",$filePic);
				  $fileUrl = "/public/msg.html?op=getimg1&url=" . $fileUrl ;
				  $res1 = '<a href="javascript:cmd([\'go2new6\',4,\''.utf8_unicode($target_file).'\']);"><img src="'.$fileUrl.'" ontouchstart="zy_touch(\'btn-act1\')"/></a>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "k@":
			      $fileType=0;
				  
				  $Cards = explode ( ":", $tString );
				  $Cards[0]=str_replace("uid=", "", $Cards[0]);
				  $Cards[1]=str_replace("category=", "", $Cards[1]);
				  $Cards[2]=str_replace("FcName=", "", $Cards[2]);
				  if($Cards[1]==1){
					  $imgsrc="1_1.png";
					  $res=get_lang("class_msgreader_warning3");
					  $res1='<a href="javascript:cmd([\'talkTofriend\','.$Cards[0].',1]);">'. get_lang("class_msgreader_warning4") .'</a>&nbsp;&nbsp';
				  }else{
					  $imgsrc="0_2.png";
					  $res=get_lang("class_msgreader_warning5");
					  //$res1="群名称";
				  }
				  $res1 = '<div ontouchstart="zy_touch(\'btn-act1\')" class="kz_box2a clearfix">
					  <div class="kz_box4 clearfix" onclick="javascript:cmd([\'toPeople\',\''.$Cards[0].'\','.$Cards[1].']);">
						  <div class="kc_box5 clearfix">
							  <img class="ktx image" src="MyPic/FileRecv/'.$imgsrc.'"/>
						  </div>
						  <div class="kc_box12a clearfix">
							  <p class="kc_text7a" onclick="javascript:cmd([\'toPeople\',\''.$Cards[0].'\','.$Cards[1].']);">'.$Cards[2].'</p>
						  </div>
						  <div class="kc_box13a clearfix">
							  <p class="kc_text9 tx_l1" onclick="javascript:cmd([\'toPeople\',\''.$Cards[0].'\','.$Cards[1].']);">'.$res.'</p>
							  <p class="kc_text10"></p>
						  </div>
					  </div>
					  <div class="kz_box5 clearfix">
					  <div>
								  <p class="kc_text10d"><a href="javascript:cmd([\'toPeople\',\''.$Cards[0].'\','.$Cards[1].']);">'. get_lang("class_msgreader_warning6") .'</a>&nbsp;&nbsp'.$res1.'<a href="javascript:cmd([\'go2new6\',21,\''.$Cards[0].'\','.$Cards[1].']);">'. get_lang("class_msgreader_warning1") .'</a>&nbsp;&nbsp</p>
							  </div>
					  </div>
				  </div>' ;
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "o@":
				  $res1 = '<a class="alink" href="'.$tString.'" target="_blank">'.$tString.'</a>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
		  }
		} 
		 //$RTB = str_replace(PHP_EOL, '<br>, $RTB); 
		 //$RTB = str_replace(chr(32), '&nbsp;&nbsp;', $RTB); 
//		$pattern='/(http:＼/＼/|https:＼/＼/|ftp:＼/＼/)([＼w:＼/＼.＼?=&-_]+)/is';
//        $RTB=preg_replace($pattern, '<a href=＼1＼2>＼2</a>', $RTB);
		return array("data"=>$RTB,"data_type"=>$tType,"data_target"=>$tString);
	}
	
	function PastImgEx1($RTB,$totype,$YID)
	{
		$html = "" ;
		$fileUrl = "" ;
		//echo $RTB;
		$RTB=js_unescape($RTB);
		$arrEx = explode ( "{", $RTB );
		$arrcount=count($arrEx);
		for ($i=0; $i<$arrcount-1; $i++) {
		  $m=strpos($RTB,"{")+1;
		  $n=strpos($RTB,"}")-$m;
		  $TempString=substr($RTB, $m, $n);
		  $tType=substr($TempString,0,2);
		  $tString=substr($TempString,2);
		  $arrfile = explode ( "/", $tString );
		  $fileName=$arrfile[count($arrfile)-1];
		  //$src = $uc_url."Data/".$tString;
		  //$fileUrlPath=str_replace("\\","/",$tString);
		  $filepath = RTC_CONSOLE .'/' . $tString;
          $fileSize = filesize($filepath);
		  $imgsrc = '';
		  $imgid = '';
		  $res = '';
		  $res1 = '';
		  switch($tType)
		  {
			  case "h@":
			      if($totype==1) $res=get_lang("class_msgreader_warning");
				  $tString1=utf8_unicode($tString);
				  $src = get_download_url($tString) ;
				  $res1 = '<div ontouchstart="zy_touch(\'btn-act1\')" class="kl_box21b">
                      <div class="kc_box50 clearfix" onclick="javascript:window.open(\''.$src.'\');">
                          <div class="zs2tb_box15 clearfix">
                          <img class="ktx image" src="/addin/MyPic/FileRecv/File-Sucess.png"/>
                          </div>
                          <img class="ktx image" src="/Data/ico/'.get_extension($fileName).'.png" onerror="this.src=\'/Data/ico/weizhi.png\'"/>
                      </div>
                      <p class="kc_text7c" onclick="javascript:window.open(\''.$src.'\');">'.$fileName.'</p>
                      <p class="kc_text10c" onclick="javascript:window.open(\''.$src.'\');">'.$res.get_lang("cloud_file").'</p>
                      <br><br>
                      <p class="kc_text10d"><a href="javascript:window.open(\''.$src.'\');">' . get_lang("download") . '</a>&nbsp;&nbsp</p>
                  </div>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "c@":
			      $fileType=0;
				  $aa = strpos($tString, ":");
				  $x = substr($tString, 2, $aa - 2);
				  $y = substr($tString, $aa + 3);
				  
				  $fileUrl = get_download_url("FileRecv/map_located.png");
				  
				  $RTB = str_replace("{".$TempString."}","<a href=\"#\" onclick=\"get_urlpath(this,'" . $x . "','" . $y . "')\"><img class='thumbpic' src='" . $fileUrl . "'></a>",$RTB) ;
				  $RTB = "<div  class='file-item file-type-" . $fileType . "'  file-name='" . $fileName. "'  file-size='" .$fileSize. "'>" . $RTB . "</div>" ;
				  break ;
			  case "d@":
			      $arr_item = explode("|",$tString);
				  $target_file = $arr_item[0];
				  $fileSize = $arr_item[1];
				  $duration = $arr_item[2];
				  $filePic = $arr_item[3];
				  $src = get_download_url($target_file) ;
				  $tString1=utf8_unicode($tString);
				  $ext=get_extension($target_file);
				  if($ext=='amr'){
					  $id=md5($tType.$target_file);
					  $imgsrc="record_other_normal.png";
					  $res1='<a href="javascript:PlaySound(\''.$id.'\',\''.$src.'\');"><img src="/static/img/'.$imgsrc.'" id="'.$id.'" alt="'.$totype.'" ontouchstart="zy_touch(\'btn-act\');"/></a>'.$duration;
				  }else $res1 = '<audio src="'.$src.'" controls="controls"></audio>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "e@":
			      $arr_item = explode("|",$tString);
				  $target_file = $arr_item[0];
				  $fileSize = $arr_item[1];
				  $duration = $arr_item[2];
				  $filePic = $arr_item[3];
				  $src = get_download_url($target_file) ;
				  $res1 = '<a href="'.$src.'" rel="lightbox-group" target="_blank"><img class="kl_img" data-type="'.$tType.'" data-target="'.$tString.'" data-filesize="'.$fileSize.'" src="'.$src.'" ontouchstart="zy_touch(\'btn-act\')"/></a>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "f@":
			      $src = get_download_url($tString) ;
				  $res1 = '<img class="kl_img" data-type="'.$tType.'" data-target="'.$tString.'" src="'.$src.'" ontouchstart="zy_touch(\'btn-act1\')"/>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "i@":
			      $arr_item = explode("|",$tString);
				  $target_file = $arr_item[0];
				  $fileSize = $arr_item[1];
				  $duration = $arr_item[2];
				  $filePic = $arr_item[3];  
				  $src = get_download_url($target_file) ;
				  $res1 = '<video src="'.$src.'" controls="controls"></video>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "k@":
			      $fileType=0;
				  
				  $Cards = explode ( ":", $tString );
				  $Cards[0]=str_replace("uid=", "", $Cards[0]);
				  $Cards[1]=str_replace("category=", "", $Cards[1]);
				  $Cards[2]=str_replace("FcName=", "", $Cards[2]);
				  if($Cards[1]==1){
					  $imgsrc="1_1.png";
					  $res=get_lang("class_msgreader_warning3");
					  $res1="dialog('user',langs.user_edit,'/admin/hs/user_edit.html?userid=" . $Cards[0] . "');";
				  }else{
					  $imgsrc="0_2.png";
					  $res=get_lang("class_msgreader_warning5");		  
					  $res1="";
				  }
				  $res1 = '<div ontouchstart="zy_touch(\'btn-act1\')" class="kz_box2a clearfix">
					  <div class="kz_box4 clearfix">
						  <div class="kc_box5 clearfix">
							  <img class="ktx image" src="/addin/MyPic/FileRecv/'.$imgsrc.'"/>
						  </div>
						  <div class="kc_box12a clearfix">
							  <p class="kc_text7a">'.$Cards[2].'</p>
						  </div>
						  <div class="kc_box13a clearfix">
							  <p class="kc_text9 tx_l1">'.$res.'</p>
							  <p class="kc_text10"></p>
						  </div>
					  </div>
					  <div class="kz_box5 clearfix">
					  <div>
								  <p class="kc_text10d"></p>
							  </div>
					  </div>
				  </div>' ;
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "o@":
				  $res1 = '<a class="alink" href="'.$tString.'" target="_blank">'.$tString.'</a>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "q@":
			      $arr_item = explode("|",$tString);
				  if(strlen($arr_item[2])>15) $arr_item[2]=substr($arr_item[2],0,8)."...".substr($arr_item[2],strlen($arr_item[2])-7,strlen($arr_item[2]));
				  $res1 = '<div onclick="go2new12(\''.$arr_item[0].'\');" class="kl_box21b"><div class="kc_box50 clearfix"><img class="ktx image" src="'.$arr_item[1].'"/></div><p class="kc_text7c">'.$arr_item[2].'</p><p class="kc_text10c">'.$arr_item[3].'</p></div>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "x@":
			      $src = get_download_url("FileRecv/ic_actbar_tel2.png");
				  $res1 = '<img class="kl_img" data-type="'.$tType.'" data-target="'.$tString.'" src="'.$src.'" ontouchstart="zy_touch(\'btn-act1\')"/>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
			  case "y@":
			      $src = get_download_url("FileRecv/ico_video2.png");
				  $res1 = '<img class="kl_img" data-type="'.$tType.'" data-target="'.$tString.'" src="'.$src.'" ontouchstart="zy_touch(\'btn-act1\')"/>';
				  $RTB = str_replace("{".$TempString."}",$res1,$RTB) ;
				  break ;
		  }
		} 
		 //$RTB = str_replace(PHP_EOL, '<br>, $RTB); 
		 //$RTB = str_replace(chr(32), '&nbsp;&nbsp;', $RTB); 
//		$pattern='/(http:＼/＼/|https:＼/＼/|ftp:＼/＼/)([＼w:＼/＼.＼?=&-_]+)/is';
//        $RTB=preg_replace($pattern, '<a href=＼1＼2>＼2</a>', $RTB);
		return array("data"=>$RTB,"data_type"=>$tType,"data_target"=>$tString);
	}
	
	function decodeUserText($UserText)
	{
		$UserText=js_unescape($UserText);
		if(strpos($UserText,"{a@")) $UserText=get_lang("lv_chat_file");
		elseif(strpos($UserText,"{c@")) $UserText=get_lang("lv_chat_location");
		elseif(strpos($UserText,"{d@")) $UserText=get_lang("lv_chat_voice");
		elseif(strpos($UserText,"{e@")) $UserText=get_lang("lv_chat_pic");
		elseif(strpos($UserText,"{f@")) $UserText=get_lang("lv_chat_expression");
		elseif(strpos($UserText,"{i@")) $UserText=get_lang("lv_chat_video");
		elseif(strpos($UserText,"{o@")) $UserText=get_lang("lv_chat_link");
		elseif(strpos($UserText,"{q@")) $UserText=get_lang("lv_chat_link");
		return $UserText;
	}
	//jc 20150116
	//得到文件HTML
	//$fileType  0 pic  1 file 2 folder
	function get_file_html($msgId,$fileType,$fileName,$fileSize,$filePath,$fileGuid = "")
	{
		$html = "" ;
		$fileUrl = "" ;
		switch($fileType)
		{
			case 0:
				$fileUrl = $filePath;
				$fileUrl = str_replace("\\","/",$fileUrl);
				$fileUrl = "/public/msg.html?op=getimg1&url=" . $fileUrl ;
				$html = "<a href='" . $fileUrl . "'  target='_blank'><img class='thumbpic' src='" . $fileUrl . "'></a>" ;
				$fileUrl = "/public/msg.html?op=get_file&fileguid=" . $fileGuid ;
				break ;
			case 1:
				$fileUrl = "/public/msg.html?op=get_file&fileguid=" . $fileGuid ;
				$html = get_lang("attach") . ":《" . $fileName . "》<span class='file-size'>大小:" .  getSizeExp($fileSize) ."</span> <a href=\"#\" onclick=\"get_file(this,'" . $fileGuid . "')\">" . get_lang("download") . "</a>" ;
				break ;
			case 2:
				$fileUrl = "/public/msg.html?op=get_package&msgid=" . $msgId . "&datapath=" . $filePath ;
				$html = get_lang("attach") . ":《" . $fileName . "》<span class='file-size'>大小:" .  getSizeExp($fileSize) ."</span> <a href='#' onclick='get_package(this)'>" . get_lang("download") . "</a>" ;
				break ;
		}

		 $html = "<div  class='file-item file-type-" . $fileType . " " . ($fileType == 0?"thumbview":"") . "'  url='" . $fileUrl . "'"  .
		 		 " file-type='" . $fileType . "'  msg-id='" . $msgId . "'  msg-datapath='" . $filePath . "'  file-name='" . $fileName. "'  file-size='" .$fileSize. "'>" . $html . "</div>" ;
		 return $html ;
	}


	//得到文件，根据消息文件
	function get_file_bymsg($datapath,$msgid)
	{
		$result = $this -> read($datapath,$msgid) ;
		if (! $result)
			return "" ;

		$datapath = $this -> package["datapath"];
		$package_name = $this -> package["name"] ;
		$package_size = $this -> package["size"] ;
		$package_type = $this -> package["type"] ;
		$package_content = $this -> package["content"] ;

		//得到文件列表
		$filelist = $this -> get_package_data($package_content);

		return $this -> get_package($filelist,$package_name);
	}

	//得到文件，根据文件GUID
	function get_file_byguid($fileguid)
	{
		$row = $this -> get_file_data1($fileguid);
		if (count($row) == 0)
			return "" ;

		//得到文件列表
		$file = array("file_name"=>$row["col_filename"],"file_dir"=>"","file_path"=>$row["col_filepath"]) ;

		return $this -> get_package(array($file),$row["col_filename"]);
	}


	//生成文件或文件包
	//$filelist {"file_name"=>"1.txt","file_dir"=>"","file_path"=>""}
	function get_package($filelist,$package_name)
	{
		//get source folder
		$source_folder = RTC_CONSOLE . "/";
		$source_folder = $this -> format_turepath($source_folder);

		//create target folder
		$target_folder = __ROOT__ . "/temp/" . date("Ymd") .  "/" . ($this -> msgid) ;
		if (count($filelist)>1)
			$target_folder .= "/" . $package_name ; //文件夹名称

		$target_folder = $this -> format_turepath($target_folder);
		mkdirs($target_folder);
//		echo $source_folder.'<br>';
//		echo $target_folder.'<br>';
//		exit();

		//拷贝文件
		foreach($filelist as $file)
			$package_file = $this -> copy_file($source_folder,$target_folder,$file["file_dir"],$file["file_name"],$file["file_path"]) ;

		// 文件操作用 gbk ,输出用utf-8
		$package_file = iconv_str($package_file,'gbk', 'utf-8') ;

		//如果是文件夹
		if (count($filelist)>1)
		{
			$package_file = $target_folder . ".zip" ;

			if (! is_file(iconv_str($package_file,'utf-8', 'gbk')))
			{
				$zip = new Ziper();
				$zip -> zipFolder($target_folder,$package_file);
			}
		}


		//得到虚拟路径
		$package_file = $this -> format_virtualpath($package_file);
		return $package_file ;

	}


	//得到文件列表数据
	//1\SQLQuery2.sql;CCE4F58216F511E4ACFF005056C00008
	//return  file_dir=>1,file_name=SQLQuery2.sql,file_path=20141113\SQLQuery2.sql-34C3B3236B0511E4BA82005056C00008
	function get_package_data($package_content)
	{
		$filelist = array();
		$msg_data = explode("|",$package_content);


		//遍历
		foreach($msg_data as $msg_row)
		{
			if (strpos($msg_row,"."))
			{
				$file = $this -> get_fileinfo($msg_row);
				$file_db = $this -> get_file_data( $file["file_guid"]);
				if (count($file_db)>0)
				{
					$file["file_path"] = $file_db["filestorepath"] ;
					$file["file_size"] = $file_db["filereceivedsize"] ;
					$filelist[] = $file ;
				}
			}
		}
		return $filelist ;
	}

	//得到文件信息
	//1\SQLQuery2.sql;CCE4F58216F511E4ACFF005056C00008
	//file_dir=>1,file_name=>SQLQuery2.sql,file_guid=>CCE4F58216F511E4ACFF005056C00008
	function get_fileinfo($file)
	{
		$sp = strpos($file,";");
		$file_name = substr($file,0,$sp);
		$file_guid = substr($file,$sp + 1);
		$file_dir = "" ;

		$sp = strrpos($file,"/");
		if ($sp)
		{
			$file_dir = substr($file_name,0,$sp);
			$file_name = substr($file_name,$sp + 1);
		}
		return array("file_dir"=>$file_dir,"file_name"=>$file_name,"file_guid"=>$file_guid);
	}


	function get_file_data($fileguid)
	{
		$sql = " select * from tbl_FileInfo  where fileguid='" . $fileguid . "'" ;
		$row = $this -> db -> executeDataRow($sql);
		return $row ;
	}

	function get_file_data1($fileguid)
	{
		$sql = " select * from Board_Attach  where col_ID='" . $fileguid . "'" ;
		$row = $this -> db -> executeDataRow($sql);
		return $row ;
	}


	function ispic($file_name)
	{
		$file_name = strtolower($file_name);
		$sp = strrpos($file_name,".");
		if ($sp)
		{
			$extend_name = substr($file_name,$sp);
			if (strrpos(",.png,.jpg,.gif,.bmp,",$extend_name))
				return 1 ;
		}
		return 0 ;
	}

	function isSound($file_name)
	{
	    $file_name = strtolower($file_name);
	    $sp = strrpos($file_name,".");
	    if ($sp)
	    {
	        $extend_name = substr($file_name,$sp);
	        if (strrpos(",.aac,.wav,.mp3,.m4a,",$extend_name))
	            return 1 ;
	    }
	    return 0 ;
	}

	function rtf2html($content)
	{
		//return rtf2text($content);
		return rtf2html($content);  // in site.inc.php
	}

	function clear()
	{
		$this -> attrs = array();
		$this -> params = array();
		$this -> content = "" ;
	}



	function copy_file($source_folder,$target_folder,$file_dir,$file_name,$file_path)
	{
		if ($file_path == "")
			return "" ;

		$source_file = $source_folder . $file_path;
		//$source_file = str_replace ( "/","\\", $source_file );

		//创建文件夹
		if ($file_dir != "")
		{
			$target_folder = $target_folder  . "/" . $file_dir ;
			mkdirs($target_folder);
		}
		$target_file = $target_folder . $file_name ;
//		echo $source_file.'<br>';
//		echo $target_folder.'<br>';
//		exit();
		//复制文件
		$source_file = iconv_str($source_file,'utf-8', 'gbk');
		$target_file = iconv_str($target_file,'utf-8', 'gbk');

		if (file_exists($source_file))
		{
			copy($source_file,$target_file) ;
			return $target_file ;
		}
		else
		{
			return "" ;
		}

	}


	function format_turepath($path)
	{
		$path = str_replace("\\","/",$path);
		$path = str_replace("{","",$path);
		$path = str_replace("}","",$path);
		return $path;
	}

	function format_virtualpath($path)
	{
		$path = str_replace("\\\\","/",$path);
		$path = str_replace("\\","/",$path);

		$path = str_replace(__ROOT__,"",$path);
		return $path;
	}


}


?>