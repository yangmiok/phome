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
CheckLevel($logininid,$loginin,$classid,"pubvar");
$enews=ehtmlspecialchars($_GET['enews']);
$cid=(int)$_GET['cid'];
$r[myorder]=0;
$url="<a href=ListPubVar.php".$ecms_hashur['whehref'].">������չ����</a>&nbsp;>&nbsp;������չ����";
//�޸�
if($enews=="EditPubVar")
{
	$varid=(int)$_GET['varid'];
	$r=$empire->fetch1("select myvar,varname,varvalue,varsay,classid,tocache,myorder from {$dbtbpre}enewspubvar where varid='$varid'");
	$r[varvalue]=ehtmlspecialchars($r[varvalue]);
	$url="<a href=ListPubVar.php".$ecms_hashur['whehref'].">������չ����</a>&nbsp;>&nbsp;�޸���չ������".$r[myvar];
}
//����
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewspubvarclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$r[classid])
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������չ����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="ListPubVar.php" autocomplete="off">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">������չ���� 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="varid" type="hidden" value="<?=$varid?>"> 
        <input name="cid" type="hidden" value="<?=$cid?>">
        <input name="oldmyvar" type="hidden" id="oldmyvar" value="<?=$r[myvar]?>">
        <input name="oldtocache" type="hidden" id="oldtocache" value="<?=$r[tocache]?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">������(*)</td>
      <td width="81%" height="25"> <input name="myvar" type="text" value="<?=$r[myvar]?>">
        <font color="#666666">(��Ӣ����������ɣ��Ҳ��������ֿ�ͷ���磺&quot;title&quot;)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������</td>
      <td height="25"><select name="classid">
          <option value="0">���������κη���</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit6222322" value="�������" onclick="window.open('PubVarClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">������ʶ(*)</td>
      <td height="25"><input name="varname" type="text" value="<?=$r[varname]?>"> 
        <font color="#666666">(�磺����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">����˵��</td>
      <td height="25"><input name="varsay" type="text" id="varsay" value="<?=$r[varsay]?>" size="60"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�Ƿ�д�뻺��</td>
      <td height="25"><input type="radio" name="tocache" value="1"<?=$r[tocache]==1?' checked':''?>>
        д�뻺�� 
        <input type="radio" name="tocache" value="0"<?=$r[tocache]==0?' checked':''?>>
        ��д�뻺��<font color="#666666">�������ݲ�����д�뻺�棬������ñ�����$public_r['add_������']��</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������</td>
      <td height="25"><input name="myorder" type="text" value="<?=$r[myorder]?>">
        <font color="#666666">(ֵԽС��ʾԽǰ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>����ֵ</strong></td>
      <td height="25">�뽫��������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.varvalue.value);document.form1.varvalue.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('../template/editor.php?<?=$ecms_hashur['ehref']?>&getvar=opener.document.form1.varvalue.value&returnvar=opener.document.form1.varvalue.value&fun=ReturnHtml&notfullpage=1','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <textarea name="varvalue" cols="90" rows="16" wrap="OFF" style="WIDTH: 100%"><?=$r[varvalue]?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> &nbsp; <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
