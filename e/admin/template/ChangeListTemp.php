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
CheckLevel($logininid,$loginin,$classid,"template");
$url="<a href=ChangeListTemp.php".$ecms_hashur['whehref'].">����������Ŀ�б�ģ��</a>";
//��Ŀ
$fcfile="../../data/fc/ListEnews.php";
$class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
//�б�ģ��
$listtemp="";
$sql=$empire->query("select mname,mid from {$dbtbpre}enewsmod order by myorder,mid");
while($r=$empire->fetch($sql))
{
	$listtemp.="<option value=0 style='background:#99C4E3'>".$r[mname]."</option>";
	$sql1=$empire->query("select tempname,tempid from ".GetTemptb("enewslisttemp")." where modid='$r[mid]'");
	while($r1=$empire->fetch($sql1))
	{
		$listtemp.="<option value='".$r1[tempid]."'>|-".$r1[tempname]."</option>";
	}
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����������Ŀ�б�ģ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="../ecmstemp.php" onsubmit="return confirm('ȷ��Ҫ������');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">����������Ŀ�б�ģ�� 
        <input name="enews" type="hidden" id="enews" value="ChangeClassListtemp"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="15%" height="25">������Ŀ��</td>
      <td width="85%" height="25"><select name="classid" size="16" id="classid" style="width:220">
          <option selected>������Ŀ</option>
          <?=$class?>
        </select> <font color="#666666">����ѡ����Ŀ����Ӧ������������Ŀ��</font> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�µ��б�ģ�壺</td>
      <td height="25"><select name="listtempid" id="listtempid">
          <option value=0>ѡ���б�ģ��</option>
		  <?=$listtemp?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
