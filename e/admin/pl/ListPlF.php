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
$url="<a href=ListAllPl.php".$ecms_hashur['whehref'].">��������</a>&nbsp;>&nbsp;<a href=ListPlF.php".$ecms_hashur['whehref'].">���������Զ����ֶ�</a>";
$sql=$empire->query("select * from {$dbtbpre}enewsplf order by fid");
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
        <input type="button" name="Submit2" value="�����ֶ�" onclick="self.location.href='AddPlF.php?enews=AddPlF<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmspl.php" onsubmit="return confirm('ȷ��Ҫ����?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="27%" height="25"> <div align="center">�ֶ���</div></td>
      <td width="27%"> <div align="center">�ֶα�ʶ</div></td>
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
    <tr bgcolor="ffffff"> 
      <td height="25"><div align="center"> 
          <?=$r[f]?>
        </div></td>
      <td><div align="center"> 
          <?=$r[fname]?>
        </div></td>
      <td><div align="center"> 
          <?=$ftype?>
        </div></td>
      <td height="25"><div align="center"> [<a href='AddPlF.php?enews=EditPlF&fid=<?=$r[fid]?><?=$ecms_hashur['ehref']?>'>�޸�</a>]&nbsp;&nbsp;[<a href='../ecmspl.php?enews=DelPlF&fid=<?=$r[fid]?><?=$ecms_hashur['href']?>' onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>] 
        </div></td>
    </tr>
    <?
	}
	?>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
