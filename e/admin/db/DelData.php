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
CheckLevel($logininid,$loginin,$classid,"delinfodata");
//��Ŀ
$fcfile="../../data/fc/ListEnews.php";
$class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
//ˢ�±�
$retable="";
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable order by tid");
while($tr=$empire->fetch($tsql))
{
	$retable.="<option value='".$tr[tbname]."'>".$tr[tname]."(".$tr[tbname].")</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������ɾ����Ϣ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<a href="DelData.php<?=$ecms_hashur['whehref']?>">������ɾ����Ϣ</a></td>
  </tr>
</table>
<form action="../ecmsinfo.php" method="get" name="form1" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> <div align="center">������ɾ����Ϣ</div></td>
    </tr>
    <tr> 
      <td width="20%" height="25" bgcolor="#FFFFFF">ѡ�����ݱ�</td>
      <td width="80%" bgcolor="#FFFFFF"><select name="tbname" id="tbname">
          <option value=''>------ ѡ�����ݱ� ------</option>
          <?=$retable?>
        </select>
        *</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ѡ����Ŀ</td>
      <td bgcolor="#FFFFFF"><select name="classid" id="select">
          <option value="0">������Ŀ</option>
          <?=$class?>
        </select> <font color="#666666">(��ѡ����Ŀ����ɾ����������Ŀ)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <input name="retype" type="radio" value="0" checked>
        ��ʱ��ɾ��</td>
      <td bgcolor="#FFFFFF">�� 
        <input name="startday" type="text" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        �� 
        <input name="endday" type="text" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        ֮������� <font color="#666666">(����Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><input name="retype" type="radio" value="1">
        ��IDɾ��</td>
      <td bgcolor="#FFFFFF">�� 
        <input name="startid" type="text" id="startid2" value="0" size="6">
        �� 
        <input name="endid" type="text" id="endid2" value="0" size="6">
        ֮������� <font color="#666666">(����ֵ0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�Ƿ����</td>
      <td bgcolor="#FFFFFF"><input name="infost" type="radio" value="0" checked>
        ���� 
        <input name="infost" type="radio" value="1">
        ����� 
        <input name="infost" type="radio" value="2">
        δ���</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�Ƿ��û�����</td>
      <td bgcolor="#FFFFFF"><input name="ismember" type="radio" value="0" checked>
        ���� <input type="radio" name="ismember" value="1">
        �οͷ��� 
        <input type="radio" name="ismember" value="2">
        ��Ա+�û����� 
        <input type="radio" name="ismember" value="3">
        ��Ա���� 
        <input type="radio" name="ismember" value="4">
        �û�����</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�Ƿ��ⲿ����</td>
      <td bgcolor="#FFFFFF"><input name="isurl" type="radio" value="0" checked>
        ���� <input type="radio" name="isurl" value="1">
        �ⲿ������Ϣ 
        <input type="radio" name="isurl" value="2">
        �ڲ���Ϣ</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">����������</td>
      <td bgcolor="#FFFFFF"><input name="plnum" type="text" id="plnum" size="38"> <font color="#666666">(������Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">���������</td>
      <td bgcolor="#FFFFFF"><input name="onclick" type="text" id="onclick" size="38"> <font color="#666666">(������Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">����������</td>
      <td bgcolor="#FFFFFF"><input name="totaldown" type="text" id="totaldown" size="38"> 
        <font color="#666666">(������Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��������ַ�</td>
      <td bgcolor="#FFFFFF"><input name="title" type="text" id="title" size="38"> <font color="#666666">(����ַ��á�|������)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">�������ʺ�ID</td>
      <td bgcolor="#FFFFFF"><select name="usertype" id="usertype">
          <option value="0">��ԱID</option>
          <option value="1">�û�ID</option>
        </select>
        <input name="userids" type="text" id="userids" size="28">
        <font color="#666666">(����á�,�����Ÿ���)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ɾ��HTML�ļ�</td>
      <td bgcolor="#FFFFFF"><input name="delhtml" type="radio" value="0" checked>
        ɾ�� 
        <input type="radio" name="delhtml" value="1">
        ��ɾ�� </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><input type="submit" name="Submit6" value="����ɾ��"> 
        <input name="enews" type="hidden" id="enews2" value="DelInfoData"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25">˵��: ��ԱΪǰ̨ע���Ա���û�Ϊ��̨����Ա��ɾ��������ݲ��ָܻ�,�����ʹ�á�</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
db_close();
$empire=null;
?>
