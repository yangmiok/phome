<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");
eCheckCloseMods('pay');//�ر�ģ��
$link=db_connect();
$empire=new mysqlquery();
$editor=1;

//������
if(!getcvar('checkpaysession'))
{
	printerror('�Ƿ�����','../../../',1,0,1);
}
else
{
	esetcookie("checkpaysession","",0);
}
//�����¼�
$phome=getcvar('payphome');
if($phome=='PayToFen')//�������
{}
elseif($phome=='PayToMoney')//��Ԥ����
{}
elseif($phome=='ShopPay')//�̳�֧��
{}
elseif($phome=='BuyGroupPay')//�����ֵ����
{}
else
{
	printerror('�����Ե����Ӳ�����','',1,0,1);
}

$user=array();
if($phome=='PayToFen'||$phome=='PayToMoney'||$phome=='BuyGroupPay')
{
	$user=islogin();//�Ƿ��½
}

$paytype='chinabank';
$payr=$empire->fetch1("select * from {$dbtbpre}enewspayapi where paytype='$paytype' limit 1");
if(!$payr['payid']||$payr['isclose'])
{
	printerror('�����Ե����Ӳ�����','',1,0,1);
}

$v_mid=$payr['payuser'];//�̻���

$key=$payr['paykey'];//��Կ

//----------------------------------------------������Ϣ
$v_oid    =trim($_POST['v_oid']);      
$v_pmode   =trim($_POST['v_pmode']);      
$v_pstatus=trim($_POST['v_pstatus']);      
$v_pstring=trim($_POST['v_pstring']);      
$v_amount=trim($_POST['v_amount']);     
$v_moneytype  =trim($_POST['v_moneytype']);     
$remark1  =trim($_POST['remark1']);     
$remark2  =trim($_POST['remark2']);     
$v_md5str =trim($_POST['v_md5str']);    

//md5
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

if('dg'.$v_md5str!='dg'.$md5string)
{
	printerror('��֤MD5ǩ��ʧ��.','../../../',1,0,1);
}

if($v_pstatus!="20")
{
	printerror('֧��ʧ��.','../../../',1,0,1);
}

//----------- ֧���ɹ����� -----------

include('../payfun.php');
$pr=$empire->fetch1("select paymoneytofen,payminmoney from {$dbtbpre}enewspublic limit 1");

$orderid=$v_oid;	//֧������
$ddno=$remark1;	//��վ�Ķ�����
$money=$v_amount;
$fen=floor($money)*$pr[paymoneytofen];

if($phome=='PayToFen')//�������
{
	$paybz='�������: '.$fen;
	PayApiBuyFen($fen,$money,$paybz,$orderid,$user[userid],$user[username],$paytype);
}
elseif($phome=='PayToMoney')//��Ԥ����
{
	$paybz='��Ԥ����';
	PayApiPayMoney($money,$paybz,$orderid,$user[userid],$user[username],$paytype);
}
elseif($phome=='ShopPay')//�̳�֧��
{
	include('../../data/dbcache/class.php');
	$ddid=(int)getcvar('paymoneyddid');
	$paybz='�̳ǹ��� [!--ddno--] �Ķ���(ddid='.$ddid.')';
	PayApiShopPay($ddid,$money,$paybz,$orderid,'','',$paytype);
}
elseif($phome=='BuyGroupPay')//�����ֵ����
{
	include("../../data/dbcache/MemberLevel.php");
	$bgid=(int)getcvar('paymoneybgid');
	PayApiBuyGroupPay($bgid,$money,$orderid,$user[userid],$user[username],$user[groupid],$paytype);
}

db_close();
$empire=null;
?>