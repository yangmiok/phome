<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$field=RepPostVar($_GET['field']);
$form=RepPostVar($_GET['form']);
$line=20;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$search="&field=$field&form=$form".$ecms_hashur['ehref'];
$query="select * from {$dbtbpre}enewsuser";
$num=$empire->num($query);//ȡ��������
$query=$query." order by userid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ѡ���û�</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ChangeUser(user){
	var v;
	var str;
	var r;
	str=','+opener.document.<?=$form?>.<?=$field?>.value+',';
	//�ظ�
	r=str.split(','+user+',');
	if(r.length!=1)
	{
		return false;
	}
	if(str==",,")
	{v="";}
	else
	{v=",";}
	opener.document.<?=$form?>.<?=$field?>.value+=v+user;
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="15%" height="25"><div align="center">ID</div></td>
    <td width="52%" height="25"><div align="center">�û���(���ѡ��)</div></td>
    <td width="33%"><div align="center">�ȼ�</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
 $gr=$empire->fetch1("select groupname from {$dbtbpre}enewsgroup where groupid='$r[groupid]'");
  ?>
  <tr bgcolor="ffffff"> 
    <td height="25"><div align="center"> 
        <?=$r[userid]?>
      </div></td>
    <td height="25"><div align="center"> 
        <a href="#empirecms" onclick="javascript:ChangeUser('<?=$r[username]?>');" title="ѡ��"><?=$r[username]?></a>
      </div></td>
    <td><div align="center"> 
        <?=$gr[groupname]?>
      </div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="ffffff"> 
    <td height="25" colspan="3"> 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
