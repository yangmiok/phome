<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../member/class/user.php");
eCheckCloseMods('member');//�ر�ģ��
eCheckCloseMods('mconnect');//�ر�ģ��
$link=db_connect();
$empire=new mysqlquery();
eCheckCloseMemberConnect();//��֤�����Ľӿ�
session_start();
require('memberconnectfun.php');

$apptype=RepPostVar($_SESSION['apptype']);
$openid=RepPostVar($_SESSION['openid']);
if(!trim($apptype)||!trim($openid))
{
	printerror2('���Ե����Ӳ�����','../../../');
}
$appr=MemberConnect_CheckApptype($apptype);//��֤��¼��ʽ
MemberConnect_CheckBindKey($apptype,$openid);

//����ģ��
require(ECMS_PATH.'e/template/memberconnect/tobind.php');
db_close();
$empire=null;
?>