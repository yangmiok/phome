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
CheckLevel($logininid,$loginin,$classid,"gbook");
$lyid=(int)$_GET['lyid'];
$bid=(int)$_GET['bid'];
$r=$empire->fetch1("select * from {$dbtbpre}enewsgbook where lyid='$lyid' limit 1");
$username="�ο�";
if($r['userid'])
{
	$username="<a href='../member/AddMember.php?enews=EditMember&userid=".$r['userid'].$ecms_hashur['ehref']."' target=_blank>".$r['username']."</a>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ظ�����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="form1" method="post" action="gbook.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class=tableborder>
  <?=$ecms_hashur['form']?>
    <tr class=header> 
      <td height="25" colspan="2">�ظ�/�޸�����
        <input name="enews" type="hidden" id="enews" value="ReGbook">
        <input name="lyid" type="hidden" id="lyid" value="<?=$lyid?>">
        <input name="bid" type="hidden" id="bid" value="<?=$bid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="20%" height="25">���Է�����:</td>
      <td width="80%" height="25"> 
        <?=stripSlashes($r[name])?>&nbsp;(<?=$username?>)
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������:</td>
      <td height="25"> 
        <?=nl2br(stripSlashes($r[lytext]))?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ʱ��:</td>
      <td height="25">
        <?=$r[lytime]?>&nbsp;
        (IP:
        <?=$r[ip]?>)
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>�ظ�����:</strong></td>
      <td height="25"><textarea name="retext" cols="60" rows="9" id="retext"><?=stripSlashes($r[retext])?></textarea> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ">
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center">[ <a href="javascript:window.close();">�� 
          ��</a> ]</div></td>
    </tr>
  </table>
</form>
</body>
</html>
