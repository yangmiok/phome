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
CheckLevel($logininid,$loginin,$classid,"workflow");
$enews=ehtmlspecialchars($_GET['enews']);
$postword='���ӹ�����';
$r[myorder]=0;
$url="<a href=ListWf.php".$ecms_hashur['whehref'].">��������</a> &gt; ���ӹ�����";
//�޸�
if($enews=="EditWorkflow")
{
	$postword='�޸Ĺ�����';
	$wfid=(int)$_GET['wfid'];
	$r=$empire->fetch1("select wfid,wfname,wftext,myorder,canedit from {$dbtbpre}enewsworkflow where wfid='$wfid'");
	$url="<a href=ListWf.php".$ecms_hashur['whehref'].">��������</a> -&gt; �޸Ĺ�������<b>".$r[wfname]."</b>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>������</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListWf.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> 
        <?=$postword?>
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="wfid" type="hidden" id="wfid" value="<?=$wfid?>">      </td>
    </tr>
    <tr> 
      <td width="20%" height="25" bgcolor="#FFFFFF">����������</td>
      <td width="80%" height="25" bgcolor="#FFFFFF"> <input name="wfname" type="text" id="wfname" value="<?=$r[wfname]?>" size="42">      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">����������</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="wftext" cols="60" rows="5" id="wftext"><?=ehtmlspecialchars($r[wftext])?></textarea></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">��ת�е���Ϣ���޸�</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="canedit" value="1"<?=$r['canedit']==1?' checked':''?>>�����޸�
          <input type="radio" name="canedit" value="0"<?=$r['canedit']==0?' checked':''?>>�����޸�</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">����</td>
      <td height="25" bgcolor="#FFFFFF"><font color="#666666">
        <input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>" size="42">
        (ֵԽС��ʾԽǰ��)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="�ύ"> 
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
