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
CheckLevel($logininid,$loginin,$classid,"f");
$fid=(int)$_GET['fid'];
$tid=(int)$_GET['tid'];
$tbname=RepPostVar($_GET['tbname']);
if(!$fid||!$tid||!$tbname)
{
	printerror("ErrorUrl","history.go(-1)");
}
$fr=$empire->fetch1("select fid,f,fname,isadd,tid,tbname,tbdataf from {$dbtbpre}enewsf where fid='$fid'");
if(!$fr[fid])
{
	printerror("ErrorUrl","history.go(-1)");
}
if(empty($fr[isadd]))
{
	printerror("NotIsAdd","history.go(-1)");
}
$tid=$fr[tid];
$tbname=$fr[tbname];
if($fr[tbdataf])
{
	$doing='�ֶ�ת�Ƶ�����';
}
else
{
	$doing='�ֶ�ת�Ƶ�����';
}
$url="���ݱ�:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListF.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">�ֶι���</a>&nbsp;>&nbsp;".$doing;
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ת���ֶ�</title>
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
<form action="../ecmsmod.php" method="GET" enctype="multipart/form-data" name="form1" onsubmit="return confirm('ȷ��Ҫת��?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" colspan="2" class="header"> 
        <?=$doing?>
      </td>
    </tr>
    <tr> 
      <td width="28%" height="25" bgcolor="#FFFFFF">���ݱ�:</td>
      <td width="72%" height="25" bgcolor="#FFFFFF"> <strong> 
        <?=$dbtbpre?>
        ecms_ 
        <?=$tbname?>
        </strong></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�ֶ���:</td>
      <td height="25" bgcolor="#FFFFFF"><strong> 
        <?=$fr[f]?>
        </strong>&nbsp;( 
        <?=$fr[fname]?>
        )</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ÿ��ת������:</td>
      <td height="25" bgcolor="#FFFFFF"><input name="line" type="text" id="line" value="200"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="��ʼת��"> 
        <input name="enews" type="hidden" id="enews" value="ChangeDataTableF"> 
        <input name="tid" type="hidden" id="tid" value="<?=$tid?>"> <input name="tbname" type="hidden" id="tbname" value="<?=$tbname?>"> 
        <input name="fid" type="hidden" id="fid" value="<?=$fid?>"></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><font color="#666666">˵����ת��ǰ�����ȱ������ݡ�</font></td>
    </tr>
  </table>
</form>
</body>
</html>
