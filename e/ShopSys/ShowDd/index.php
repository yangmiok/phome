<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");
require("../class/ShopSysFun.php");
eCheckCloseMods('shop');//�ر�ģ��
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//�Ƿ��½
$user=islogin();
$ddid=(int)$_GET['ddid'];
$r=$empire->fetch1("select * from {$dbtbpre}enewsshopdd where ddid='$ddid' and userid='$user[userid]' limit 1");
if(empty($r['ddid']))
{
	printerror('�˶���������','',1,0,1);
}
$addr=$empire->fetch1("select * from {$dbtbpre}enewsshopdd_add where ddid='$ddid' limit 1");
//��Ҫ��Ʊ
$fp="��";
if($r[fp])
{
	$fp="��";
}
//���
$total=0;
if($r[payby]==1)
{
	$pstotal=$r[pstotal]." ��";
	$alltotal=$r[alltotalfen]." ��";
	$total=$r[pstotal]+$r[alltotalfen];
	$mytotal=$total." ��";
}
else
{
	$pstotal=$r[pstotal]." Ԫ";
	$alltotal=$r[alltotal]." Ԫ";
	$total=$r[pstotal]+$r[alltotal]+$r[fptotal]-$r[pretotal];
	$mytotal=$total." Ԫ";
}
//֧����ʽ
if($r[payby]==1)
{
	$payfsname=$r[payfsname]."(��������)";
}
elseif($r[payby]==2)
{
	$payfsname=$r[payfsname]."(����)";
}
else
{
	$payfsname=$r[payfsname];
}
//״̬
if($r['checked']==1)
{
	$ch="��ȷ��";
}
elseif($r['checked']==2)
{
	$ch="ȡ��";
}
elseif($r['checked']==3)
{
	$ch="�˻�";
}
else
{
	$ch="<font color=red>δȷ��</font>";
}
//����
if($r['outproduct']==1)
{
	$ou="�ѷ���";
}
elseif($r['outproduct']==2)
{
	$ou="������";
}
else
{
	$ou="<font color=red>δ����</font>";
}
$topay='';
if($r['haveprice']==1)
{
	$ha="�Ѹ���";
}
else
{
	//�Ƿ�����֧��
	$payfs_r=$empire->fetch1("select payurl from {$dbtbpre}enewsshoppayfs where payid='$r[payfsid]'");
	if($payfs_r['payurl'])
	{
		$topay="&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' name='button' value='���֧��' onclick=\"window.open('../doaction.php?ddid=$ddid&enews=ShopDdToPay','','width=760,height=600,scrollbars=yes,resizable=yes');\">";
	}
	$ha="<font color=red>δ����</font>";
}
//����ģ��
require(ECMS_PATH.'e/template/ShopSys/ShowDd.php');
db_close();
$empire=null;
?>