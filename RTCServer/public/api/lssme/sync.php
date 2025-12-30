<?php
require_once ("../inc/fun.php");

class AntSync{

}

ob_clean ();
if (isset ( $_SERVER ['REQUEST_METHOD'] ) && $_SERVER ['REQUEST_METHOD'] == 'POST') {
    $soapServer = new SoapServer ( 'http://' . $_SERVER ['SERVER_NAME'] . ':' . $_SERVER ['SERVER_PORT'] . $_SERVER ['PHP_SELF'] . '?wsdl' );
    $soapServer->setClass ( "AntSync" );
    $soapServer->handle ();
} else {
    require_once (__ROOT__ . '/class/common/SoapDiscovery.class.php');
    $disco = new SoapDiscovery ( "AntSync", "AntSync" );
    header ( "Content-type: text/xml" );
    if (isset ( $_SERVER ['QUERY_STRING'] ) && strcasecmp ( $_SERVER ['QUERY_STRING'], 'wsdl' ) == 0) {
        ob_clean ();
        echo $disco->getWSDL ();
    } else {
        ob_clean ();
        echo $disco->getDiscovery ();
    }
}