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
CheckLevel($logininid,$loginin,$classid,"memberf");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href='ListMemberF.php".$ecms_hashur['whehref']."'>�����Ա�ֶ�</a>&nbsp;>&nbsp;���ӻ�Ա�ֶ�";
$postword='�����ֶ�';
$r[myorder]=0;
//�޸��ֶ�
if($enews=="EditMemberF")
{
	$fid=(int)$_GET['fid'];
	$url="<a href='ListMemberF.php".$ecms_hashur['whehref']."'>�����Ա�ֶ�</a>&nbsp;>&nbsp;�޸Ļ�Ա�ֶ�";
	$postword='�޸��ֶ�';
	$r=$empire->fetch1("select * from {$dbtbpre}enewsmemberf where fid='$fid'");
	if(!$r[fid])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$oftype="type".$r[ftype];
	$$oftype=" selected";
	$ofform="form".$r[fform];
	$$ofform=" selected";
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
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmsmember.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" colspan="2" class="header"> 
        <?=$postword?>
        <input name="fid" type="hidden" id="fid" value="<?=$fid?>"> <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="oldfform" type="hidden" id="oldfform" value="<?=$r[fform]?>"> 
        <input name="oldf" type="hidden" id="oldf" value="<?=$r[f]?>"> <input name="oldfvalue" type="hidden" id="oldfvalue" value="<?=$r[fvalue]?>">
        <input name="oldfformsize" type="hidden" id="oldfformsize" value="<?=$r[fformsize]?>"></td>
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
      <td rowspan="2">�������ʾԪ��</td>
      <td height="25"><select name="fform" id="fform">
          <option value="text"<?=$formtext?>>�����ı���(text)</option>
          <option value="password"<?=$formpassword?>>�����(password)</option>
          <option value="select"<?=$formselect?>>������(select)</option>
          <option value="radio"<?=$formradio?>>��ѡ��(radio)</option>
		  <option value="checkbox"<?=$formcheckbox?>>��ѡ��(checkbox)</option>
          <option value="textarea"<?=$formtextarea?>>�����ı���(textarea)</option>
          <option value="img"<?=$formimg?>>ͼƬ(img)</option>
          <option value="file"<?=$formfile?>>�ļ�(file)</option>
        </select>
        Ԫ�س��� 
        <input name="fformsize" type="text" id="fformsize" value="<?=$r[fformsize]?>" size="12"> 
        <font color="#666666">(��Ϊ��Ĭ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><font color="#666666">˵������������ǡ������ı��򡱣������������ö��Ÿ񿪣��硰60,6��.</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">��ʼֵ<br>
        <font color="#666666"><span id="defvaldiv">(���ֵ��&quot;�س�&quot;�񿪣�<br>
        Ĭ��ѡ�����ӣ�:default)</span></font></td>
      <td height="25"><textarea name="fvalue" cols="65" rows="8" id="fvalue" style="WIDTH: 100%"><?=str_replace("|","\r\n",$r[fvalue])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ʾ˳��</td>
      <td height="25"><input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>" size="6"> 
        <font color="#666666">(����ԽСԽǰ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">������滻html����<br> <font color="#666666">(�����ֶ�ʱ������)</font></td>
      <td height="25"><textarea name="fhtml" cols="65" rows="10" id="fhtml" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[fhtml]))?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">ע��</td>
      <td height="25"><textarea name="fzs" cols="65" rows="10" id="fzs" style="WIDTH: 100%"><?=stripSlashes($r[fzs])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
