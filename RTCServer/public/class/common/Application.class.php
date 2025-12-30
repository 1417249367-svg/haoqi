<?php
/**
 * Application

 * @date    20150515
 */

class Application
{ 
	//保存共享变量的文件
	public $save_file    = "";
	public $app_data = array();

 	function __construct()  
 	{   
		global $runtime_dir;
		mkdirs($runtime_dir . "/sessions");
		$this -> save_file = $runtime_dir . "/sessions/application.txt";
 	} 
	
 	/**   
	* method:设置列表  
	* param:$data array("id"=>1,"name"=>"")
	*/  
 	function setData($data)  
 	{   
		//设置值 
		foreach($data as $var_name=>$var_value)
			$this -> app_data[$var_name] = $var_value ;

		//保存值
		$this -> __writeToFile() ;
	 
	} 	 
	
	/**  
	method:取得列到
	return array("id"=>1,"name"=>"")
	*/ 
	function getData() 
	{     
		if (!is_file($this->save_file))         
			$this->__writeToFile();  
		
		//从文件内容生成所有对象   
		$this -> app_data = @unserialize(@file_get_contents($this->save_file)); 
		return $this -> app_data ;
	} 
 
 	/**   
	method:设置值   
	param:$var_name 要加入到全局变量的变量名   
	param:$var_value 变量的值   
	*/  
 	function setValue($var_name,$var_value)  
 	{   
		$this -> app_data[$var_name] = $var_value ;
		$this -> __writeToFile() ;
	} 	
		  
 	/**   
	method:得到值   
	param:$var_name 要加入到全局变量的变量名     
	*/  
 	function getValue($var_name,$default_value = "")  
 	{   
		if (count($this->app_data) == 0)
			$this -> app_data = $this -> getData();
			
		if (array_key_exists($var_name, $this -> app_data)) 
			$var_value = $this -> app_data[$var_name] ;
		else
			$var_value = $default_value ;
		return $var_value ;
	} 	
	
	/**  
	* 写序列化后的数据到文件  
	* @scope private  
	*/ 
	function __writeToFile() 
	{  
		$content = @serialize($this->app_data) ;
		$fp = @fopen($this->save_file,"w");  
		@fwrite($fp,$content);  
		@fclose($fp); 
	}
}