<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

$ztid=(int)$_GET['ztid'];
if(empty($ztid))
{
	$ztid=(int)$_POST['ztid'];
}
//��֤Ȩ��
//CheckLevel($logininid,$loginin,$classid,"zt");
$returnandlevel=CheckAndUsernamesLevel('dozt',$ztid,$logininid,$loginin,$loginlevel);

//ר��
if(!$ztid)
{
	printerror('ErrorUrl','');
}
$ztr=$empire->fetch1("select ztid,ztname,ztpath from {$dbtbpre}enewszt where ztid='$ztid'");
if(!$ztr['ztid'])
{
	printerror('ErrorUrl','');
}

$filepath_r=array();
$filepath_r['actionurl']='SpecialPathfile.php';
$filepathr['filepath']=$ztr['ztpath'].'/uploadfile';
$filepathr['filelevel']='dozt';
$filepathr['addpostvar']='<input type="hidden" name="ztid" value="'.$ztid.'">';
$filepathr['url']='λ�ã�ר�⣺<b>'.$ztr['ztname'].'</b> &gt; ����ר�⸽��';

include('../file/TruePathfile.php');

db_close();
$empire=null;
?>