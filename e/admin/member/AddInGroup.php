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
CheckLevel($logininid,$loginin,$classid,"ingroup");
$enews=ehtmlspecialchars($_GET['enews']);
$postword='����';
$url="<a href='ListInGroup.php".$ecms_hashur['whehref']."'>�����Ա�ڲ���</a>&nbsp;->&nbsp;���ӻ�Ա�ڲ���";
if($enews=="EditInGroup")
{
	$gid=(int)$_GET['gid'];
	$postword='�޸�';
	$r=$empire->fetch1("select * from {$dbtbpre}enewsingroup where gid='$gid'");
	$url="<a href='ListInGroup.php".$ecms_hashur['whehref']."'>�����Ա�ڲ���</a>&nbsp;->&nbsp;�޸Ļ�Ա�ڲ��飺<b>".$r[gname]."</b>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ա�ڲ���</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListInGroup.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="21%" height="25"><?=$postword?>��Ա�ڲ���</td>
      <td width="79%" height="25"><input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="gid" type="hidden" id="gid" value="<?=$gid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">������</td>
      <td height="25"> <input name="gname" type="text" id="gname" value="<?=$r[gname]?>" size="30">      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ʾ����</td>
      <td height="25"> <input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>" size="30">        <font color="#666666">(ֵԽСԽǰ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
