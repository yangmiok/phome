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
$r=$empire->fetch1("select * from {$dbtbpre}enewspl_set limit 1");
//����Ȩ��
$plgroup='';
$mgsql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($mgr=$empire->fetch($mgsql))
{
	if($r[plgroupid]==$mgr[groupid])
	{
		$plgroup_select=' selected';
	}
	else
	{
		$plgroup_select='';
	}
	$plgroup.="<option value=".$mgr[groupid].$plgroup_select.">".$mgr[groupname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���۲�������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><p>λ�ã����۲�������</p>
      </td>
  </tr>
</table>
<form name="plset" method="post" action="../ecmspl.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">���۲������� 
        <input name=enews type=hidden value=SetPl></td>
    </tr>
	<tr>
      <td height="25" bgcolor="#FFFFFF">���۵�ַ</td>
      <td height="25" bgcolor="#FFFFFF"><input name="plurl" type="text" id="plurl" value="<?=$r[plurl]?>" size="38">
        <font color="#666666">(������ʱ���ã���β��ӡ�/�����磺/e/pl/)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����Ȩ������</td>
      <td height="25"><select name="plgroupid" id="plgroupid">
          <option value=0>�ο�</option>
          <?=$plgroup?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">������������</td>
      <td width="81%" height="25"><input name="plsize" type="text" id="plsize" value="<?=$r[plsize]?>" size="38">
        ���ֽ�<font color="#666666"> (�����ֽ�Ϊһ������)</font> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ʱ����</td>
      <td height="25"><input name="pltime" type="text" id="pltime" value="<?=$r[pltime]?>" size="38">
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">������֤��</td>
      <td height="25"><input type="radio" name="plkey_ok" value="1"<?=$r[plkey_ok]==1?' checked':''?>>
        ���� 
        <input type="radio" name="plkey_ok" value="0"<?=$r[plkey_ok]==0?' checked':''?>>
        �ر�</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ÿҳ��ʾ</td>
      <td height="25"><input name="pl_num" type="text" id="pl_num" value="<?=$r[pl_num]?>" size="38">
        ������</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">���۱���ÿ����ʾ</td>
      <td height="25"><input name="plfacenum" type="text" id="plfacenum" value="<?=$r[plfacenum]?>" size="38">
        ������</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">���������ַ�<br> <font color="#666666">(1)������á�|���������硰�ַ�1|�ַ�2����<br>
        (2)��ͬʱ��������ʱ���ο���˫��#���������硰��##��|�ַ�2�� ������ֻҪ����ͬʱ�������ơ��͡��⡱�ֶ��ᱻ���Ρ�</font></td>
      <td height="25"><textarea name="plclosewords" cols="80" rows="8" id="plclosewords"><?=ehtmlspecialchars($r[plclosewords])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">���۸�¥���¥��</td>
      <td height="25"><input name="plmaxfloor" type="text" id="plmaxfloor" value="<?=$r[plmaxfloor]?>" size="38">
        ¥ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25" valign="top">�����������ݸ�ʽ��<br>
      <br>
      ����ID��[!--plid--]<br>
      �����ߣ�[!--username--]<br>
      �������ݣ�[!--pltext--]<br>
      ����ʱ�䣺[!--pltime--]</td>
      <td height="25"><textarea name="plquotetemp" cols="80" rows="8" id="plquotetemp"><?=ehtmlspecialchars(stripSlashes($r[plquotetemp]))?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
