<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../member/class/user.php");
require("../data/dbcache/MemberLevel.php");
eCheckCloseMods('pay');//�ر�ģ��
$link=db_connect();
$empire=new mysqlquery();
//�Ƿ��½
$user=islogin();
//֧��ƽ̨
$payid=intval($_POST['payid']);
if(!$payid)
{
	printerror('��ѡ��֧��ƽ̨','',1,0,1);
}
//��ֵ����
$id=intval($_POST['id']);
if(!$id)
{
	printerror('��ѡ���ֵ����','',1,0,1);
}
$payr=$empire->fetch1("select * from {$dbtbpre}enewspayapi where payid='$payid' and isclose=0 limit 1");
if(!$payr[payid])
{
	printerror('��ѡ��֧��ƽ̨','',1,0,1);
}
$buyr=$empire->fetch1("select * from {$dbtbpre}enewsbuygroup where id='$id'");
if(!$buyr['id'])
{
	printerror('��ѡ���ֵ����','',1,0,1);
}
//Ȩ��
if($buyr[buygroupid]&&$level_r[$buyr[buygroupid]][level]>$level_r[$user[groupid]][level])
{
	printerror('�˳�ֵ������Ҫ '.$level_r[$buyr[buygroupid]][groupname].' ��Ա��������','',1,0,1);
}
//��Ч����֤
if($buyr['gdate']&&$user['groupid']!=$buyr['ggroupid'])
{
	if($user['userdate']&&$user['userdate']>=time())
	{
		if(!$public_r['mhavedatedo'])
		{
			printerror('����ǰ�Ļ�Ա����Ч��δ�������ܳ�ֵ�»�Ա��','',1,0,1);
		}
	}
}
include('payfun.php');

$money=$buyr['gmoney'];
if(!$money)
{
	printerror('�˳�ֵ���ͽ������','',1,0,1);
}
$ddno='';
$productname="��ֵ����:".$buyr['gname'].",UID:".$user['userid'].",UName:".$user['username'];
$productsay="�û�ID:".$user['userid'].",�û���:".$user['username'];

esetcookie("payphome","BuyGroupPay",0);
esetcookie("paymoneybgid",$id,0);
//���ص�ַǰ׺
$PayReturnUrlQz=$public_r['newsurl'];
if(!stristr($public_r['newsurl'],'://'))
{
	$PayReturnUrlQz=eReturnDomain().$public_r['newsurl'];
}
//����
if($ecms_config['sets']['pagechar']!='gb2312')
{
	@include_once("../class/doiconv.php");
	$iconv=new Chinese('');
	$char=$ecms_config['sets']['pagechar']=='big5'?'BIG5':'UTF8';
	$targetchar='GB2312';
	$productname=$iconv->Convert($char,$targetchar,$productname);
	$productsay=$iconv->Convert($char,$targetchar,$productsay);
	@header('Content-Type: text/html; charset=gb2312');
}
$file=$payr['paytype'].'/to_pay.php';
@include($file);
db_close();
$empire=null;
?>