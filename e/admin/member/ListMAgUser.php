<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../member/class/user.php");
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
CheckLevel($logininid,$loginin,$classid,"madmingroup");
$agid=(int)$_GET['agid'];
if(!$agid)
{
	printerror("ErrorUrl","history.go(-1)");
}
$r=$empire->fetch1("select * from {$dbtbpre}enewsag where agid='$agid'");
if(!$r['agid'])
{
	printerror("ErrorUrl","history.go(-1)");
}
if($r['isadmin']==9)
{
	$isadminname='����Ա';
}
elseif($r['isadmin']==5)
{
	$isadminname='����';
}
elseif($r['isadmin']==1)
{
	$isadminname='ʵϰ����';
}
else
{
	$isadminname='';
}
$url="<a href=ListMAdminGroup.php".$ecms_hashur['whehref'].">�����Ա������</a>&nbsp;>&nbsp;�����飺".$r['agname']."&nbsp;>&nbsp;<a href='ListMAgUser.php?agid=$agid".$ecms_hashur['ehref']."'>[".$isadminname."]��Ա�б�</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ա������ - ��Ա�б�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> 
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton"></div></td>
  </tr>
</table>
<br>
<form name="form1" method="post" action="ListMAdminGroup.php" onsubmit="return confirm('ȷ��Ҫ���ӹ���Ա��');">
  <table width="800" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25" colspan="3">���ӻ�Ա����Ա: 
        <input name=enews type=hidden id="enews" value=AddMAgUser>      <input name="agid" type="hidden" id="agid" value="<?=$agid?>"></td>
    </tr>
    <tr>
      <td width="223" height="25" bgcolor="#FFFFFF"><div align="center">�û�ID</div></td>
      <td width="421" bgcolor="#FFFFFF"><div align="center">�û���</div></td>
      <td width="134" bgcolor="#FFFFFF"><div align="center">����</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">
        <input name="adduserid" type="text" id="adduserid">
      </div></td>
      <td height="25" bgcolor="#FFFFFF"><div align="center">
        <input name="addusername" type="text" id="addusername" size="36">
      </div></td>
      <td height="25" bgcolor="#FFFFFF"><div align="center">
        <input type="submit" name="Submit" value="����">
      </div></td>
    </tr>
  </table>
</form>
<table width="800" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="223" height="25"> <div align="center">�û�ID</div></td>
    <td width="421" height="25"> <div align="center">�û���</div></td>
    <td width="134" height="25"> <div align="center">����</div></td>
  </tr>
  <?
  $amr=explode(',',$r['auids']);
  $mcount=count($amr)-1;
  for($mi=1;$mi<$mcount;$mi++)
  {
  	$auserid=(int)$amr[$mi];
	$member_r=$empire->fetch1("select ".eReturnSelectMemberF('username')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$auserid'");
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$auserid?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$member_r['username']?>
      </div></td>
    <td height="25"> <div align="center">[<a href="ListMAdminGroup.php?enews=DelMAgUser&agid=<?=$agid?>&adduserid=<?=$auserid?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ���˹���Ա��');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  db_close();
  $empire=null;
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="3"><font color="#666666">˵�������Ӱ�����Ȼ���ٵ�������Ŀ���ӿɹ������Ŀ��</font></td>
  </tr>
</table>
</body>
</html>
