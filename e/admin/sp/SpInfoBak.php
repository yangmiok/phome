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

$spid=(int)$_GET['spid'];
//��Ƭ
$spr=$empire->fetch1("select spid,spname,varname,sptype,maxnum,groupid,userclass,username from {$dbtbpre}enewssp where spid='$spid'");
if(!$spr['spid']||$spr[sptype]!=3)
{
	printerror('ErrorUrl','');
}
//��֤����Ȩ��
CheckDoLevel($lur,$spr[groupid],$spr[userclass],$spr[username]);
$sr=$empire->fetch1("select sid from {$dbtbpre}enewssp_3 where spid='$spid'");
if(!$sr['sid'])
{
	printerror('NotRecord','');
}
$sql=$empire->query("select bid,sid,spid,lastuser,lasttime from {$dbtbpre}enewssp_3_bak where sid='".$sr['sid']."' order by bid desc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ƭ��Ϣ�޸ļ�¼</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr> 
    <td height="25">λ�ã���Ƭ <b><?=$spr[spname]?></b> ���޸ļ�¼</td>
    </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="52%" height="25"> <div align="center">�޸�ʱ��</div></td>
    <td width="29%" height="25"> <div align="center">�޸���</div></td>
    <td width="19%"><div align="center">��ԭ</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"> 
        <?=date("Y-m-d H:i:s",$r[lasttime])?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[lastuser]?>
      </div></td>
    <td><div align="center">[<a href="ListSpInfo.php?enews=SpInfoReBak&spid=<?=$spid?>&sid=<?=$r['sid']?>&bid=<?=$r[bid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫ��ԭ?');">��ԭ</a>]</div></td>
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