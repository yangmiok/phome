<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../data/dbcache/class.php");
require LoadLang("pub/fun.php");
require("../member/class/user.php");
$link=db_connect();
$empire=new mysqlquery();
$userid=0;
$username='';
$spacestyle='';
$search='';
require('CheckUser.php');//��֤�û�
$yhid=0;
$yhvar='qmlist';
//ģ��
$mid=intval($_GET['mid']);
if(!$mid)
{
	printerror("ErrorUrl","",1);
}
$mr=$empire->fetch1("select tbname,qmname,sonclass from {$dbtbpre}enewsmod where mid='$mid'");
if(!$mr['tbname']||InfoIsInTable($mr['tbname']))
{
	printerror("ErrorUrl","",1);
}
$yhid=$etable_r[$mr[tbname]][yhid];
$search.="&userid=$userid&mid=$mid";
//�û�
$add="userid='$userid'";
//��ʾ��ʽ
if($public_r['qlistinfomod'])
{
	$modnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmod where tbname='$mr[tbname]'");
	if($modnum>1)
	{
		$add.=' and ('.ReturnClass($mr['sonclass']).')';
	}
}
//��Ŀ
$classid=intval($_GET['classid']);
if($classid)
{
	if($class_r[$classid][islast])
	{
		$add.=" and classid='$classid'";
	}
	else
	{
		$add.=' and '.ReturnClass($class_r[$classid][sonclass]);
	}
	$yhid=$class_r[$classid][yhid];
	$search.="&classid=$classid";
}
//�Ż�
$yhadd='';
if($yhid)
{
	$yhadd=ReturnYhSql($yhid,$yhvar,1);
}
$start=0;
$page=intval($_GET['page']);
$page=RepPIntvar($page);
$line=$public_r['space_num'];//ÿ����ʾ
$page_line=10;
$offset=$page*$line;
$query="select ".ReturnSqlListF($mid)." from {$dbtbpre}ecms_".$mr['tbname']." where ".$yhadd.$add." and ismember=1";
$totalquery="select count(*) as total from {$dbtbpre}ecms_".$mr['tbname']." where ".$yhadd.$add." and ismember=1";
$totalnum=intval($_GET['totalnum']);
if(!$public_r['usetotalnum'])
{
	$totalnum=0;
}
if($totalnum<1)
{
	$num=$empire->gettotal($totalquery);//ȡ��������
}
else
{
	$num=$totalnum;
}
if($public_r['usetotalnum'])
{
	$search.="&totalnum=$num";
}
//checkpageno
eCheckListPageNo($page,$line,$num);
$query.=" order by newstime desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page1($num,$line,$page_line,$start,$page,$search);
require('template/'.$spacestyle.'/list.temp.php');
db_close();
$empire=null;
?>