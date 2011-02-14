<?php

require_once dirname(__FILE__).'/../plugins/configure.php';
require_once dirname(__FILE__).'/../license/license.php';

$type = $_GET['type'];

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) 
{
	ini_set('zlib.output_compression_level',9);
	ob_start("ob_gzhandler"); 
} else 
	ob_start(); 
	
require_once dirname(__FILE__).'/../libs/bTemplate.php';

$jstpl = new bTemplate();

$currentHost = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$hostString = substr($currentHost,0,strripos($currentHost,'/'));
$hostPath = substr($hostString,0,strripos($hostString,'/'));

echo $jstpl->fetch(dirname(__FILE__).'/dojo.js.tpl');

$jstpl->set('upath',$hostPath.'/lookup.php');

$jstpl->set('address1_field',ADDRESS1_FIELD);
$jstpl->set('city_field',CITY_FIELD);
$jstpl->set('state_field',STATE_FIELD);
$jstpl->set('zip_field',ZIP_FIELD);

echo $jstpl->fetch(dirname(__FILE__).'/rusps.js.tpl');

if ($type == 'test')
{
	$jstpl->set('upath2',$hostPath.'/precheck.php');
	$jstpl->set('key',urlencode(RAWSEO_APPHASH));
		
	echo $jstpl->fetch(dirname(__FILE__).'/precheck.js.tpl');
}

?>