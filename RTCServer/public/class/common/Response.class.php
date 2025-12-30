<?php

/**
 * Response.class.php  格式化接口返回值
 * @author  zwz
 * @date    2014.09.27
 */
class Response {
	function __construct() {
	}
	/**
	 * 按综合方式输出通信数据
	 *
	 * @param integer $code
	 *        	状态码
	 * @param array $data
	 *        	数据
	 * @param string $type
	 *        	数据类型
	 * @return string
	 */
	public static function result($code, $data = array()) {
		if (! is_numeric ( $code )) {
			return '';
		}

		if (strtoupper ( RESULT_TYPE ) == 'JSON') {
			return self::json ( $code , $data );
		} elseif (strtoupper ( RESULT_TYPE ) == 'ARRAY') {
			return "";
		} elseif (strtoupper ( RESULT_TYPE ) == 'XML') {
			return self::xmlEncode ( $code , $data );
		} else {
			return "";
		}
	}

	/**
	 * 按json方式输出通信数据
	 *
	 * @param integer $code
	 *        	状态码
	 * @param string $message
	 *        	提示信息
	 * @param array $data
	 *        	数据
	 * @return string
	 */
	public static function json($code, $data = array()) {
		if (! is_numeric ( $code )) {
			return '';
		}

		if ($code > 0) {
			$result ['code'] = $code;
			$result['message'] = getErrMessage($code);
		}

		if (count ( $data ) > 0) {
			$result ['data'] = self::format_array($data);
		}

		return json_encode ( $result,JSON_UNESCAPED_UNICODE );
	}

	/**
	 * 按xml方式输出通信数据
	 *
	 * @param integer $code
	 *        	状态码
	 * @param string $message
	 *        	提示信息
	 * @param array $data
	 *        	数据
	 * @return string
	 */
	public static function xmlEncode($code, $data = array()) {
		if (! is_numeric ( $code )) {
			return '';
		}

		if ($code != 0) {
			$result ['code'] = $code;
		}

		if (count ( $data ) > 0) {
			$result ['data'] = $data;
		}

		header ( "Content-Type:text/xml" );
		$xml = "<?xml version='1.0' encoding='utf-8' ?>\n";
		$xml .= "<root>\n";

		$xml .= self::xmlToEncode ( $result );

		$xml .= "</root>";


		return $xml;
	}
	public static function xmlToEncode($data) {
		$xml = $attr = "";

		foreach ( $data as $key => $value ) {
			if (is_numeric ( $key )) {
				$key = "item";
			}
			$xml .= "<{$key}>";
			$xml .= is_array ( $value ) ? self::xmlToEncode ( $value ) : $value;
			$xml .= "</{$key}>\n";
			if($key=="code"){
				$xml .= "<message>" . getErrMessage($value) . "</message>\n";
			}
		}
		return $xml;
	}

	public static function format_array($arr){
		foreach ( $arr as $key => $value ) {

			if(is_array ( $value )){
				$arr[$key] = self::format_array($value);
			}
			else{
				if($key == "code")
					$arr["message"] = getErrMessage($value) ;
			}
		}
		return $arr;
	}
}