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
CheckLevel($logininid,$loginin,$classid,"table");
$url="<a href=ListTable.php".$ecms_hashur['whehref'].">�������ݱ�</a>&nbsp;>&nbsp;����ϵͳģ��";
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ϵͳģ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>λ�ã� 
      <?=$url?>
    </td>
  </tr>
</table>
<form action="../ecmsmod.php" method="post" enctype="multipart/form-data" name="form1" onsubmit="return confirm('ȷ��Ҫ����?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" colspan="2" class="header">����ϵͳģ��</td>
    </tr>
    <tr> 
      <td width="28%" height="25" bgcolor="#FFFFFF">��ŵ����ݱ���:</td>
      <td width="72%" height="25" bgcolor="#FFFFFF"><strong><?=$dbtbpre?>ecms_</strong> 
        <input name="tbname" type="text" id="tbname">
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ѡ����ģ���ļ�:</td>
      <td height="25" bgcolor="#FFFFFF"><input type="file" name="file">
        *.mod</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="���ϵ���"> 
        <input type="reset" name="Submit2" value="����">
        <input name="enews" type="hidden" id="enews" value="LoadInMod">
      </td>
    </tr>
  </table>
</form>
</body>
</html>
