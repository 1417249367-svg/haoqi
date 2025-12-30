<?php
/**
 * Created by PhpStorm.
 * User: zwz
 * Date: 15-4-13
 * Time: 下午6:00
 */
require_once ("../class/fun.php");
require_once (__ROOT__ . "/class/common/ValidateCode.class.php");
ob_clean();
$op = g("op");
switch($op)
{
    case "get_code":
        get_code();
        break;
    case "valid_code":
        valid_code();
        break;

}

function get_code(){
    $width = g("w",100);
    $height = g("h",35);
    $codeNum = g("n",4);

    $_vc = new ValidateCode($width,$height,$codeNum,"verifyCode");
    $_vc->buildAndExportImage();
}

function valid_code(){
    $code = strtoupper(g("verifycode"));
    $verifyCode = getValue("verifyCode");
    $printer = new Printer();
    recordLog($code);
    if(md5($code) == $verifyCode)
    {
        $printer->success();
    }
    else
    {
        $printer->fail ( "errnum:102005" );
    }
}

