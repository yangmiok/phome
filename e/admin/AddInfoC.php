<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
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
CheckLevel($logininid,$loginin,$classid,"cj");
//--------------------��������Ŀ
$fcfile="../data/fc/ListEnews.php";
$do_class="<script src=../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$do_class=ShowClass_AddClass("","n",0,"|-",0,0);}
db_close();
$empire=null;
if($_GET['from'])
{
	$listclasslink="ListPageInfoClass.php";
}
else
{
	$listclasslink="ListInfoClass.php";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���Ӳɼ��ڵ�</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function changecj(obj)
{
	if(obj.newsclassid.value=="nono")
	{
		alert("��ѡ����Ŀ");
	}
	else
	{
		self.location.href='AddInfoClass.php?<?=$ecms_hashur['ehref']?>&enews=AddInfoClass&from=<?=RepPostStr($_GET['from'],1)?>&newsclassid='+obj.newsclassid.value;
	}
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã��ɼ�&nbsp;&gt;&nbsp;<a href='<?=$listclasslink?><?=$ecms_hashur['whehref']?>'>����ڵ�</a>&nbsp;&gt;&nbsp;���ӽڵ�</td>
  </tr>
</table>

<form name="form1" method="post" action="enews.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['eform']?>
    <tr class="header"> 
      <td height="25"><div align="center">��ѡ��Ҫ���Ӳɼ�����Ŀ</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center"> 
          <select name="newsclassid" id="newsclassid" onchange='javascript:changecj(document.form1);'>
            <option value=''>ѡ����Ŀ</option>
            <option value='0'>�ǲɼ��ڵ�(���ڵ�)</option>
            <?=$do_class?>
          </select>
        </div></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><div align="center"><font color="#666666">(�ɼ��ڵ�Ҫѡ���ռ���Ŀ)</font></div></td>
    </tr>
  </table>
</form>
</body>
</html>
