<?php  
 class keyword{ 
     public function getKeyword($referer){
         if(strpos($referer,"http://www.baidu.com")> -1 ){
             $keyword = $this->getbaidukeyword($referer);
         }else if(strpos($referer,"http://www.google.com")> -1 ){
             $keyword = $this->getgooglekeyword($referer);
         }else if(strpos($referer,"http://www.so.com")> -1 ){
             $keyword = $this->getsokeyword($referer);
         }else if(strpos($referer,"http://www.sogou.com")> -1 ){
             $keyword = $this->getsogoukeyword($referer);
         }
           
         return $keyword;
     }  
	 
     public function getChannel($referer){
         if(strpos($referer,"baidu.com")> -1 ){
             $keyword = 'Baidu';
         }else if(strpos($referer,"google.com")> -1 ){
             $keyword = 'Google';
         }else if(strpos($referer,"so.com")> -1 ){
             $keyword = '360';
         }else if(strpos($referer,"sogou.com")> -1 ){
             $keyword = 'Sogou';
	     }else if(strpos($referer,"bing.com")> -1 ){
             $keyword = 'Bing';
	     }else if(strpos($referer,"sm.cn")> -1 ){
             $keyword = 'Shenma';
	     }else if(strpos($referer,"toutiao.com")> -1 ){
             $keyword = 'Toutiao';
         }
           
         return $keyword;
     }      
     //由来路取得百度关键词
     private function getbaidukeyword($str){
         $s = strpos($str,'wd=');
         if($s>-1){
             $str = substr($str,$s+3);
             $e = strpos($str,'&');
             if($e>-1){
                 $str = substr($str,0,$e);
             }
             $str = rawurldecode($str);
         }
         return $str;
     }
     //获得谷歌关键词
     private function getgooglekeyword($str){
         $s = strpos($str,'&q=');
         if($s>-1){
             $str = substr($str,$s+3);
             $e = strpos($str,'&');
             if($e>-1){
                 $str = substr($str,0,$e);
             }
             $str = rawurldecode($str);
         }
         return $str;
     }
     //获得SOSO关键词
     private function getsokeyword($str){
         $s = strpos($str,'?w=');
         if($s>-1){
             $str = substr($str,$s+3);
             $e = strpos($str,'&');
             if($e>-1){
                 $str = substr($str,0,$e);
             }
             $str = rawurldecode($str);
         }else{
             $s = strpos($str,'&w=');
             if($s>-1){
                 $str = substr($str,$s+3);
                 $e = strpos($str,'&');
                 if($e>-1){
                     $str = substr($str,0,$e);
                 }
                 $str = rawurldecode($str);
             }
         }
         return $str;
     }
     //获得sogou关键词
     private function getsogoukeyword($str){
         $s = strpos($str,'query=');
         if($s>-1){
             $str = substr($str,$s+6);
             $e = strpos($str,'&');
             if($e>-1){
                 $str = substr($str,0,$e);
             }
             $str = rawurldecode($str);
         }
         return $str;
     }
 }
?>