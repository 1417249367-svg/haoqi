<?php
//这个类似用来获取访客信息的
//方便统计
class visitorInfo
{
    //获取访客ip
    public function getIp()
    {
        $ip=false;
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
            for ($i = 0; $i < count($ips); $i++) {
                if (!eregi ("^(10│172.16│192.168).", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }
 
    //根据ip获取城市、网络运营商等信息
    public function findCityByIp($ip){
	//拼接传递的参数
		$getData = array(
			'query'    =>    $ip,
			'resource_id'    =>    '6006',
			'oe'    =>    'UTF-8',
			'format'    =>    'json'
		);
		$getData = http_build_query($getData);
		$opts = array(
		  'http'=>array(
			'method'=>"POST",
			'header'=>"Content-type:application/x-www-form-urlencoded\r\n" .
					  "Content-length:". strlen($getData) ."\r\n",
					  "content"=>$getData,
		  )
		);
		//获取Ip所属位置
		$context = stream_context_create($opts);
		$fp = file_get_contents('http://opendata.baidu.com/api.php', false, $context);
		$data=json_decode($fp, true);
        return $data["data"][0]["location"];
    }
 
   //获取用户浏览器类型
    public function getBrowser(){
        $agent=$_SERVER["HTTP_USER_AGENT"];
		$type=get_device_type();
        if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
            return "ie";
        else if(strpos($agent,'Firefox')!==false)
            return "firefox";
        else if(strpos($agent,'Chrome')!==false)
            return "chrome";
        else if(strpos($agent,'Opera')!==false)
            return 'opera';
        else if(strpos(strtolower($agent),'micromessenger')!==false)
            return 'weixin';
        else if(strpos(strtolower($agent),'miniprogram')!==false)
            return 'miniprogram';
        else if(strpos(strtolower($agent),'qq')!==false)
            return 'qq';
        else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
            return 'safari';
        else if((strpos(strtolower($agent),'micromessenger')==false)&&strpos(strtolower($agent),'version')!==false&&$type=='android')
            return 'app';
        else if((strpos(strtolower($agent),'micromessenger')==false)&&strpos(strtolower($agent),'version')==false&&$type=='ios')
            return 'app';
        else
            return 'unknown';
    }
 
    //获取网站来源
    public function getFromPage(){
        return $_SERVER['HTTP_REFERER'];
    }
 
}
?>



