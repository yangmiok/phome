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
CheckLevel($logininid,$loginin,$classid,"tags");
$enews=ehtmlspecialchars($_GET['enews']);
$postword='����TAGS';
$url="<a href=ListTags.php".$ecms_hashur['whehref'].">����TAGS</a> &gt; ����TAGS";
$fcid=(int)$_GET['fcid'];
//�޸�
if($enews=="EditTags")
{
	$postword='�޸�TAGS';
	$tagid=(int)$_GET['tagid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewstags where tagid='$tagid'");
	$url="<a href=ListTags.php".$ecms_hashur['whehref'].">����TAGS</a> -&gt; �޸�TAGS��<b>".$r[tagname]."</b>";
}
//����
$csql=$empire->query("select classid,classname from {$dbtbpre}enewstagsclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($r[cid]==$cr[classid])
	{
		$select=" selected";
	}
	$cs.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>TAGS</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListTags.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><?=$postword?> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="tagid" type="hidden" id="tagid" value="<?=$tagid?>">
        <input name="fcid" type="hidden" id="fcid" value="<?=$fcid?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="18%" height="25">TAG����:</td>
      <td width="82%" height="25"> <input name="tagname" type="text" id="tagname" value="<?=$r[tagname]?>" size="42">
        <font color="#666666">(���20����)</font> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������:</td>
      <td height="25"><select name="cid" id="cid">
          <option value="0">������</option>
		  <?=$cs?>
        </select> 
        <input type="button" name="Submit62223" value="�������" onclick="window.open('TagsClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��ҳ����:</td>
      <td height="25"><input name="tagtitle" type="text" id="tagtitle" value="<?=ehtmlspecialchars($r[tagtitle])?>" size="42">
      <font color="#666666">(���60����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��ҳ�ؼ���:</td>
      <td height="25"><input name="tagkey" type="text" id="tagkey" value="<?=ehtmlspecialchars($r[tagkey])?>" size="42">
      <font color="#666666">(���100����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��ҳ����:</td>
      <td height="25"><input name="tagdes" type="text" id="tagdes" value="<?=ehtmlspecialchars($r[tagdes])?>" size="42">
      <font color="#666666">(���255����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
