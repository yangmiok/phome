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
CheckLevel($logininid,$loginin,$classid,"m");
$enews=$_GET['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
//����ģ��
if($enews=="LoadOutMod")
{
	include("../../class/moddofun.php");
	LoadOutMod($_GET,$logininid,$loginin);
}
$tid=(int)$_GET['tid'];
$tbname=RepPostVar($_GET['tbname']);
if(!$tid||!$tbname)
{
	printerror("ErrorUrl","history.go(-1)");
}
$url="���ݱ�:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListM.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">����ϵͳģ��</a>";
$sql=$empire->query("select * from {$dbtbpre}enewsmod where tid='$tid' order by myorder,mid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ϵͳģ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td class="emenubutton"><input type="button" name="Submit2" value="����ϵͳģ��" onclick="self.location.href='AddM.php?enews=AddM&tid=<?=$tid?>&tbname=<?=$tbname?><?=$ecms_hashur['ehref']?>';">
      &nbsp;&nbsp;&nbsp;
      <input type="button" name="Submit22" value="����ϵͳģ��" onclick="window.open('LoadInM.php<?=$ecms_hashur['whehref']?>','','width=520,height=300,scrollbars=yes,top=130,left=120');"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"><div align="center">ID</div></td>
    <td width="33%" height="25"><div align="center">ģ������</div></td>
    <td width="7%"><div align="center">����</div></td>
    <td width="55%" height="25"><div align="center">����</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  	//Ĭ��
	$defbgcolor='#ffffff';
	$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
	if($r[isdefault])
	{
		$defbgcolor='#DBEAF5';
		$movejs='';
	}
	$do="[<a href='../../DoInfo/ChangeClass.php?mid=".$r[mid]."' target=_blank>Ͷ���ַ</a>]&nbsp;&nbsp;[<a href='AddM.php?tid=$tid&tbname=$tbname&enews=AddM&mid=".$r[mid].$ecms_hashur['ehref']."&docopy=1'>����</a>]&nbsp;&nbsp;[<a href='ListM.php?tid=$tid&tbname=$tbname&enews=LoadOutMod&mid=".$r[mid].$ecms_hashur['href']."' onclick=\"return confirm('ȷ��Ҫ����?');\">����</a>]&nbsp;&nbsp;[<a href='../ecmsmod.php?tid=$tid&tbname=$tbname&enews=DefM&mid=".$r[mid].$ecms_hashur['href']."' onclick=\"return confirm('ȷ��Ҫ����ΪĬ��ϵͳģ��?');\">��ΪĬ��</a>]&nbsp;&nbsp;[<a href='AddM.php?tid=$tid&tbname=$tbname&enews=EditM&mid=".$r[mid].$ecms_hashur['ehref']."'>�޸�</a>]&nbsp;&nbsp;[<a href='../ecmsmod.php?tid=$tid&tbname=$tbname&enews=DelM&mid=".$r[mid].$ecms_hashur['href']."' onclick=\"return confirm('ȷ��Ҫɾ����');\">ɾ��</a>]";
	$usemod=$r[usemod]==0?'��':'<font color="red">��</font>';
	?>
  <tr bgcolor="<?=$defbgcolor?>"<?=$movejs?>> 
    <td height="32"><div align="center"> 
        <?=$r[mid]?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[mname]?>
      </div></td>
    <td><div align="center"><?=$usemod?></div></td>
    <td height="25"><div align="center"> 
        <?=$do?>
      </div></td>
  </tr>
  <?php
	}
	?>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>
