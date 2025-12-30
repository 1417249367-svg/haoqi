<?php
/**
 * 注册表操作
 * @author  jincun
 * @date    20140826
 */

class Regedit
{
	public $shell  ;
	function __construct()
	{
		$this -> shell =  new COM("WScript.Shell") or die("建立WScript.Shell出错！") ;
	}

	//$regtype  REG_SZ  REG_BINARY  REG_DWORD
    function  set($regkey,$regval,$regtype = "REG_SZ")
    {
		$regval = iconv_str($regval,"UTF-8","GBK");
		//println($regkey . "-----------------------" . $regval);
		try
		{
			$this -> shell -> RegWrite($regkey, $regval, $regtype);
			return 1 ;
		}
		catch(Exception $e)
		{
			return 0;
		}

	}
    
	/**
	 * 得到注册表值
	 * @param unknown $regkey
	 * @param string $defaultValue
	 * @return string
	 */
    function  get($regkey,$defaultValue = "")
    {
		try
		{
			$value = $this -> shell -> RegRead($regkey);
			$value = iconv_str($value);
			return $value;
		}
		catch(Exception $e)
		{
			//die($e->getMessage());
			return $defaultValue ;
		}
	}
    
	/**
	 * 设置路径
	 * @param unknown $path
	 * @param unknown $keys
	 * @param unknown $values
	 * @param unknown $types
	 */
	function set_batch($path,$keys,$values,$types)
	{
		for ( $i = 0; $i < count($keys); $i += 1) {
			if ($keys[$i])
			{
				$key = $path . $keys[$i] ;
				$value = $values[$i] ;
				$type = "REG_SZ";
				if (count($types)>= $i)
				{
					if ($types[$i] == "REG_DWORD")
						$type = "REG_DWORD" ;
				}

				if ($keys[$i] == "DBPassword")
					$value = ascom_encrypt($value);
					
				println($key . ":" . $value);
				$this -> set($key,$value,$type);
			}
		}
	}
}
?>