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
CheckLevel($logininid,$loginin,$classid,"memberconnect");
$enews=ehtmlspecialchars($_GET['enews']);
$id=(int)$_GET['id'];
$r=$empire->fetch1("select * from {$dbtbpre}enewsmember_connect_app where id='$id'");
$url="�ⲿ�ӿ� &gt; <a href=MemberConnect.php".$ecms_hashur['whehref'].">�����ⲿ��¼�ӿ�</a>&nbsp;>&nbsp;�����ⲿ��¼�ӿڣ�<b>".$r[apptype]."</b>";
db_close();
$empire=null;
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
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton"></div></td>
  </tr>
</table>
<form name="setmemberconnectform" method="post" action="MemberConnect.php" enctype="multipart/form-data" autocomplete="off">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">�����ⲿ��¼�ӿ� 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="id" type="hidden" id="id" value="<?=$id?>">      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">�ӿ����ͣ�</div></td>
      <td height="25"> 
        <?=$r[apptype]?>      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">�ӿ�״̬��</div></td>
      <td height="25"><input type="radio" name="isclose" value="0"<?=$r[isclose]==0?' checked':''?>>
        ���� 
        <input type="radio" name="isclose" value="1"<?=$r[isclose]==1?' checked':''?>>
        �ر�</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="23%" height="25"><div align="right">�ӿ����ƣ�</div></td>
      <td width="77%" height="25"><input name="appname" type="text" id="appname" value="<?=$r[appname]?>" size="35"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25"><div align="right">�ӿڱ�����</div></td>
      <td height="25"><input name="qappname" type="text" id="qappname" value="<?=$r[qappname]?>" size="35"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top"><div align="right">�ӿ�������</div></td>
      <td height="25"><textarea name="appsay" cols="65" rows="6" id="appsay"><?=ehtmlspecialchars($r[appsay])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">appid��</div></td>
      <td height="25"><input name="appid" type="text" id="appid" value="<?=$r[appid]?>" size="35">
        <font color="#666666">(�����Ӧ��ID)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">appkey��</div></td>
      <td height="25"><input name="appkey" type="text" id="appkey" value="<?=$r[appkey]?>" size="35">
        <font color="#666666">(�����Ӧ����Կ)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25"><div align="right">��ʾ����</div></td>
      <td height="25"><input name=myorder type=text id="myorder" value='<?=$r[myorder]?>' size="35">
        <font color="#666666">(ֵԽС��ʾԽǰ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value=" �� �� "> &nbsp;&nbsp;&nbsp; 
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
