<?php
//------------------��������
$open=1;	//1Ϊ�رգ�0Ϊ����
$type=0;	//0Ϊ��ip(ͬһip���ظ����ӵ���)��1Ϊ��cookie(ͬһ�������ظ����ӵ���)
$retime=3600;	//�ظ����ӵ���ʱ��������λΪ��
$fen=1;		//��һ�������
$gotourl="../../../";	//ת���ַ


//------------------
if($open)
{
	exit();
}

require("../../class/connect.php");
$id=(int)$_GET['id'];
$n=RepPostVar($_GET['n']);
if(!($id||$n))
{
	Header("Location:$gotourl");
	exit();
}
require("../../class/db_sql.php");
require("../../member/class/user.php");
$link=db_connect();
$empire=new mysqlquery();
if($id)
{
	$where=egetmf('userid')."='".$id."'";
}
else
{
	$where=egetmf('username')."='".$n."'";
}
$r=$empire->fetch1("select ".eReturnSelectMemberF('userid,username')." from ".eReturnMemberTable()." where ".$where." limit 1");
if(empty($r[userid]))
{
	Header("Location:$gotourl");
	exit();
}
//cookie
if($type==1)
{
	$gfencookie=getcvar('ecmsgfen');
	if($gfencookie)
	{
		Header("Location:$gotourl");
		exit();
	}
	$set=esetcookie("ecmsgfen","ecms",time()+$retime);
}
//ip
else
{
	$ip=egetip();
	$time=time();
	//ɾ�����ڼ�¼
	$del=$empire->query("delete from {$dbtbpre}enewsgfenip where ".$time."-addtime>".$retime);
	$ipr=$empire->fetch1("select ip,addtime from {$dbtbpre}enewsgfenip where ip='$ip' limit 1");
	if($ipr['ip'])
	{
		Header("Location:$gotourl");
		exit();
	}
	else
	{
		$usql=$empire->query("insert into {$dbtbpre}enewsgfenip(ip,addtime) values('$ip',$time);");
	}
}
$usql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('userfen')."=".egetmf('userfen')."+".$fen." where ".$where);
$set=esetcookie("gfenuserid",$r[userid],0);
$set=esetcookie("gfenusername",$r[username],0);
db_close();
$empire=null;
header("Refresh:0; URL=$gotourl");
?>