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
CheckLevel($logininid,$loginin,$classid,"searchall");
$r=$empire->fetch1("select openschall,schallfield,schallminlen,schallmaxlen,schallnotcid,schallnum,schallpagenum,schalltime from {$dbtbpre}enewspublic limit 1");
$schallnotcid=substr($r[schallnotcid],1,strlen($r[schallnotcid])-2);
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ȫվ��������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href="ListSearchLoadTb.php<?=$ecms_hashur['whehref']?>">����ȫվ��������Դ</a>&nbsp;->&nbsp;ȫվ��������
    </td>
  </tr>
</table>
<form name="searchset" method="post" action="ListSearchLoadTb.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">ȫվ�������� 
        <input name=enews type=hidden value=SetSearchAll></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������</td>
      <td height="25"><input type="radio" name="openschall" value="1"<?=$r[openschall]==1?' checked':''?>>
        �� 
        <input type="radio" name="openschall" value="0"<?=$r[openschall]==0?' checked':''?>>
        �� </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">������Χ��</td>
      <td width="81%" height="25"><select name="schallfield" id="schallfield">
          <option value="1"<?=$r[schallfield]==1?' selected':''?>>���������ȫ��</option>
          <option value="2"<?=$r[schallfield]==2?' selected':''?>>��������</option>
          <option value="3"<?=$r[schallfield]==3?' selected':''?>>����ȫ��</option>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����ؼ��ֳ��ȣ�</td>
      <td height="25">�� 
        <input name="schallminlen" type="text" id="schallminlen" value="<?=$r[schallminlen]?>" size="6">
        ���ַ��� 
        <input name="schallmaxlen" type="text" id="schallmaxlen" value="<?=$r[schallmaxlen]?>" size="6">
        ���ַ�֮�� </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">����ʱ������</td>
      <td height="25">�� 
        <input name="schalltime" type="text" id="schalltime" value="<?=$r[schalltime]?>" size="6">
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ҳ����ʾ��</td>
      <td height="25">ÿҳ 
        <input name="schallnum" type="text" id="schallnum" value="<?=$r[schallnum]?>" size="6">
        ��ʾ����¼�� 
        <input name="schallpagenum" type="text" id="schallpagenum" value="<?=$r[schallpagenum]?>" size="6">
        ����ҳ����<font color="#666666">&nbsp;</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������������ռ���Ŀ��</td>
      <td height="25"><input name="schallnotcid" type="text" id="schallnotcid" value="<?=$schallnotcid?>"> 
        <font color="#666666">(��ʽ����ĿID1,��ĿID2...�����&quot;,&quot;��)</font> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25">ȫվ�������Ե�ַ��<a href="<?=$public_r[newsurl].'e/sch/sch.html'?>" target="_blank">
        <?=$public_r[newsurl].'e/sch/sch.html'?>
        </a></td>
    </tr>
  </table>
</form>
</body>
</html>
