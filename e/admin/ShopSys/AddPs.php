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
CheckLevel($logininid,$loginin,$classid,"shopps");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListPs.php".$ecms_hashur['whehref'].">�������ͷ�ʽ</a>&nbsp;>&nbsp;�������ͷ�ʽ";
if($enews=="EditPs")
{
	$pid=(int)$_GET['pid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsshopps where pid='$pid'");
	$url="<a href=ListPs.php".$ecms_hashur['whehref'].">�������ͷ�ʽ</a>&nbsp;>&nbsp;�޸����ͷ�ʽ��<b>".$r[pname]."</b>";
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
<title>���ͷ�ʽ</title>
<?=$loadeditorjs?>
<script>
function on()
{
var f=document.add
f.HTML.value=f.psay.value;
}
function bs(){
var f=document.add
f.psay.value=f.HTML.value;
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
<form name="add" method="post" action="ListPs.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="21%" height="25">�������ͷ�ʽ</td>
      <td width="79%" height="25"><input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="pid" type="hidden" id="pid" value="<?=$pid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ʽ����:</td>
      <td height="25"><input name="pname" type="text" id="pname" value="<?=$r[pname]?>">
        (��:��ͨ�ʵ�) </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�˷ѽ��:</td>
      <td height="25"><input name="price" type="text" id="price" value="<?=$r[price]?>" size="8">
        Ԫ</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">��ϸ˵��:</td>
      <td height="25">
		<?=ECMS_ShowEditorVar('psay',$r[psay],'Default','../ecmseditor/infoeditor/')?>      </td>
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
