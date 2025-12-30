<?php
class Printer
{

	public $format  ; // json  xml

	function __construct($format = "json")
	{
		$this -> format = $format ;
	}

	function array2str($arr,$sp_item){
		$i = 0;
		$str = "";
		foreach($arr as $row){
			if($i ==0)
				$str = $row[0];
			else
				$str = $str . $sp_item  . $row[0];
			$i++;
		}
		return $str ;
	}

    /**
     * out print
     */
	function out_str($str)
	{
		ob_clean();
		if ($this -> format == "xml")
			header("Content-Type:text/xml");
		else header("Content-type: text/html; charset=utf-8"); 
		recordLog($str);
		print $str ;
		die(); // response end
	}

	function out_arr($arr)
	{
		$str = $this -> parseArray($arr);
		$this -> out_str($str) ;
	}

	// $double_column = 1  数据库查询的结果有index field两个列
	function out_list($data,$count = -1,$double_column = 1)
	{
		$result = $this -> parseList($data,$double_column);
		if ($count == -1)
			$count = count($data);

		if ($this -> format == "json")
			$result = "{\"rows\":[" . $result . "],\"recordcount\":" . $count . "}" ;
		else
			$result = "<rows>" . $result . "</rows><recordcount>" . $count . "</recordcount>";

		$this -> out_str($result) ;
	}
	
	function out_list1($data1,$data2,$data3,$count = -1,$double_column = 1)
	{
		$result1 = $this -> parseList($data1,$double_column);
		$result2 = $this -> parseList($data2,$double_column);
		$result3 = $this -> parseList($data3,$double_column);
		if ($count == -1)
			$count = count($data1);

		if ($this -> format == "json")
			$result = "{\"rows\":[" . $result1 . "],\"rows2\":[" . $result2 . "],\"rows3\":[" . $result3 . "],\"recordcount\":" . $count . "}" ;
		else
			$result = "<rows>" . $result . "</rows><recordcount>" . $count . "</recordcount>";

		$this -> out_str($result) ;
	}
	
	function out_list2($data1,$data2,$data3,$data4,$count = -1,$double_column = 1)
	{
		$result1 = $this -> parseList($data1,$double_column);
		$result2 = $this -> parseList($data2,$double_column);
		$result3 = $this -> parseList($data3,$double_column);
		$result4 = $this -> parseList($data4,$double_column);
		if ($count == -1)
			$count = count($data1);

		if ($this -> format == "json")
			$result = "{\"rows\":[" . $result1 . "],\"rows2\":[" . $result2 . "],\"rows3\":[" . $result3 . "],\"rows4\":[" . $result4 . "],\"recordcount\":" . $count . "}" ;
		else
			$result = "<rows>" . $result . "</rows><recordcount>" . $count . "</recordcount>";

		$this -> out_str($result) ;
	}
	
	function out_list4($data1,$data2,$data3,$data4,$data5,$count = -1,$double_column = 1)
	{
		$result1 = $this -> parseList($data1,$double_column);
		$result2 = $this -> parseList($data2,$double_column);
		$result3 = $this -> parseList($data3,$double_column);
		$result4 = $this -> parseList($data4,$double_column);
		$result5 = $this -> parseList($data5,$double_column);
		if ($count == -1)
			$count = count($data1);

		if ($this -> format == "json")
			$result = "{\"rows\":[" . $result1 . "],\"rows2\":[" . $result2 . "],\"rows3\":[" . $result3 . "],\"rows4\":[" . $result4 . "],\"rows5\":[" . $result5 . "],\"recordcount\":" . $count . "}" ;
		else
			$result = "<rows>" . $result . "</rows><recordcount>" . $count . "</recordcount>";

		$this -> out_str($result) ;
	}
	
	function out_list3($data1,$data2,$data3,$index,$count = -1,$double_column = 1)
	{
		$result1 = $this -> parseList($data1,$double_column);
		$result2 = $this -> parseList($data2,$double_column);
		$result3 = $this -> parseList($data3,$double_column);
		if ($count == -1)
			$count = count($data1);

		if ($this -> format == "json")
			$result = "{\"rows\":[" . $result1 . "],\"rows2\":[" . $result2 . "],\"rows3\":[" . $result3 . "],\"index\":" . $index . ",\"recordcount\":" . $count . "}" ;
		else
			$result = "<rows>" . $result . "</rows><recordcount>" . $count . "</recordcount>";

		$this -> out_str($result) ;
	}

	function out_array($data,$double_column = 1)
	{
		$result = $this -> parseList($data,$double_column);

		$this -> out_str($result) ;
	}

	function out_detail($row,$append = "",$double_column = 1)
	{
		$array = $row ;

		//移掉index
		if ($double_column)
			$array = $this -> removeDoubleColumn($row);

		$result = $this -> getResult($array,$append) ;

		$this -> out_str($result) ;
	}

    /**
     * out print
     */
	function out_xml($xml)
	{
		ob_clean();
		header("Content-Type:text/xml");
		print $xml;
	}

    /**
     * out print
     * $status 0 fail 1 success
	 * $str msg   or    name1:value1,name2:value2
	 * 注意 int 0 = ""
     */
	function out($status = 0,$str = "")
	{
		$result = "status:" . $status  ;

		if ($str)
		{
			if (strpos($str,":") == false)
				$str = "msg:" . $str ;
			$result .= "," . $str ;
		}
		$result = $this -> getResult($this -> str2array(",",":",$result));

		$this -> out_str($result) ;
	}

	function out_msg($status = 0,$str = "")
	{
		$result = "{\"status\":" . $status . ",\"msg\":\"" . $str . "\"}" ;
		$this -> out_str($result) ;
	}

	function success($str = "")
	{
		$this -> out(1,$str) ;
	}

	function fail($str = "")
	{
		$this -> out(0,$str) ;
	}




    /**
     * 将Table转换成JSON
	 * $double_column  0 只有关键字  1关键字加INDEX (oci_fetch_array-> OCI_BOTH)
     * @return string
     */
	function parseList($arraylist,$double_column = 0)
	{
		$result = "" ;
		foreach($arraylist as $row)
		{
			$result_row = ($this -> parseRow($row,$double_column)) ;

			if ($this -> format == "json")
				$result .= ($result == ""?"":",") . $result_row;
			else
				$result .= "<row>" . $result_row . "</row>";
		}

		return $result ;
	}


    /**
     * 将某行转换成JSON
	 * $double_column  0 只有关键字  1关键字加INDEX (oci_fetch_array-> OCI_BOTH)
     * @return string
     */
	function parseRow($array,$double_column = 0 )
	{

		if ($double_column)
			$array = $this -> removeDoubleColumn($array);

		$str = $this -> getResult($array) ;

		return $str ;
	}

    /**
     * 将某行转换成JSON
	 * $mode  0 只有关键字  1关键字加INDEX (oci_fetch_array-> OCI_BOTH)
     * @return string
     */
	function parseArray($arr)
	{
		return $this -> getResult($arr) ;
	}

	function removeDoubleColumn($array)
	{
		$array_new = array();
		$i = 0 ;
		foreach($array as $key=>$value){
			if ($i%2)
				$array_new[$key] = $value ;
			$i += 1 ;
		}
		return $array_new ;
	}



	// a=1,b=2   [a]=>1,[b]=>2
	function str2array($sp_item,$sp_attr,$str)
	{
		$arr_item = explode($sp_item,$str);
		$arr = array();
		foreach($arr_item as $item)
		{
			$arr_attr = explode($sp_attr,$item);
			$arr[$arr_attr[0]] = $arr_attr[1];
		}
		return $arr ;
	}


	function formatValue($value)
	{
		$s = str_replace(" ","",$value);

		if (strpos($s,"月-")>0)
			return $this -> mdate($s);

		return $value ;
	}

	function mdate($s)
	{
		preg_match('/(?<d>\d{2})-(?<m>\d{1,2})月\s*-(?<y>\d{2})/',$s,$m);
		return date('Y-m-d',strtotime($m['y'].'-'.$m['m'].'-'.$m['d']));
	}

    function fliterByJson($str)
    {
		//20150119 将 \r\n\t...放到前面，以免替换不了
		$str = str_replace("\r\n","\\n",$str);
		$str = str_replace("\n","\\n",$str);
		$str = str_replace("\t","",$str);
		$str = str_replace("\\","\\\\",$str);
		$str = str_replace("\"","\\\"",$str);
        return $str ;

    }

	function getColumnValues($rows,$fieldName,$sp = ",")
	{
		$str = "" ;
		foreach($rows as $row)
		{
			if ($str != "")
				$str .= $sp ;
			$str .= $row[$fieldName] ;
		}
		return $str ;
	}


	function union($str1,$str2)
	{
		if ($this -> format == "xml")
			return $str1 . $str2 ;

		if (($str1 == "") && ($str2 == ""))
			return "" ;
		else if ($str1 == "")
			return $str2 ;
		else if ($str2 == "")
			return $str1 ;
		else
			return $str1 . "," . $str2 ;
	}




	function getResult($array,$append = "")
	{

		$result = "" ;
		foreach($array as $key=>$value)
		{
			if ($this -> format == "json")
				$result .= ($result==""?"":",") . $this -> getItem($key,$value) ;
			else
				$result .= $this -> getItem($key,$value);
		}

		if ($append)
			$result = $this -> union($result,$append);

		if ($this -> format == "json")
			$result = "{" . $result . "}" ;

		return $result ;
	}

	function getItem($key,$value)
	{
		$key = strtolower($key) ;
		$value = $this -> formatValue($value) ;
		$value = $this -> fliterByJson($value) ;

		$result = "" ;
		if ($this -> format == "json")
		{
			//if (! is_numeric($value))
			if ($key != "status")
				$value = "\"" . $value . "\"" ;
			$result .=  "\"" . $key . "\":" . $value . "" ;
		}
		else
		{
			$result .= "<" . $key . ">" . $value . "<" . $key . "/>" ;
		}


		return $result ;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//用来下载
	//jc 2014-12-9
	////////////////////////////////////////////////////////////////////////////////////////////////
	function out_stream($file_name,$file_path)
	{
//echo $file_path.$file_name;
//exit();
		if (! file_exists($file_path.$file_name))
			$this -> out_str("<script type='text/javascript'>alert('".get_lang("file_error")."');</script>");

		file_read_stream($file_path,"application/octet-stream",$file_name);

	}
	
	function out_stream1($file_name,$file_path,$typepath)
	{
		if (! file_exists($file_path.$file_name))
			$this -> out_str("<script type='text/javascript'>alert('".get_lang("file_error")."');</script>");

		file_read_stream1($file_path,"application/octet-stream",$file_name,$typepath);

	}
	
	function out_stream2($file_name,$file_path,$typepath)
	{
		if (! file_exists($file_path.$file_name))
			$this -> out_str("<script type='text/javascript'>alert('".get_lang("file_error")."');</script>");

		file_read_stream2($file_path,"application/octet-stream",$file_name,$typepath);

	}
	
	function out_pdf($file_name,$file_path)
	{
//echo $file_path.$file_name;
//exit();
		if (! file_exists($file_path.$file_name))
			$this -> out_str("<script type='text/javascript'>alert('".get_lang("file_error")."');</script>");

		file_read_stream($file_path,"application/pdf",$file_name);

	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//查看图片
	//jc 2014-12-9
	////////////////////////////////////////////////////////////////////////////////////////////////
	function out_img($file_path)
	{

		if (! file_exists($file_path))
			$file_path = __ROOT__ . "/static/img/img_delete.png" ;

		$file_type = substr($file_path,strrpos($file_path,".")+1) ;

		file_read_stream($file_path,"image/" . $file_type);

	}
	
	function out_mimg($file_path)
	{

		$file_type = substr($file_path,strrpos($file_path,".")+1) ;

		file_read_stream($file_path,"image/" . $file_type);

	}

	function out_array2($arr,$double_column = 0)
	{
		ob_clean();
		if($double_column)
			$arr = $this->removeDoubleColumn($arr);
		if($this -> format == "xml")
		{
			header("Content-type: text/xml; charset=utf-8");
			$result = "<?xml version='1.0' encoding='utf-8' ?>\n";
			$result .= "<result>\n";
			$result .= $this->xmlToEncode($arr);
			$result .= "</result>";
		}
		else
			$result = json_encode($arr);
		print $result;
	}

	public function xmlToEncode($data) {
		$xml = $attr = "";
		foreach ( $data as $key => $value ) {
			if (is_numeric ( $key )) {
				$key = "row";
			}
			$xml .= "<{$key}>";
			$xml .= is_array ( $value ) ? $this->xmlToEncode ( $value ) : "<![CDATA[" . $value . "]]>";
			$xml .= "</{$key}>\n";
		}
		return $xml;
	}

}
?>