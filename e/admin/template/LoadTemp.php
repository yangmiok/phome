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
CheckLevel($logininid,$loginin,$classid,"template");
$url="<a href=LoadTemp.php".$ecms_hashur['whehref'].">����������Ŀģ��</a>";
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����������Ŀģ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="../ecmstemp.php" onsubmit="return confirm('ȷ��Ҫ���룿');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">����������Ŀģ�� 
          <input name="enews" type="hidden" id="enews" value="LoadTempInClass">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <div align="center"><br>
          <input type="submit" name="Submit" value="��ʼ����ģ��">
          <br>
          <br>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25"><div align="center">(˵�������ռ���Ŀ��Ч���뽫Ҫ�����ģ���ϴ�����<a href="ShowLoadTempPath.php<?=$ecms_hashur['whehref']?>" target="_blank"><strong>/e/data/LoadTemp</strong></a>,Ȼ��������ģ�壮<br>
          ģ���ļ�������ʽ��<strong><font color="#FF0000">��ĿID.htm</font></strong> ,ϵͳ��������Ӧ��&quot;ID�ļ�&quot;���е��룮)</div></td>
    </tr>
  </table>
</form>
</body>
</html>
