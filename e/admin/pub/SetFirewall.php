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
CheckLevel($logininid,$loginin,$classid,"firewall");
if($ecms_config['esafe']['openonlinesetting']==0||$ecms_config['esafe']['openonlinesetting']==2)
{
	echo"û�п�����̨�������ò��������Ҫʹ�������������޸�/e/config/config.php�ļ���\$ecms_config['esafe']['openonlinesetting']�������ÿ���";
	exit();
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include('setfun.php');
}
if($enews=='SetFirewall')
{
	SetFirewall($_POST,$logininid,$loginin);
}

db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��վ����ǽ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>λ�ã�<a href="SetFirewall.php<?=$ecms_hashur['whehref']?>">��վ����ǽ</a> 
      <div align="right"> </div></td>
  </tr>
</table>
<form name="setform" method="post" action="SetFirewall.php" onsubmit="return confirm('ȷ������?');" autocomplete="off">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">��վ����ǽ <input name="enews" type="hidden" id="enews" value="SetFirewall"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="left">��������ǽ</div></td>
      <td height="25"><input type="radio" name="fw_open" value="1"<?=$ecms_config['fw']['eopen']==1?' checked':''?>>
        ���� 
        <input type="radio" name="fw_open" value="0"<?=$ecms_config['fw']['eopen']==0?' checked':''?>>
        �ر�</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="17%" height="25"><div align="left">����ǽ������Կ</div></td>
      <td width="83%" height="25"><input name="fw_pass" type="text" id="fw_pass" value="<?=$ecms_config['fw']['epass']?>" size="35">
        <font color="#666666">
        <input type="button" name="Submit3" value="���" onclick="document.setform.fw_pass.value='<?=make_password(36)?>';">
        (��д10~50�������ַ�����ö����ַ����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">
<div align="left">�����̨��½������</div></td>
      <td height="25"><input name="fw_adminloginurl" type="text" id="fw_adminloginurl" value="<?=$ecms_config['fw']['adminloginurl']?>" size="35">
        <font color="#666666"><br>
        (���ú����ͨ������������ܷ��ʺ�̨���磺http://admin.phome.net)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����½��̨��ʱ���<br> <font color="#666666">(��ѡΪ������)</font></td>
      <td height="25"><table width="500" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="0"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',0,')?' checked':''?>>
              0��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="1"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',1,')?' checked':''?>>
              1��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="2"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',2,')?' checked':''?>>
              2��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="3"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',3,')?' checked':''?>>
              3��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="4"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',4,')?' checked':''?>>
              4��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="5"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',5,')?' checked':''?>>
              5��</td>
          </tr>
          <tr> 
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="6"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',6,')?' checked':''?>>
              6��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="7"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',7,')?' checked':''?>>
              7��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="8"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',8,')?' checked':''?>>
              8��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="9"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',9,')?' checked':''?>>
              9��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="10"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',10,')?' checked':''?>>
              10��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="11"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',11,')?' checked':''?>>
              11��</td>
          </tr>
          <tr> 
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="12"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',12,')?' checked':''?>>
              12��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="13"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',13,')?' checked':''?>>
              13��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="14"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',14,')?' checked':''?>>
              14��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="15"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',15,')?' checked':''?>>
              15��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="16"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',16,')?' checked':''?>>
              16��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="17"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',17,')?' checked':''?>>
              17��</td>
          </tr>
          <tr> 
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="18"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',18,')?' checked':''?>>
              18��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="19"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',19,')?' checked':''?>>
              19��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="20"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',20,')?' checked':''?>>
              20��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="21"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',21,')?' checked':''?>>
              21��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="22"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',22,')?' checked':''?>>
              22��</td>
            <td><input name="fw_adminhour[]" type="checkbox" id="fw_adminhour[]" value="23"<?=strstr(','.$ecms_config['fw']['adminhour'].',',',23,')?' checked':''?>>
              23��</td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����½��̨������<br> <font color="#666666">(��ѡΪ������)</font> </td>
      <td height="25"><table width="500" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td><input name="fw_adminweek[]" type="checkbox" id="fw_adminweek[]" value="1"<?=strstr(','.$ecms_config['fw']['adminweek'].',',',1,')?' checked':''?>>
              ����һ</td>
            <td><input name="fw_adminweek[]" type="checkbox" id="fw_adminweek[]" value="2"<?=strstr(','.$ecms_config['fw']['adminweek'].',',',2,')?' checked':''?>>
              ���ڶ�</td>
            <td><input name="fw_adminweek[]" type="checkbox" id="fw_adminweek[]" value="3"<?=strstr(','.$ecms_config['fw']['adminweek'].',',',3,')?' checked':''?>>
              ������</td>
            <td><input name="fw_adminweek[]" type="checkbox" id="fw_adminweek[]" value="4"<?=strstr(','.$ecms_config['fw']['adminweek'].',',',4,')?' checked':''?>>
              ������</td>
          </tr>
          <tr> 
            <td><input name="fw_adminweek[]" type="checkbox" id="fw_adminweek[]" value="5"<?=strstr(','.$ecms_config['fw']['adminweek'].',',',5,')?' checked':''?>>
              ������</td>
            <td><input name="fw_adminweek[]" type="checkbox" id="fw_adminweek[]" value="6"<?=strstr(','.$ecms_config['fw']['adminweek'].',',',6,')?' checked':''?>>
              ������</td>
            <td><input name="fw_adminweek[]" type="checkbox" id="fw_adminweek[]" value="0"<?=strstr(','.$ecms_config['fw']['adminweek'].',',',0,')?' checked':''?>>
              ������</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ǽ��̨Ԥ��½��֤������</td>
      <td height="25"><input name="fw_adminckpassvar" type="text" id="fw_pass3" value="<?=$ecms_config['fw']['adminckpassvar']?>" size="35">
        <font color="#666666">(��Ӣ����ĸ���,5~20���ַ����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ǽ��̨Ԥ��½��֤��</td>
      <td height="25"><input name="fw_adminckpassval" type="text" id="fw_adminckpassval" value="<?=$ecms_config['fw']['adminckpassval']?>" size="35">
        <font color="#666666">
        <input type="button" name="Submit32" value="���" onclick="document.setform.fw_adminckpassval.value='<?=make_password(36)?>';">
        (��д10~50�������ַ�����ö����ַ����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">
<div align="left">�����ύ�����ַ�<br>
          <font color="#666666">(��������ǰ̨�����ύ���ݼ���̨��½����)<br>
          (1)������á�,����Ƕ��Ÿ�����<br>
          (2)��ͬʱ��������ʱ���ο���˫��#���������硰upd##te,select����</font></div></td>
      <td height="25"><textarea name="fw_cleargettext" cols="80" rows="8" style="WIDTH: 100%" id="fw_cleargettext"><?=ehtmlspecialchars($ecms_config['fw']['cleargettext'])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"></td>
      <td height="25"><input type="submit" name="Submit" value=" �� �� "> &nbsp;&nbsp;&nbsp; 
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
