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
CheckLevel($logininid,$loginin,$classid,"execsql");

$enews=RepPostStr($_GET['enews'],1);
if(empty($enews))
{
	$enews='AddSql';
}
$url="<a href='ListSql.php".$ecms_hashur['whehref']."'>����SQL���</a>&nbsp;>&nbsp;����SQL���";
$postword='����SQL���';
if($enews=='EditSql')
{
	$id=intval($_GET['id']);
	$r=$empire->fetch1("select * from {$dbtbpre}enewssql where id='$id'");
	$url="<a href='ListSql.php".$ecms_hashur['whehref']."'>����SQL���</a>&nbsp;>&nbsp;�޸�SQL���: <b>".$r[sqlname]."</b>";
	$postword='�޸�SQL���';
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$postword?></title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form action="DoSql.php" method="POST" name="sqlform">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center"><?=$postword?></div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">(�����������&quot;�س�&quot;��,ÿ�������&quot;;&quot;���������ݱ�ǰ׺���ã���[!db.pre!]&quot;��ʾ)</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center"> 
          <textarea name="sqltext" cols="90" rows="12" id="sqltext"><?=ehtmlspecialchars($r[sqltext])?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">SQL���ƣ� 
          <input name="sqlname" type="text" id="sqlname" value="<?=$r[sqlname]?>">
          <input type="submit" name="Submit3" value="����">
          &nbsp;<input type="reset" name="Submit2" value="����">
          <input name="enews" type="hidden" id="enews" value="<?=$enews?>">
          <input name="id" type="hidden" id="id" value="<?=$id?>">
        </div></td>
    </tr>
  </table>
  </form>
</body>
</html>
