<?php

require_once ("../inc/fun.php");
$op = g("op");

switch ($op){
    case "get_mail_info":
        get_mail_info();
        break;
    case "redirect_mail":
        redirect_mail();
        break;
    case "get_mail_count":
        get_mail_count();
        break;
    default:
        die();
        break;
}

function get_mail_count(){
    ob_clean();
    $loginName = removeDomain(g("loginname",""));
    $result = send_http_request("");
    print $result;
}


function get_mail_info()
{
    ob_clean();
    $loginname = removeDomain(g("loginname",""));
    $password = g("password","");


    $url = "http://" . $_SERVER["SERVER_ADDR"] . ":" . $_SERVER["SERVER_PORT"]
                     . "/api/mail/coremail.html?op=redirect_mail"
                     . "&loginname=" . $loginname
                     . "&password=" . $password;
    /*
    if($loginname != "" && $password !="")
    {
        $data = array(
            "loginname" => $loginname,
            "email" => $loginname.MAIL_DOMAIN,
            "popserver" => MAIL_POP3_SERVER,
            "popport" => MAIL_POP3_PORT,
            "usessl" => MAIL_USER_SSL,
            "url" => $url
        );

        print (Response::result(MAIL_OP_SUCCESS,$data));
    }
    else
    {
        print (Response::result(MAIL_PARAM_ERROR));
    }
    */



    $doc_xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $doc_xml .= '<AntMail>';
    $doc_xml .= '<Account EMail="邮箱">';
    $doc_xml .= '<DisplayName>';
    $doc_xml .= '<![CDATA[邮箱]]>';
    $doc_xml .= '</DisplayName>';
    $doc_xml .= '<Password>';
    $doc_xml .= '<![CDATA[[EnPassword]]]>';
    $doc_xml .= '</Password>';
    $doc_xml .= '<DataFolder>';
    $doc_xml .= '<![CDATA[[DataFolder]]]>';
    $doc_xml .= '</DataFolder>';
    $doc_xml .= '<URL>';
    $doc_xml .= '<![CDATA[' . $url . ']]>';
    $doc_xml .= '</URL>';
    $doc_xml .= '<IncomingServer UseSSL="' . MAIL_USER_SSL . '" Port="' . MAIL_POP3_PORT . '" Type="1">';
    $doc_xml .= '<ServerName>' . MAIL_POP3_SERVER . '</ServerName>';
    $doc_xml .= '<UserName>' . $loginname . '</UserName>';
    $doc_xml .= '<Password>[EnPassword]</Password>';
    $doc_xml .= '</IncomingServer>';
    $doc_xml .= '</Account>';
    $doc_xml .= '</AntMail>';
    print($doc_xml);

}

function redirect_mail()
{

    $loginname = removeDomain(g("loginname",""));
    $password = DBPwdDecrypt(g("password",""));
    $email = $loginname . MAIL_DOMAIN;

    $xml_result = file_get_contents("" . $email);


    $xml_dom = new DOMDocument();
    $xml_dom ->loadXML($xml_result);

    $node = $xml_dom->getElementsByTagName("code");
    $code = $node->item(0)->nodeValue;
    if($code == "0")
    {
        $node = $xml_dom->getElementsByTagName("result");
        $sid = $node->item(0)->nodeValue;
    }
    else
    {
        $sid = "";
    }

    header ( "Location:" . MAIL_REDIRECT . "?" . $sid );
}