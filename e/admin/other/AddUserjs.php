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
CheckLevel($logininid,$loginin,$classid,"userjs");
$enews=ehtmlspecialchars($_GET['enews']);
$cid=(int)$_GET['cid'];
$url="<a href=ListUserjs.php".$ecms_hashur['whehref'].">�����û��Զ���JS</a> &gt; �����Զ���JS";
$r[jsfilename]="../../d/js/js/".time().".js";
$r[jssql]="select * from [!db.pre!]ecms_news order by id desc limit 10";
//����
if($enews=="AddUserjs"&&$_GET['docopy'])
{
	$jsid=(int)$_GET['jsid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsuserjs where jsid='$jsid'");
	$url="<a href=ListUserjs.php".$ecms_hashur['whehref'].">�����û��Զ���JS</a> &gt; �����Զ���JS��<b>".$r[jsname]."</b>";
}
//�޸�
if($enews=="EditUserjs")
{
	$jsid=(int)$_GET['jsid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsuserjs where jsid='$jsid'");
	$url="<a href=ListUserjs.php".$ecms_hashur['whehref'].">�����û��Զ���JS</a> -&gt; �޸��Զ���JS��<b>".$r[jsname]."</b>";
}
//jsģ��
$jstempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsjstemp")." order by tempid");
while($jstempr=$empire->fetch($jstempsql))
{
	$select="";
	if($r[jstempid]==$jstempr[tempid])
	{
		$select=" selected";
	}
	$jstemp.="<option value='".$jstempr[tempid]."'".$select.">".$jstempr[tempname]."</option>";
}
//��ǰʹ�õ�ģ����
$thegid=GetDoTempGid();
//����
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsuserjsclass order by classid");
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
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>�û��Զ���JS</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListUserjs.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">�����û��Զ���JS 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="jsid" type="hidden" id="jsid" value="<?=$jsid?>"> 
        <input name="oldjsfilename" type="hidden" id="oldjsfilename" value="<?=$r[jsfilename]?>">
        <input name="cid" type="hidden" id="cid" value="<?=$cid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="18%" height="25">JS����:</td>
      <td width="82%" height="25"> <input name="jsname" type="text" id="jsname" value="<?=$r[jsname]?>" size="42">      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��������</td>
      <td height="25"><select name="classid" id="classid">
        <option value="0">���������κ����</option>
        <?=$cstr?>
      </select>
        <input type="button" name="Submit6222322" value="�������" onclick="window.open('UserjsClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">JS��ŵ�ַ��</td>
      <td height="25"><input name="jsfilename" type="text" id="jsfilename" value="<?=$r[jsfilename]?>" size="42"> 
        <font color="#666666"> 
        <input type="button" name="Submit4" value="ѡ��Ŀ¼" onclick="window.open('../file/ChangePath.php?<?=$ecms_hashur['ehref']?>&returnform=opener.document.form1.jsfilename.value','','width=400,height=500,scrollbars=yes');">
        (��:<strong>&quot;../../1.js</strong>&quot;��ʾ��Ŀ¼�µ�1.js)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="2">��ѯSQL���:</td>
      <td height="25"><input name="jssql" type="text" id="jssql" value="<?=ehtmlspecialchars(stripSlashes($r[jssql]))?>" size="72"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><font color="#666666">(�磺select * from phome_ecms_news where 
        classid=1 order by id desc limit 10)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ʹ��JSģ�壺</td>
      <td height="25"><select name="jstempid" id="jstempid">
          <?=$jstemp?>
        </select> <input type="button" name="Submit62223" value="����JSģ��" onclick="window.open('../template/ListJstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25">��ǰ׺���á�<strong>[!db.pre!]</strong>����ʾ</td>
    </tr>
  </table>
</form>
</body>
</html>
