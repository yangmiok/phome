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
CheckLevel($logininid,$loginin,$classid,"loadcj");
$from=(int)$_GET['from'];
if($from)
{
	$listclasslink="ListPageInfoClass.php";
}
else
{
	$listclasslink="ListInfoClass.php";
}
$url="<a href=../".$listclasslink.$ecms_hashur['whehref'].">����ɼ�</a>&nbsp;>&nbsp;����ɼ�����";
//--------------------��������Ŀ
$fcfile="../../data/fc/ListEnews.php";
$do_class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$do_class=ShowClass_AddClass("","n",0,"|-",0,0);}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ɼ�����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>
<form action="../ecmscj.php" method="post" enctype="multipart/form-data" name="form1" onsubmit="return confirm('ȷ��Ҫ���룿');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td height="25"><div align="center">����ɼ����� 
          <input name="enews" type="hidden" id="enews" value="LoadInCj">
		  <?=$ecms_hashur['form']?>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><table width="650" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="29%"><div align="right">ѡ��ɼ�������Ŀ��</div></td>
            <td width="71%" height="27"><select name="classid" id="classid">
            <option value='0'>ѡ����Ŀ</option>
            <?=$do_class?>
          </select> 
              <font color="#666666">(Ҫѡ���ռ���Ŀ)</font></td>
          </tr>
          <tr> 
            <td height="27"> <div align="right">����ɼ������ļ���</div></td>
            <td height="27"><input type="file" name="file">
              <font color="#666666">(*.cj)</font> </td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25"><div align="center">
          <input type="submit" name="Submit" value="���ϵ���">
          &nbsp;&nbsp;
          <input type="reset" name="Submit2" value="����">
		  <input type="hidden" name="from" value="<?=$from?>">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>