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
CheckLevel($logininid,$loginin,$classid,"infodoc");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=InfoDoc.php".$ecms_hashur['whehref'].">��Ϣ�����鵵</a>";
//--------------------��������Ŀ
$fcfile="../data/fc/ListEnews.php";
$do_class="<script src=../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$do_class=ShowClass_AddClass("","n",0,"|-",0,0);}
//��
$selecttable="";
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable order by tid");
while($tr=$empire->fetch($tsql))
{
	$selecttable.="<option value='".$tr[tbname]."'>".$tr[tname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ϣ�����鵵</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form name="form1" method="get" action="ecmsinfo.php" onsubmit="return confirm('ȷ��Ҫִ�д˲�����');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">��Ϣ�����鵵 
          <input name="enews" type="hidden" id="enews" value="InfoToDoc">
          <input name="ecmsdoc" type="hidden" id="ecmsdoc" value="2">
          <input name="docfrom" type="hidden" id="docfrom" value="InfoDoc.php<?=$ecms_hashur['whehref']?>">
        </div></td>
    </tr>
    <tr> 
      <td width="28%" height="25" valign="top" bgcolor="#FFFFFF">
<div align="center"> 
          <p> 
            <select name="classid[]" size="21" multiple id="classid[]" style="width:200">
              <?=$do_class?>
            </select>
          </p>
          </div></td>
      <td width="72%" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
          <tr bgcolor="#FFFFFF"> 
            <td width="26%" height="32">�鵵���ݱ�</td>
            <td width="74%"><select name="tbname" id="tbname">
                <option value=''>------ ѡ�����ݱ� ------</option>
                <?=$selecttable?>
              </select></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="32"> <input name="retype" type="radio" value="0" checked>
              �������鵵 </td>
            <td>�鵵���� <input name="doctime" type="text" id="doctime" value="100" size="6">
              �����Ϣ</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="32">&nbsp;</td>
            <td>��ԭ�鵵С��
              <input name="doctime1" type="text" id="doctime1" value="100" size="6">
              �����Ϣ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="32"> <input name="retype" type="radio" value="1">
              ��ʱ��鵵</td>
            <td>�� 
              <input name="startday" type="text" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
              �� 
              <input name="endday" type="text" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
              ֮�����Ϣ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="32"> <input name="retype" type="radio" value="2">
              ��ID�鵵</td>
            <td>�� 
              <input name="startid" type="text" value="0" size="6">
              �� 
              <input name="endid" type="text" value="0" size="6">
              ֮�����Ϣ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="32">ִ�в���</td>
            <td><input name="doing" type="radio" value="0" checked>
              �鵵 <input type="radio" name="doing" value="1">
              ��ԭ�鵵</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="32">&nbsp;</td>
            <td><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="32" colspan="2"> <font color="#666666"><strong>˵��:</strong><br>
              ѡ������Ŀ����CTRL/SHIFT<br>
              ����鵵��ʼʱ����ID��������������</font></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
