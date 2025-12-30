<?php
class WXClass
{
//    public $appid  = 'wxfe482f2209cc2aa3';
//    public $sercet = '835229d871420304c66cbe6881d86f3a';
//    public $token  = 'qiyeim';

    public function getList()
    {
        $redis = new RedisClass();

        $data = $redis->get();

        exit(json_encode($data));
    }

    public function getSubscribemsg($openid)
    {
		//$url = "https://mp.weixin.qq.com/mp/subscribemsg?action=get_confirm&appid=".WECHAT_APPID."&scene=888&template_id=".WECHAT_SUBSCRIBE_ID."&redirect_url=".phpescape(getRootPath().$_SERVER['PHP_SELF']."?act=SendSubscribeMessage1&openid=".$openid."&redirect_uri=".g("redirect_uri"))."&reserved=qiyeim#wechat_redirect";
		$url = "https://mp.weixin.qq.com/mp/subscribemsg?action=get_confirm&appid=".WECHAT_APPID."&scene=888&template_id=".WECHAT_SUBSCRIBE_ID."&redirect_url=".phpescape(getRootPath().$_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],"?")?'&':'?')."act=SendSubscribeMessage1&openid=".$openid)."&reserved=qiyeim#wechat_redirect";
//		echo getRootPath().$_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],"?")?'&':'?')."act=SendSubscribeMessage1&openid=".$openid;
//		exit();
		header("location:" . $url);
		exit;
    }

    public function getSubscribemsg1()
    {
		$url = "https://mp.weixin.qq.com/mp/subscribemsg?action=get_confirm&appid=".WECHAT_APPID."&scene=1000&template_id=".WECHAT_SUBSCRIBE_ID."&redirect_url=".phpescape(getRootPath().$_SERVER['REQUEST_URI'])."&reserved=qiyeim#wechat_redirect";
		header("location:" . $url);
		exit;
    }
	
    public function sendSubscribemsg($myid,$youid,$usertext)
    {
		$accessToken = $this->getAccessToken();
		$reader = new MsgReader();
		if(WECHAT_SUBSCRIBE){
			//if(!WECHAT_SUBSCRIBE_ID2) return false;
			 $url = "https://api.weixin.qq.com/cgi-bin/message/subscribe/bizsend?access_token=".$accessToken;
			$postData=array( 
				'touser'=>strval($youid), //要发送给用户的openId
				'template_id'=>WECHAT_SUBSCRIBE_ID2,//改成自己的模板id，在微信接口权限里一次性订阅消息的查看模板id
				//'url'=>WECHAT_CUSTOMER_SERVICE_LINK.(strpos(WECHAT_CUSTOMER_SERVICE_LINK,"?")?'&':'?').'userid='.$youid, //自己网站链接url 
				'page'=>RTC_SERVER_AGENT.'/kefu.html?username=' . $myid . '&userid='.$youid,
				'data'    => array (
					'name1'    => array (
						'value' => "消息提醒"
					),
					'time2'    => array (
						'value' => getNowTime()
					),
					'thing3'    => array (
						'value' => "客服有新的消息,快去看看吧!"
					)
				)
			);
		}else{
			 //if(!WECHAT_SUBSCRIBE_ID) return false;
			 $url = "https://api.weixin.qq.com/cgi-bin/message/template/subscribe?access_token=".$accessToken;
			  $postData=array( 
				  'touser'=>strval($youid), //要发送给用户的openId
				  'template_id'=>WECHAT_SUBSCRIBE_ID,//改成自己的模板id，在微信接口权限里一次性订阅消息的查看模板id
				  //'url'=>WECHAT_CUSTOMER_SERVICE_LINK.(strpos(WECHAT_CUSTOMER_SERVICE_LINK,"?")?'&':'?').'userid='.$youid, //自己网站链接url 
				  'url'=>RTC_SERVER_AGENT.'/kefu.html?username=' . $myid . '&userid='.$youid,
				  'scene'=>"888",
				  'title'=>"您有一条新的信息",  //标题
				  'data'=>array(
					  'content'=>array(
						  'value' => "客服有新的消息,快去看看吧!",
						  'color'=>"#173177"
					  )
				  )
			  );
		}

        $res = $this->https_request($url, urldecode(json_encode($postData)));

        $resArr = json_decode($res, true);
		
//					 echo var_dump($postData);
//					 echo var_dump($res);
//			 exit; 

        if (isset($resArr['errcode']) && $resArr['errcode'] == 0) {
            $this->logger("\r\n" . '发送成功');

            return true;
        }

        $this->logger("\r\n" . $res);
    }

    public function sendCustomerMsg($myid,$youid,$usertext)
    {
		$accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accessToken;
		//$url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token=".$accessToken;

        // 不指定某个客服回复
		$reader = new MsgReader();
//		$postData = array(
//            'touser'  => $youid,
//            'template_id' => WECHAT_MOBAN_ID,
//			//'url' => WECHAT_CUSTOMER_SERVICE_LINK.(strpos(WECHAT_CUSTOMER_SERVICE_LINK,"?")?'&':'?').'userid='.$youid,
//			'url'=>RTC_SERVER_AGENT.'/kefu.html?username=' . $myid . '&userid='.$youid,
//            'data'    => array (
//				'first'    => array (
//					'value' => "您有一条新的信息!",
//					'color' => "#173177"
//				),
//				'keyword1'    => array (
//					'value' => "消息提醒",
//					'color' => "#173177"
//				),
//				'keyword2'    => array (
//					'value' => getNowTime(),
//					'color' => "#173177"
//				),
//				'keyword3'    => array (
//					'value' => "客服有新的消息,快去看看吧!",
//					'color' => "#173177"
//				),
//				'remark'    => array (
//					'value' => "客服有新的消息,快去看看吧!",
//					'color' => "#173177"
//				)
//            )
//        );
		
		$postData = array(
            'touser'  => $youid,
            'template_id' => WECHAT_MOBAN_ID,
			//'url' => WECHAT_CUSTOMER_SERVICE_LINK.(strpos(WECHAT_CUSTOMER_SERVICE_LINK,"?")?'&':'?').'userid='.$youid,
			'url'=>RTC_SERVER_AGENT.'/kefu.html?username=' . $myid . '&userid='.$youid.'&moban=1',
            'data'    => array (
				'first'    => array (
					'value' => "您有一条新的信息!",
					'color' => "#173177"
				),
				'keyword1'    => array (
					'value' => $myid,
					'color' => "#173177"
				),
				'keyword2'    => array (
					'value' => getNowTime(),
					'color' => "#173177"
				),
				'keyword3'    => array (
					'value' => $reader -> decodeUserText(g ( "usertext" )),
					'color' => "#173177"
				),
				'remark'    => array (
					'value' => "客服有新的消息,快去看看吧!",
					'color' => "#173177"
				)
            )
        );
		
//			 echo var_dump($postData);
//			 exit; 

        $res = $this->postHttp($url, json_encode($postData));

        $resArr = json_decode($res, true);

        if (isset($resArr['errcode']) && $resArr['errcode'] == 0) {
            $this->logger("\r\n" . '发送成功');

            return true;
        }

        $this->logger("\r\n" . $res);
    }

    public function getAccessToken()
    {
        session_start(); 
		if (isset($_SESSION['access_token']) && time() < $_SESSION['expires_time']) {
            return $_SESSION['access_token'];
        } else {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".WECHAT_APPID."&secret=".WECHAT_SERCET;

            $res = $this->getHttp($url);

            $resArr = json_decode($res, true);

            if (isset($resArr['access_token'])) {
                $_SESSION['access_token'] = $resArr['access_token'];
                $_SESSION['expires_time'] = time() + $resArr['expires_in'];

                return $resArr['access_token'];
            }
        }
    }
	
    public function Get_Code(){  //获取code{
		$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		$code_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".WECHAT_APPID."&redirect_uri=".phpescape($http_type.WECHAT_DOMAIN.$_SERVER['REQUEST_URI'])."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
//		echo $code_url;
//		exit();
		header("location:" . $code_url);
		exit;
    }

    /**

    *  通过获取到的code来获取access_token和openid

    *

    */

    public function GetAccess_Token($code){
		$get_access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".WECHAT_APPID."&secret=".WECHAT_SERCET."&code=".$code."&grant_type=authorization_code";
		$res = $this->http_url($get_access_token_url);
		return json_decode($res, true);
	}

    /**

     * 检查access_token是否有效

     *

    */

    public function CkeckAccessToken($access_token, $openid){
		$check_url = "https://api.weixin.qq.com/sns/auth?access_token=".$access_token."&openid=".$openid;
		$res = $this->http_url($check_url);
		$result = json_decode($res, true);
		if (isset($result['errmsg']) && $result['errmsg'] == 1) {
		   return 1;       //access_token有效
		 } else {
		   return 0;       //access_token无效
		 }
    }
    /**

     * 如果获取到的access_token无效，通过refresh_token来刷新access_token

     */

    public function GetRefresh_Token($refresh_token){
        $get_refresh_token_url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".WECHAT_APPID."&grant_type=refresh_token&refresh_token=".$refresh_token;
        $res = $this->http_url($get_refresh_token_url);
        return json_decode($res, true);
     }

    /**

     * 获取用户基本信息

     *

     */

    public function Get_User_Info($access_token, $openid){
        $get_user_info = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->http_url($get_user_info);
        return json_decode($res, true);
	}
	
    public function Get_User_Subscribe($openid){
		$accessToken = $this->getAccessToken();
        $get_user_info = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$accessToken."&openid=".$openid."&lang=zh_CN";
        $res = $this->http_url($get_user_info);
        return json_decode($res, true);
	}

    //自定义请求接口函数，$data为空时发起get请求，$data有值时发起post请求
	public function https_request($url,$data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if (!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}
	
	public function http_url($url,$data=null){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		if(!empty($data)){   
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		}
		$res = curl_exec($ch);
		if(curl_errno($ch)){
			echo "error:".curl_error($ch);
			exit;
		}
		curl_close($ch);
		return $res;
	}

    public function getHttp($url = '')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    public function postHttp($url, $data = '')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    public function logger($logContent)
    {
        $max_size = 1000000;
        $log_filename = "log.xml";

        if (file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)) {
            unlink($log_filename);
        }

        file_put_contents($log_filename, date('Y-m-d H:i:s') . "： " . $logContent . "\r\n", FILE_APPEND);
    }
}
?>