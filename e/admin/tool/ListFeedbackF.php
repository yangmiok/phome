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
CheckLevel($logininid,$loginin,$classid,"feedbackf");
$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include("../../class/com_functions.php");
}
if($enews=="AddFeedbackF")
{
	AddFeedbackF($_POST,$logininid,$loginin);
}
elseif($enews=="EditFeedbackF")
{
	EditFeedbackF($_POST,$logininid,$loginin);
}
elseif($enews=="DelFeedbackF")
{
	DelFeedbackF($_GET,$logininid,$loginin);
}
elseif($enews=="EditFeedbackFOrder")
{
	EditFeedbackFOrder($_POST['fid'],$_POST['myorder'],$logininid,$loginin);
}
$url="<a href=feedback.php".$ecms_hashur['whehref'].">������Ϣ����</a>&nbsp;>&nbsp;<a href=FeedbackClass.php".$ecms_hashur['whehref'].">��Ϣ�����������</a>&nbsp;>&nbsp;<a href=ListFeedbackF.php".$ecms_hashur['whehref'].">�������ֶ�</a>";
$sql=$empire->query("select * from {$dbtbpre}enewsfeedbackf order by myorder,fid");
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
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit2" value="�½��ֶ�" onclick="self.location.href='AddFeedbackF.php?enews=AddFeedbackF<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<form name="form1" method="post" action="ListFeedbackF.php" onsubmit="return confirm('ȷ��Ҫ����?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="6%" height="25"><div align="center">˳��</div></td>
      <td width="27%" height="25">
<div align="center">�ֶ���</div></td>
      <td width="27%">
<div align="center">�ֶα�ʶ</div></td>
      <td width="23%"><div align="center">�ֶ�����</div></td>
      <td width="17%" height="25"><div align="center">����</div></td>
    </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  	$ftype=$r[ftype];
  	if($r[flen])
	{
		if($r[ftype]!="TEXT"&&$r[ftype]!="MEDIUMTEXT"&&$r[ftype]!="LONGTEXT")
		{
			$ftype.="(".$r[flen].")";
		}
	}
  ?>
    <tr bgcolor="ffffff" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25"><div align="center"> 
          <input name="myorder[]" type="text" id="myorder[]" value="<?=$r[myorder]?>" size="3">
          <input type=hidden name=fid[] value=<?=$r[fid]?>>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[f]?>
        </div></td>
      <td><div align="center"> 
          <?=$r[fname]?>
        </div></td>
      <td><div align="center">
	  	  <?=$ftype?>
	  </div></td>
      <td height="25"><div align="center"> 
         [<a href='AddFeedbackF.php?enews=EditFeedbackF&fid=<?=$r[fid]?><?=$ecms_hashur['ehref']?>'>�޸�</a>]&nbsp;&nbsp;[<a href='ListFeedbackF.php?enews=DelFeedbackF&fid=<?=$r[fid]?><?=$ecms_hashur['href']?>' onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]
        </div></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="ffffff"> 
      <td height="25">&nbsp;</td>
      <td height="25" colspan="4"><input type="submit" name="Submit" value="�޸��ֶ�˳��">
        (ֵԽСԽǰ��) <input name="enews" type="hidden" id="enews" value="EditFeedbackFOrder"> 
      </td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
