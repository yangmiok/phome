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
require('memberconnectfun.php');
//�ӿ�
$apptype=RepPostVar($_GET['apptype']);
$appr=$empire->fetch1("select * from {$dbtbpre}enewsmember_connect_app where apptype='$apptype' and isclose=0 limit 1");
if(!$appr['id'])
{
	printerror2('��ѡ���¼��ʽ','');
}
$ReturnUrlQz=eReturnDomainSiteUrl();
$file=$appr['apptype'].'/to_login.php';
@include($file);
db_close();
$empire=null;
?>