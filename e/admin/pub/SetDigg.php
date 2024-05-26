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
CheckLevel($logininid,$loginin,$classid,"public");

//����DIGG����
function eSetDigg($add,$userid,$username){
	global $empire,$dbtbpre;
	CheckLevel($userid,$username,$classid,"public");//��֤Ȩ��
	$add['digglevel']=(int)$add['digglevel'];
	$diggcmids=eReturnSetGroups($add['cmid']);
	$diggcmids=hRepPostStr($diggcmids,1);
	
	$sql=$empire->query("update {$dbtbpre}enewspublicadd set digglevel='$add[digglevel]',diggcmids='$diggcmids' limit 1");
	if($sql)
	{
		GetConfig();
		//������־
		insert_dolog("");
		printerror("SetDiggSuccess","SetDigg.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//���DIGG��¼
function eClearDiggRecord($add,$userid,$username){
	global $empire,$dbtbpre,$ecms_config,$public_r;
	//DIGG��¼��
	$empire->query("TRUNCATE `{$dbtbpre}enewsdiggips`;");
	//������־
	insert_dolog("");
	printerror("ClearDiggRecordSuccess",EcmsGetReturnUrl());
}


$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=="SetDigg")//���ò���
{
	eSetDigg($_POST,$logininid,$loginin);
}
elseif($enews=="ClearDiggRecord")//��ռ�¼
{
	@set_time_limit(1000);
	eClearDiggRecord($_GET,$logininid,$loginin);
}
else
{}

$r=$empire->fetch1("select * from {$dbtbpre}enewspublicadd limit 1");

//ϵͳģ��
$mids='';
$i=0;
$modsql=$empire->query("select mid,mname from {$dbtbpre}enewsmod order by myorder,mid");
while($modr=$empire->fetch($modsql))
{
	$i++;
	if($i%4==0)
	{
		$br="<br>";
	}
	else
	{
		$br="";
	}
	$select='';
	if(strstr($r['diggcmids'],','.$modr['mid'].','))
	{
		$select=' checked';
	}
	$mids.="<input type=checkbox name=cmid[] value='$modr[mid]'".$select.">$modr[mname]&nbsp;&nbsp;".$br;
}


db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>DIGG����������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><p>λ�ã�<a href="SetDigg.php<?=$ecms_hashur['whehref']?>">DIGG����������</a></p>
    </td>
  </tr>
</table>
<form name="setpublic" method="post" action="SetDigg.php" onsubmit="return confirm('ȷ������?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">DIGG���������� 
        <input name="enews" type="hidden" value="SetDigg"></td>
    </tr>
	<tr bgcolor="#FFFFFF">
      <td width="18%" height="25">�ظ�������</td>
      <td width="82%"><select name="digglevel" id="digglevel">
        <option value="0"<?=$r['digglevel']==0?' selected':''?>>������ (��һֱ�ظ���)</option>
        <option value="1"<?=$r['digglevel']==1?' selected':''?>>COOKIE��֤ (ͬһ�����COOKIE����ֻ�ܶ�һ��)</option>
        <option value="2"<?=$r['digglevel']==2?' selected':''?>>IP��֤ (ͬһIPֻ�ܶ�һ��)</option>
        <option value="3"<?=$r['digglevel']==3?' selected':''?>>��Ա��֤ (ÿ����Աֻ�ܶ�һ��)</option>
      </select>
        &nbsp;(<strong><a href="SetDigg.php?enews=ClearDiggRecord<?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫ�����֤��¼��');"><u>�������</u></a></strong>�����֤��¼�����������¶�)</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�رն���ϵͳģ��</td>
      <td><?=$mids?></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25" colspan="2"><font color="#666666">˵����<br>
      Ҫ��ϵͳģ��֧�ֶ����ܣ���Ҫ��ģ�ͱ������ֶ���Ϊ��diggtop��������ΪINT���ֶΣ�<br>
      Ҫ��ϵͳģ��֧�ֲȹ��ܣ���Ҫ��ģ�ͱ������ֶ���Ϊ��diggdown��������ΪINT���ֶΡ�</font>      </td>
    </tr>
  </table>
</form>
</body>
</html>
