<?php

/**
 * server.inc.php
 * @author  zwz
 * @date    2014-10-11 下午9:55:19
 */
ob_clean ();
if (isset ( $_SERVER ['REQUEST_METHOD'] ) && $_SERVER ['REQUEST_METHOD'] == 'POST') {
	$soapServer = new SoapServer ( 'http://' . $_SERVER ['SERVER_NAME'] . ':' . $_SERVER ['SERVER_PORT'] . $_SERVER ['PHP_SELF'] . '?wsdl' );
	$soapServer->setClass ( $serviceName );
	$soapServer->handle ();
} else {
	require_once (__ROOT__ . '/class/common/SoapDiscovery.class.php');
	$disco = new SoapDiscovery ( $serviceName, $serviceName );
	header ( "Content-type: text/xml" );
	if (isset ( $_SERVER ['QUERY_STRING'] ) && strcasecmp ( $_SERVER ['QUERY_STRING'], 'wsdl' ) == 0) {
		ob_clean ();
		echo $disco->getWSDL ();
	} else {
		ob_clean ();
		echo $disco->getDiscovery ();
	}
}
