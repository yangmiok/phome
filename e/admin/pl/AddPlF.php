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
CheckLevel($logininid,$loginin,$classid,"plf");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListAllPl.php".$ecms_hashur['whehref'].">��������</a>&nbsp;>&nbsp;<a href=ListPlF.php".$ecms_hashur['whehref'].">���������Զ����ֶ�</a>&nbsp;>&nbsp;�����ֶ�";
//�޸��ֶ�
if($enews=="EditPlF")
{
	$fid=(int)$_GET['fid'];
	$url="<a href=ListAllPl.php".$ecms_hashur['whehref'].">��������</a>&nbsp;>&nbsp;<a href=ListPlF.php".$ecms_hashur['whehref'].">���������Զ����ֶ�</a>&nbsp;>&nbsp;�޸��ֶ�";
	$r=$empire->fetch1("select * from {$dbtbpre}enewsplf where fid='$fid'");
	if(!$r[fid])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$oftype="type".$r[ftype];
	$$oftype=" selected";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����ֶ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmspl.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" colspan="2" class="header">����/�޸��ֶ� 
        <input name="fid" type="hidden" id="fid" value="<?=$fid?>"> <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="oldf" type="hidden" id="oldf" value="<?=$r[f]?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="25%" height="25">�ֶ���</td>
      <td width="75%" height="25"><input name="f" type="text" id="f" value="<?=$r[f]?>"> 
        <font color="#666666">(���磺&quot;title&quot;)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�ֶα�ʶ</td>
      <td height="25"><input name="fname" type="text" id="fname" value="<?=$r[fname]?>"> 
        <font color="#666666">(���磺&quot;����&quot;)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�ֶ�����</td>
      <td height="25"><select name="ftype" id="select">
          <option value="VARCHAR"<?=$typeVARCHAR?>>�ַ���0-255�ֽ�(VARCHAR)</option>
          <option value="TEXT"<?=$typeTEXT?>>С���ַ���(TEXT)</option>
          <option value="MEDIUMTEXT"<?=$typeMEDIUMTEXT?>>�����ַ���(MEDIUMTEXT)</option>
          <option value="LONGTEXT"<?=$typeLONGTEXT?>>�����ַ���(LONGTEXT)</option>
          <option value="TINYINT"<?=$typeTINYINT?>>С��ֵ��(TINYINT)</option>
          <option value="SMALLINT"<?=$typeSMALLINT?>>����ֵ��(SMALLINT)</option>
          <option value="INT"<?=$typeINT?>>����ֵ��(INT)</option>
          <option value="BIGINT"<?=$typeBIGINT?>>������ֵ��(BIGINT)</option>
          <option value="FLOAT"<?=$typeFLOAT?>>��ֵ������(FLOAT)</option>
          <option value="DOUBLE"<?=$typeDOUBLE?>>��ֵ˫������(DOUBLE)</option>
        </select>
        �ֶγ��� 
        <input name="flen" type="text" id="flen" value="<?=$r[flen]?>" size="6"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">������</td>
      <td height="25"><input type="radio" name="ismust" value="1"<?=$r[ismust]==1?' checked':''?>>
        �� 
        <input type="radio" name="ismust" value="0"<?=$r[ismust]==0?' checked':''?>>
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">ע�ͣ�</td>
      <td height="25"><textarea name="fzs" cols="65" rows="10" id="fzs"><?=stripSlashes($r[fzs])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
