<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
//��֤�û�
$lur=is_login();
$logininid=(int)$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

$user_r=$empire->fetch1("select adminclass,groupid from {$dbtbpre}enewsuser where userid='$logininid'");
//�û���Ȩ��
$gr=$empire->fetch1("select doall from {$dbtbpre}enewsgroup where groupid='$user_r[groupid]'");
if($gr['doall'])
{
	$jsfile='../data/fc/cmsclass.js';
}
else
{
	$jsfile='../data/fc/userclass'.$logininid.'.js';
}
//��������Ŀ
$fcfile="../data/fc/ListEnews.php";
$do_class="<script src=".$jsfile."?".time()."></script>";
if(!file_exists($fcfile))
{$do_class=ShowClass_AddClass("","n",0,"|-",0,0);}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������Ϣ</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function changeclass(obj)
{
	if(obj.addclassid.value=="")
	{
		alert("��ѡ����Ŀ");
	}
	else
	{
		self.location.href='AddNews.php?<?=$ecms_hashur['ehref']?>&enews=AddNews&classid='+obj.addclassid.value;
	}
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<a href='ListAllInfo.php<?=$ecms_hashur['whehref']?>'>������Ϣ</a>&nbsp;&gt;&nbsp;������Ϣ</td>
  </tr>
</table>

<form name="form1" method="post" action="enews.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['eform']?>
    <tr class="header"> 
      <td height="25"><div align="center">��ѡ��Ҫ������Ϣ���ռ���Ŀ</div></td>
    </tr>
    <tr> 
      <td height="38" bgcolor="#FFFFFF">
<div align="center"> 
          <select name="addclassid" size="26" id="addclassid" onchange='javascript:changeclass(document.form1);' style="width:420">
            <?=$do_class?>
          </select>
        </div></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><div align="center"><font color="#666666">˵������ɫ������Ŀ��Ϊ�ռ���Ŀ��</font></div></td>
    </tr>
  </table>
</form>
</body>
</html>
