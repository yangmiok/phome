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
$query="select addressid,addressname,isdefault from {$dbtbpre}enewsshop_address where userid='$user[userid]' order by addressid";
$sql=$empire->query($query);
//����ģ��
require(ECMS_PATH.'e/template/ShopSys/ListAddress.php');
db_close();
$empire=null;
?>