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
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$totalquery="select count(*) as total from {$dbtbpre}enewsbuybak where userid='$userid'";
$num=$empire->gettotal($totalquery);//ȡ��������
$query="select * from {$dbtbpre}enewsbuybak where userid='$userid'";
$query=$query." order by buytime desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����¼</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="98%%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>�鿴<b><?=$username?></b>�����¼</td>
  </tr>
</table>
<br>
<table width="98%%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="11%"><div align="center">��ֵ����</div></td>
    <td width="37%" height="25"><div align="center">��ֵ����</div></td>
    <td width="11%" height="25"><div align="center">��ֵ���</div></td>
    <td width="11%" height="25"><div align="center">�������</div></td>
    <td width="11%"><div align="center">��Ч��</div></td>
    <td width="19%" height="25"><div align="center">����ʱ��</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
		//����
		if($r['type']==0)
		{
			$type='�㿨��ֵ';
		}
		elseif($r['type']==1)
		{
			$type='���߳�ֵ';
		}
		elseif($r['type']==2)
		{
			$type='��ֵ����';
		}
		elseif($r['type']==3)
		{
			$type='��ֵ���';
		}
		else
		{
			$type='';
		}
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td><div align="center"><?=$type?></div></td>
    <td height="25"><div align="center"> 
        <?=$r[card_no]?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[money]?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[cardfen]?>
      </div></td>
    <td><div align="center"><?=$r[userdate]?></div></td>
    <td height="25"><div align="center"> 
        <?=$r[buytime]?>
      </div></td>
  </tr>
  <?
  }
  db_close();
  $empire=null;
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="6"> 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
