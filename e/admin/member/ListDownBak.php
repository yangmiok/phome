<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../member/class/user.php");
require "../".LoadLang("pub/fun.php");
require("../../data/dbcache/MemberLevel.php");
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
CheckLevel($logininid,$loginin,$classid,"member");
$userid=(int)$_GET['userid'];
$username=ehtmlspecialchars($_GET['username']);
$search="&username=".$username."&userid=".$userid.$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=20;//ÿҳ��ʾ����
$page_line=20;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$totalquery="select count(*) as total from {$dbtbpre}enewsdownrecord where userid='$userid'";
$num=$empire->gettotal($totalquery);//ȡ��������
$query="select * from {$dbtbpre}enewsdownrecord where userid='$userid'";
$query=$query." order by truetime desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���Ѽ�¼</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="98%%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>�鿴<b><?=$username?></b>���Ѽ�¼</td>
  </tr>
</table>
<br>
<table width="98%%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td width="8%"><div align="center">����</div></td>
    <td width="59%" height="25"><div align="center">����</div></td>
    <td width="10%" height="25"><div align="center">�۳�����</div></td>
    <td width="23%" height="25"><div align="center">ʱ��</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  	if($r['online']==0)
	{
		$type='����';
	}
	elseif($r['online']==1)
	{
		$type='�ۿ�';
	}
	elseif($r['online']==2)
	{
		$type='�鿴';
	}
	elseif($r['online']==3)
	{
		$type='����';
	}
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
    <td><div align="center"><?=$type?></div></td>
    <td height="25"><div align="center"> <a href='../../public/InfoUrl?classid=<?=$r[classid]?>&id=<?=$r[id]?>' target=_blank>
        <?=$r[title]?>
        </a> </div></td>
    <td height="25"><div align="center"> 
        <?=$r[cardfen]?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=date("Y-m-d H:i:s",$r[truetime])?>
      </div></td>
  </tr>
  <?
  }
  db_close();
  $empire=null;
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="4">&nbsp;&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
