<?php
require("../../class/connect.php");
require("../../class/q_functions.php");
require("../../class/db_sql.php");
require("../../member/class/user.php");
require("../class/ShopSysFun.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
eCheckCloseMods('shop');//�ر�ģ��
$user=islogin();
$enews=RepPostStr($_GET['enews'],1);
if(empty($enews))
{
	$enews="AddAddress";
}
$r=array();
$addressid=(int)$_GET['addressid'];
if($enews=='EditAddress')
{
	$r=$empire->fetch1("select * from {$dbtbpre}enewsshop_address where addressid='$addressid' and userid='$user[userid]' limit 1");
}
//����ģ��
require(ECMS_PATH.'e/template/ShopSys/AddAddress.php');
db_close();
$empire=null;
?>