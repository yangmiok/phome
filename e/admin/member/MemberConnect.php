<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
//��֤Ȩ��
CheckLevel($logininid,$loginin,$classid,"memberconnect");

//���ýӿ�
function EditMemberConnect($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[id]=(int)$add[id];
	if(empty($add[appname])||!$add[id])
	{
		printerror("EmptyMemberConnect","history.go(-1)");
    }
	$add[isclose]=(int)$add[isclose];
	$add[myorder]=(int)$add[myorder];
	$add[appname]=eaddslashes(ehtmlspecialchars($add[appname]));
	$add[appid]=eaddslashes($add[appid]);
	$add[appkey]=eaddslashes($add[appkey]);
	$add[qappname]=eaddslashes($add[qappname]);
	$add[appsay]=eaddslashes($add[appsay]);
	$sql=$empire->query("update {$dbtbpre}enewsmember_connect_app set appname='$add[appname]',appid='$add[appid]',appkey='$add[appkey]',isclose='$add[isclose]',myorder='$add[myorder]',qappname='$add[qappname]',appsay='$add[appsay]' where id='$add[id]'");
	$appr=$empire->fetch1("select apptype from {$dbtbpre}enewsmember_connect_app where id='$add[id]'");
	if($sql)
	{
		GetConfig();
		//������־
		insert_dolog("id=".$add[id]."&apptype=".$appr[apptype]."<br>appname=".$add[appname]);
		printerror("EditMemberConnectSuccess","MemberConnect.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//�����û�
if($enews=="EditMemberConnect")
{
	EditMemberConnect($_POST,$logininid,$loginin);
}

$sql=$empire->query("select * from {$dbtbpre}enewsmember_connect_app order by myorder,id");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ⲿ��¼�ӿ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã��ⲿ�ӿ� &gt; <a href="MemberConnect.php<?=$ecms_hashur['whehref']?>">�����ⲿ��¼�ӿ�</a> </td>
    <td><div align="right" class="emenubutton"></div></td>
  </tr>
</table>
<br>
<table width="800" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td width="7%"><div align="center">ID</div></td> 
    <td width="32%"><div align="center">�ӿ�����</div></td>
    <td width="10%"><div align="center">״̬</div></td>
    <td width="17%" height="25"><div align="center">�ӿ�����</div></td>
    <td width="10%"><div align="center">������</div></td>
    <td width="10%"><div align="center">��¼����</div></td>
    <td width="14%" height="25"><div align="center">����</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  	$membernum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmember_connect where apptype='$r[apptype]' limit 1");
	$loginnum=$empire->gettotal("select sum(loginnum) as total from {$dbtbpre}enewsmember_connect where apptype='$r[apptype]' limit 1");
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
    <td align="center"><?=$r['id']?></td> 
    <td height="38" align="center"> 
      <?=$r['appname']?>    </td>
    <td><div align="center">
        <?=$r['isclose']==0?'����':'�ر�'?>
      </div></td>
    <td height="38"> <div align="center">
        <?=$r['apptype']?>
      </div></td>
    <td><div align="center"><?=$membernum?></div></td>
    <td><div align="center"><?=intval($loginnum)?></div></td>
    <td height="38"> <div align="center"><a href="SetMemberConnect.php?enews=EditMemberConnect&id=<?=$r['id']?><?=$ecms_hashur['ehref']?>">���ýӿ�</a></div></td>
  </tr>
  <?php
  }
  db_close();
  $empire=null;
  ?>
</table>
</body>
</html>
