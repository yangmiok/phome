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
CheckLevel($logininid,$loginin,$classid,"buygroup");
$enews=ehtmlspecialchars($_GET['enews']);
$r[gmoney]=10;
$r[gfen]=0;
$r[gdate]=0;
$url="<a href=ListBuyGroup.php".$ecms_hashur['whehref'].">�����ֵ����</a> &gt; ���ӳ�ֵ����";
if($enews=="EditBuyGroup")
{
	$id=(int)$_GET['id'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsbuygroup where id='$id' limit 1");
	$url="<a href=ListBuyGroup.php".$ecms_hashur['whehref'].">�����ֵ����</a> &gt; �޸ĳ�ֵ����";
}
//----------��Ա��
$sql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($level_r=$empire->fetch($sql))
{
	if($r[ggroupid]==$level_r[groupid])
	{$select=" selected";}
	else
	{$select="";}
	$group.="<option value=".$level_r[groupid].$select.">".$level_r[groupname]."</option>";
	if($r[gzgroupid]==$level_r[groupid])
	{$zselect=" selected";}
	else
	{$zselect="";}
	$zgroup.="<option value=".$level_r[groupid].$zselect.">".$level_r[groupname]."</option>";
	if($r[buygroupid]==$level_r[groupid])
	{$bselect=" selected";}
	else
	{$bselect="";}
	$buygroup.="<option value=".$level_r[groupid].$bselect.">".$level_r[groupname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���ӳ�ֵ����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListBuyGroup.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">���ӳ�ֵ���� 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="id" type="hidden" id="id" value="<?=$id?>"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="25%" height="25">�������ƣ�</td>
      <td width="75%" height="25"><input name="gname" type="text" id="gname" value="<?=$r[gname]?>" size="35"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����</td>
      <td height="25"><input name="gmoney" type="text" id="gmoney" value="<?=$r[gmoney]?>" size="35">
        Ԫ</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ֵ������</td>
      <td height="25"><input name="gfen" type="text" id="gfen" value="<?=$r[gfen]?>" size="35">
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="3">��ֵ��Ч�ڣ�</td>
      <td height="25"><input name="gdate" type="text" id="gdate" value="<?=$r[gdate]?>" size="35">
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ֵ����ת���Ա��: 
        <select name="ggroupid" id="ggroupid">
          <option value=0>������</option>
          <?=$group?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">���ں�ת��Ļ�Ա��: 
        <select name="gzgroupid" id="gzgroupid">
          <option value=0>������</option>
          <?=$zgroup?>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��ʾ˳��</td>
      <td height="25"><input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>" size="35">
        <font color="#666666">(ֵԽС��ʾԽǰ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�ɹ���Ļ�Ա�飺</td>
      <td height="25"><select name="buygroupid" id="buygroupid">
          <option value=0>������</option>
          <?=$buygroup?>
        </select>
        <font color="#666666">(��Ա��Ȩ��ֵ����ѡ��Ļ�Ա�鶼���Թ���)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����˵����</td>
      <td height="25"><textarea name="gsay" cols="65" rows="6" id="gsay"><?=ehtmlspecialchars($r[gsay])?></textarea></td>
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