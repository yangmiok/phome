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
CheckLevel($logininid,$loginin,$classid,"shoppayfs");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListPayfs.php".$ecms_hashur['whehref'].">����֧����ʽ</a>&nbsp;>&nbsp;����֧����ʽ";
if($enews=="EditPayfs")
{
	$payid=(int)$_GET['payid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsshoppayfs where payid='$payid'");
	$url="<a href=ListPayfs.php".$ecms_hashur['whehref'].">����֧����ʽ</a>&nbsp;>&nbsp;�޸�֧����ʽ��<b>".$r[payname]."</b>";
	if($r[userpay])
	{$userpay=" checked";}
	if($r[userfen])
	{$userfen=" checked";}
}
//--------------------html�༭��
include('../ecmseditor/eshoweditor.php');
$loadeditorjs=ECMS_ShowEditorJS('../ecmseditor/infoeditor/');
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>֧����ʽ</title>
<?=$loadeditorjs?>
<script>
function on()
{
var f=document.add
f.HTML.value=f.paysay.value;
}
function bs(){
var f=document.add
f.paysay.value=f.HTML.value;
}
function br(){
if(!confirm("�Ƿ�λ��")){return false;}
document.add.title.select()
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="add" method="post" action="ListPayfs.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="21%" height="25">����֧����ʽ</td>
      <td width="79%" height="25"><input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="payid" type="hidden" id="payid" value="<?=$payid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ʽ����:</td>
      <td height="25"><input name="payname" type="text" id="payname" value="<?=$r[payname]?>">
        (��:�ʾֻ��) </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input name="userpay" type="checkbox" id="userpay" value="1"<?=$userpay?>>
        <strong>ֱ�ӻ���</strong>(�ǻ�������ѡ��)</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25"><input name="userfen" type="checkbox" id="userfen" value="1"<?=$userfen?>>
        <strong>��������</strong>(�ǵ�����������ѡ��)</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����֧����ַ:</td>
      <td height="25"><input name="payurl" type="text" id="payurl" value="<?=$r[payurl]?>" size="52">
        (����֧��/�ֻ�֧������д)</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">��ϸ˵��:</td>
      <td height="25">
	  <?=ECMS_ShowEditorVar('paysay',$r[paysay],'Default','../ecmseditor/infoeditor/')?>      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�Ƿ�����</td>
      <td height="25"><input type="radio" name="isclose" value="0"<?=$r[isclose]==0?' checked':''?>>
      ����
        <input type="radio" name="isclose" value="1"<?=$r[isclose]==1?' checked':''?>>
      �ر�</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
