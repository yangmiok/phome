<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
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
$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=16;//ÿҳ��ʾ����
$page_line=25;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select id,sqlname from {$dbtbpre}enewssql";
$totalquery="select count(*) as total from {$dbtbpre}enewssql";
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by id desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>����SQL���</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td height="25">λ�ã�<a href="ListSql.php<?=$ecms_hashur['whehref']?>">����SQL���</a></td>
    <td width="50%"><div align="right" class="emenubutton">
		<input type="button" name="Submit5" value="����SQL���" onclick="self.location.href='AddSql.php?enews=AddSql<?=$ecms_hashur['ehref']?>';">&nbsp;&nbsp;
        <input type="button" name="Submit4" value="ִ��SQL���" onclick="self.location.href='DoSql.php<?=$ecms_hashur['whehref']?>';">    
      </div></td>
  </tr>
</table>

<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="10%" height="25"> <div align="center">ID</div></td>
    <td width="62%" height="25"> <div align="center">SQL����</div></td>
    <td width="28%" height="25"> <div align="center">����</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r['id']?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r['sqlname']?>
      </div></td>
    <td height="25"> <div align="center">[<a href="DoSql.php?enews=ExecSql&id=<?=$r[id]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫִ��SQL��');">ִ��</a>] [<a href="AddSql.php?enews=EditSql&id=<?=$r[id]?><?=$ecms_hashur['ehref']?>">�޸�</a>]&nbsp;[<a href="DoSql.php?enews=DelSql&id=<?=$r[id]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="3">&nbsp;&nbsp;&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>
