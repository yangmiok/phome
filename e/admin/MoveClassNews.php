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
CheckLevel($logininid,$loginin,$classid,"movenews");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=MoveClassNews.php".$ecms_hashur['whehref'].">����ת����Ϣ</a>";
//--------------------��������Ŀ
$fcfile="../data/fc/ListEnews.php";
$do_class="<script src=../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$do_class=ShowClass_AddClass("","n",0,"|-",0,0);}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ת����Ϣ</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="ecmsinfo.php" onsubmit="return confirm('ȷ��Ҫִ�д˲�����');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">����ת����Ŀ��Ϣ</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">�� 
          <select name="add[classid]" id="add[classid]">
            <option value=0>��ѡ��ԭ��Ϣ��Ŀ</option><?=$do_class?>
          </select>
          ����Ϣת�Ƶ� 
          <select name="add[toclassid]" id="add[toclassid]">
            <option value=0>��ѡ��Ŀ����Ϣ��Ŀ</option><?=$do_class?>
          </select>
          ��Ŀ 
          <input type="submit" name="Submit" value="ת��">
          <input name="enews" type="hidden" id="enews" value="MoveClassNews">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
