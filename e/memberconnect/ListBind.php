<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../member/class/user.php");
$link=db_connect();
$empire=new mysqlquery();
eCheckCloseMods('member');//�ر�ģ��
eCheckCloseMods('mconnect');//�ر�ģ��
//�Ƿ��½
$user=islogin();
$query="select * from {$dbtbpre}enewsmember_connect_app where isclose=0 order by myorder,id";
$sql=$empire->query($query);
//����ģ��
require(ECMS_PATH.'e/template/memberconnect/ListBind.php');
db_close();
$empire=null;
?>