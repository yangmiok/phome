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

$paytype='alipay';
$payr=$empire->fetch1("select * from {$dbtbpre}enewspayapi where paytype='$paytype' limit 1");
if(!$payr['payid']||$payr['isclose'])
{
	printerror('�����Ե����Ӳ�����','',1,0,1);
}

$bargainor_id=$payr['payuser'];//�̻���

$paykey=$payr['paykey'];//��Կ

$seller_email=$payr['payemail'];//����֧�����ʻ�

//----------------------------------------------������Ϣ

if(!empty($_POST))
{
	foreach($_POST as $key => $data)
	{
		$_GET[$key]=$data;
	}
}

$get_seller_email=rawurldecode($_GET['seller_email']);


//֧����֤
ksort($_GET);
reset($_GET);

$sign='';
foreach($_GET AS $key=>$val)
{
	if($key!='sign'&&$key!='sign_type'&&$key!='code')
	{
		$sign.="$key=$val&";
	}
}

$sign=md5(substr($sign,0,-1).$paykey);
if('dg'.$sign!='dg'.$_GET['sign'])
{
	printerror('��֤MD5ǩ��ʧ��.','../../../',1,0,1);
}

if(!($_GET['trade_status']=="TRADE_FINISHED"||$_GET['trade_status']=="WAIT_SELLER_SEND_GOODS"||$_GET['trade_status']=="TRADE_SUCCESS"))
{
	printerror('֧��ʧ��.','../../../',1,0,1);
}

//----------- ֧���ɹ����� -----------

include('../payfun.php');
$pr=$empire->fetch1("select paymoneytofen,payminmoney from {$dbtbpre}enewspublic limit 1");

$orderid=$_GET['trade_no'];	//֧������
$ddno=$_GET['out_trade_no'];	//��վ�Ķ�����
$money=$_GET['total_fee'];
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