<?php  require_once(__ROOT__ . "/class/common/Regedit.class.php");?>
<?php
/**
 * 服务组件类

 * @date    20140920
 */

class AntService
{
	public $ascom  ;
	function __construct()
	{
		//$this -> ascom =  new COM("ASCom.AntServerCtrl") or die("建立WScript.Shell出错！") ;
	}

	//得到状态
	public function get_status($my_services)
	{
		$arr_data = array ();
		$arr_service = $this -> get_service_array($my_services);
		foreach($arr_service as $my_service)
		{
			if ($my_service){
				//$this -> ascom -> AddService($my_service);
				$output = exec('sc query '.$my_service.' | find "STATE"');
				array_push($arr_data,array("doc_name"=> $my_service,"doc_status"=> substr(preg_replace('/\s+/', '', $output),6,1)));
			}
		}

		//$xml = $this -> ascom -> GetAllStatus();
		//recordLog($xml);
		return $arr_data ;
	}

	//启动
	public function start($my_services)
	{
		$arr_service = $this -> get_service_array($my_services);
		foreach($arr_service as $my_service)
		{
			if ($my_service)
				//$this -> ascom -> Start($my_service);
				exec("sc start ".$my_service);
		}
	}

	//停止
	public function stop($my_services)
	{
		$arr_service = $this -> get_service_array($my_services);
		foreach($arr_service as $my_service)
		{
			if ($my_service)
				//$this -> ascom -> Stop($my_service);
				exec("sc stop ".$my_service);
		}
	}

	//关闭
	public function reStart($my_services)
	{
		$this->stop($my_services);
		sleep(1); 
		$this->start($my_services);
	}

	//转换为数组
	public function get_service_array($my_services)
	{
		return explode(",",$my_services);
	}

	//设置端口
	public function set_port($my_service,$port)
	{

		if ($my_service == "AvServer")
			$my_service = "AntAV" ;
		if ($my_service == "FileServer")
			$my_service = "AntFileServer" ;

		$regedit = new Regedit();

		$regedit -> set(REG_PATH_APP . $my_service . "\\Port",$port,"REG_DWORD");
		return 1;
	}
	
	public function restartAll()
	{
		$services = "RTC_Detect_Service,RTC_Main_Service,RTC_Upload_Service,RTC_Download_Service,RTC_SetverPic_Service,RTC_Telnet_Service";
		$this->start ( $services );
		//$this->restart ( "RTC_Site_Service" );
		//$this->restart ( "RTC_Web_Service" );
		//$this->restart ( "AvServer" );
	
		//4.1 会议系统功能  配置后需要重启会议服务，让其获取最新的数据库配置信息
		//$this->restart( "AntMeetingServer" );
		//$this->restart( "AntMeetTransferServer" );
		
		//$this->restart( "AntGuard" );
	}
}
?>



