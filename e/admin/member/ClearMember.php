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
CheckLevel($logininid,$loginin,$classid,"member");

$enews=$_POST['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=='ClearMember')
{
	@set_time_limit(0);
	include('../../member/class/member_adminfun.php');
	include('../../member/class/member_modfun.php');
	admin_ClearMember($_POST,$logininid,$loginin);
}

//��Ա��
$group='';
$sql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($level_r=$empire->fetch($sql))
{
	$group.="<option value=".$level_r[groupid].">".$level_r[groupname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����Ա</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href="ListMember.php<?=$ecms_hashur['whehref']?>">�����Ա</a>&nbsp;>&nbsp;�����Ա</td>
  </tr>
</table>
<form name="form1" method="post" action="ClearMember.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">�����Ա
        <input name="enews" type="hidden" id="enews" value="ClearMember"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="20%" height="25">�û��������ַ���</td>
      <td width="80%" height="25"><input name=username type=text id="username"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����ַ�����ַ���</td>
      <td height="25"><input name=email type=text id="email"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�û�ID ���ڣ�</td>
      <td height="25"><input name="startuserid" type="text" id="startuserid">
        -- 
        <input name="enduserid" type="text" id="enduserid"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">������Ա�飺</td>
      <td height="25"><select name="groupid" id="groupid">
          <option value="0">����</option>
          <?=$group?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">ע��ʱ�� ���ڣ�</td>
      <td height="25"><input name="startregtime" type="text" id="startregtime" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        -- 
        <input name="endregtime" type="text" id="endregtime" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        <font color="#666666">(��ʽ��2011-01-27)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">���� ���ڣ�</td>
      <td height="25"><input name="startuserfen" type="text" id="startuserfen">
        -- 
        <input name="enduserfen" type="text" id="enduserfen"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�ʻ���� ���ڣ�</td>
      <td height="25"><input name="startmoney" type="text" id="startmoney">
        -- 
        <input name="endmoney" type="text" id="endmoney"></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">�Ƿ���ˣ�</td>
      <td height="25"><input name="checked" type="radio" value="0" checked>
        ���� 
        <input name="checked" type="radio" value="1">
        ����˻�Ա 
        <input name="checked" type="radio" value="2">
        δ��˻�Ա</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="ɾ����Ա">
      </td>
    </tr>
  </table>
</form>
</body>
</html>
