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
CheckLevel($logininid,$loginin,$classid,"card");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListCard.php".$ecms_hashur['whehref'].">����㿨</a> &gt; <a href=AddMoreCard.php".$ecms_hashur['whehref'].">�������ӵ㿨</a>";
//----------��Ա��
$sql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($level_r=$empire->fetch($sql))
{
	$group.="<option value=".$level_r[groupid].">".$level_r[groupname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�������ӵ㿨</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="98%%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListCard.php">
  <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">�������ӵ㿨 
          <input name="enews" type="hidden" id="enews" value="AddMoreCard">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="36%" height="25">�������ɵ㿨������</td>
      <td width="64%" height="25"><input name="donum" type="text" id="donum" value="10" size="6">
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�㿨�ʺ�λ����</td>
      <td height="25"><input name="cardnum" type="text" id="cardnum" value="8" size="6">
        λ </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�㿨����λ����</td>
      <td height="25"><input name="passnum" type="text" id="passnum" value="6" size="6">
        λ </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�㿨��</td>
      <td height="25"><input name="money" type="text" id="money" value="10" size="6">
        Ԫ</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">������</td>
      <td height="25"><input name="cardfen" type="text" id="cardfen" value="0" size="6">
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="3">��ֵ��Ч��:</td>
      <td height="25"><input name="carddate" type="text" id="carddate" value="0" size="6">
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ֵ����ת���Ա��: 
        <select name="cdgroupid" id="select2">
          <option value=0>������</option>
          <?=$group?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">���ں�ת��Ļ�Ա��: 
        <select name="cdzgroupid" id="cdzgroupid">
          <option value=0>������</option>
          <?=$group?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ʱ�䣺</td>
      <td height="25"><input name="endtime" type="text" id="endtime" value="0000-00-00" size="20" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        (0000-00-00Ϊ������)</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <input type="submit" name="Submit" value="�ύ">
          &nbsp; 
          <input type="reset" name="Submit2" value="����">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>