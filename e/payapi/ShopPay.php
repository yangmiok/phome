<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../member/class/user.php");
eCheckCloseMods('pay');//�ر�ģ��
$link=db_connect();
$empire=new mysqlquery();
//֧��ƽ̨
$paytype=RepPostVar($_GET['paytype']);
if(!$paytype)
{
	printerror('��ѡ��֧��ƽ̨','',1,0,1);
}
$payr=$empire->fetch1("select * from {$dbtbpre}enewspayapi where paytype='$paytype' and isclose=0 limit 1");
if(!$payr[payid])
{
	printerror('��ѡ��֧��ƽ̨','',1,0,1);
}

include('payfun.php');

//������Ϣ
$ddid=(int)getcvar('paymoneyddid');
$ddr=PayApiShopDdMoney($ddid);
$money=$ddr['tmoney'];
if(!$money)
{
	printerror('�����������','',1,0,1);
}
$ddno=$ddr[ddno];
$productname="֧��������:".$ddno;
$productsay="������:".$ddno;

esetcookie("payphome","ShopPay",0);
//���ص�ַǰ׺
$PayReturnUrlQz=$public_r['newsurl'];
if(!stristr($public_r['newsurl'],'://'))
{
	$PayReturnUrlQz=eReturnDomain().$public_r['newsurl'];
}
//char
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