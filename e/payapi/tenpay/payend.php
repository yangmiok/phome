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

$paytype='tenpay';
$payr=$empire->fetch1("select * from {$dbtbpre}enewspayapi where paytype='$paytype' limit 1");
if(!$payr['payid']||$payr['isclose'])
{
	printerror('�����Ե����Ӳ�����','',1,0,1);
}

$bargainor_id=$payr['payuser'];//�̻���

$key=$payr['paykey'];//��Կ

//----------------------------------------------������Ϣ

/*
import_request_variables("gpc", "frm_");
$strCmdno			= $frm_cmdno;
$strPayResult		= $frm_pay_result;
$strPayInfo		= $frm_pay_info;
$strBillDate		= $frm_date;
$strBargainorId	= $frm_bargainor_id;
$strTransactionId	= $frm_transaction_id;
$strSpBillno		= $frm_sp_billno;
$strTotalFee		= $frm_total_fee;
$strFeeType		= $frm_fee_type;
$strAttach			= $frm_attach;
$strMd5Sign		= $frm_sign;
*/

if(!empty($_POST))
{
	foreach($_POST as $key => $data)
	{
		$_GET[$key]=$data;
	}
}

$strCmdno			= $_GET['cmdno'];
$strPayResult		= $_GET['pay_result'];
$strPayInfo		= $_GET['pay_info'];
$strBillDate		= $_GET['date'];
$strBargainorId	= $_GET['bargainor_id'];
$strTransactionId	= $_GET['transaction_id'];
$strSpBillno		= $_GET['sp_billno'];
$strTotalFee		= $_GET['total_fee'];
$strFeeType		= $_GET['fee_type'];
$strAttach			= $_GET['attach'];
$strMd5Sign		= $_GET['sign'];


//֧����֤
$checkkey="cmdno=".$strCmdno."&pay_result=".$strPayResult."&date=".$strBillDate."&transaction_id=".$strTransactionId."&sp_billno=".$strSpBillno."&total_fee=".$strTotalFee."&fee_type=".$strFeeType."&attach=".$strAttach."&key=".$key;
$checkSign=strtoupper(md5($checkkey));
  
if('dg'.$checkSign!='dg'.$strMd5Sign)
{
	printerror('��֤MD5ǩ��ʧ��.','../../../',1,0,1);
}  

if($bargainor_id!=$strBargainorId)
{
	printerror('������̻���.','../../../',1,0,1);
}

if($strPayResult!="0")
{
	printerror('֧��ʧ��.','../../../',1,0,1);
}

//----------- ֧���ɹ����� -----------

include('../payfun.php');
$pr=$empire->fetch1("select paymoneytofen,payminmoney from {$dbtbpre}enewspublic limit 1");

$orderid=$strSpBillno;	//֧������
$ddno=$strAttach;	//��վ�Ķ�����
$money=$strTotalFee/100;
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