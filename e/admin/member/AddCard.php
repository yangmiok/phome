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
$time=ehtmlspecialchars($_GET['time']);
$r[money]=10;
$r[cardfen]=0;
$r[carddate]=0;
$r[endtime]="0000-00-00";
$r[card_no]=time();
$r[password]=strtolower(no_make_password(6));
$url="<a href=ListCard.php".$ecms_hashur['whehref'].">����㿨</a> &gt; ���ӵ㿨";
if($enews=="EditCard")
{
	$cardid=(int)$_GET['cardid'];
	$r=$empire->fetch1("select card_no,password,money,cardfen,endtime,carddate,cdgroupid,cdzgroupid from {$dbtbpre}enewscard where cardid='$cardid' limit 1");
	$url="<a href=ListCard.php".$ecms_hashur['whehref'].">����㿨</a> &gt; �޸ĵ㿨��<b>".$r[card_no]."</b>";
}
//----------��Ա��
$sql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($level_r=$empire->fetch($sql))
{
	if($r[cdgroupid]==$level_r[groupid])
	{$select=" selected";}
	else
	{$select="";}
	$group.="<option value=".$level_r[groupid].$select.">".$level_r[groupname]."</option>";
	if($r[cdzgroupid]==$level_r[groupid])
	{$zselect=" selected";}
	else
	{$zselect="";}
	$zgroup.="<option value=".$level_r[groupid].$zselect.">".$level_r[groupname]."</option>";
}
$href="AddCard.php?enews=$enews&cardid=$cardid".$ecms_hashur['ehref'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���ӵ㿨</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="98%%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListCard.php" autocomplete="off">
  <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">���ӵ㿨 
          <input name="enews" type="hidden" id="enews" value="<?=$enews?>">
          <input name="add[cardid]" type="hidden" id="add[cardid]" value="<?=$cardid?>">
          <input name="time" type="hidden" id="time" value="<?=$time?>">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="36%" height="25">�㿨�ʺţ�</td>
      <td width="64%" height="25"><input name="add[card_no]" type="text" id="add[card_no]" value="<?=$r[card_no]?>">
        <font color="#666666">(&lt;30λ��֧��Ӣ�����������)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�㿨���룺</td>
      <td height="25"><input name="add[password]" type="text" id="add[password]" value="<?=$r[password]?>">
        <font color="#666666">(&lt;20λ��֧��Ӣ�����������)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�㿨��</td>
      <td height="25"><input name="add[money]" type="text" id="add[money]" value="<?=$r[money]?>" size="6">
        Ԫ</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">������</td>
      <td height="25"><input name="add[cardfen]" type="text" id="add[cardfen]" value="<?=$r[cardfen]?>" size="6">
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="3">��ֵ��Ч��:</td>
      <td height="25"><input name="add[carddate]" type="text" id="add[carddate]" value="<?=$r[carddate]?>" size="6">
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ֵ����ת���Ա��:
        <select name="add[cdgroupid]" id="add[cdgroupid]">
		<option value=0>������</option>
		<?=$group?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">���ں�ת��Ļ�Ա��:
	  	<select name="add[cdzgroupid]" id="add[cdzgroupid]">
		<option value=0>������</option>
		<?=$zgroup?>
        </select>
	  </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ʱ�䣺</td>
      <td height="25"><input name="add[endtime]" type="text" id="add[endtime]" value="<?=$r[endtime]?>" size="20" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        <font color="#666666">(0000-00-00Ϊ������)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <input type="submit" name="Submit" value="�ύ">
          &nbsp; 
          <input type="reset" name="Submit2" value="����">
          &nbsp; 
          <input type="button" name="Submit3" value="�������" onclick="javascript:self.location.href='<?=$href?>'">
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