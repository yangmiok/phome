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
CheckLevel($logininid,$loginin,$classid,"tags");
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>TAGS</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href="ListTags.php<?=$ecms_hashur['whehref']?>">����TAGS</a> &gt; ɾ��ʹ���ʵ͵�TAGS</td>
  </tr>
</table>
<form name="form1" method="post" action="ListTags.php" onsubmit="return confirm('ȷ��Ҫ����?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">ɾ��ʹ���ʵ͵�TAGS
          <input name="enews" type="hidden" id="enews" value="DelLessTags">
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">ɾ����Ϣ��<font color="#FF0000"><strong>&lt;=</strong></font> 
          <input name="num" type="text" id="num" value="0" size="8">
          ��TAGS
<input type="submit" name="Submit2" value="ɾ��">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>