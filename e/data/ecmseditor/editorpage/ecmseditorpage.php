<?php
require('../../../class/connect.php');
$editor=3;

//���ղ���
function EcmsEditor_PageGetVar($add){
	$r['showmod']=(int)$add['showmod'];
	$r['type']=(int)$add['type'];
	$r['classid']=(int)$add['classid'];
	$r['filepass']=(int)$add['filepass'];
	$r['infoid']=(int)$add['infoid'];
	$r['InstanceName']=ehtmlspecialchars($add['InstanceName']);
	$r['InstanceId']=intval(str_replace('cke_','',$add['InstanceId']));
	return $r;
}

$ecms_topager=array();
$doecmspage=ehtmlspecialchars($_GET['doecmspage']);
$ecms_topager=EcmsEditor_PageGetVar($_GET);

$pagefile='';
if($doecmspage=='TranImg')//�ϴ�ͼƬ
{
	$pagefile='TranImg.php';
}
elseif($doecmspage=='TranFile')//�ϴ�����
{
	$pagefile='TranFile.php';
}
elseif($doecmspage=='TranFlash')//�ϴ�FLASH
{
	$pagefile='TranFlash.php';
}
elseif($doecmspage=='TranMedia')//�ϴ���Ƶ
{
	$pagefile='TranMedia.php';
}
else
{
	exit();
}
@include($pagefile);
?>