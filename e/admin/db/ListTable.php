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
//CheckLevel($logininid,$loginin,$classid,"table");
$url="<a href='ListTable.php".$ecms_hashur['whehref']."'>�������ݱ�</a>";
$sql=$empire->query("select tid,tname,tbname,isdefault from {$dbtbpre}enewstable order by tid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�������ݱ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit" value="�������ݱ�" onclick="self.location.href='AddTable.php?enews=AddTable<?=$ecms_hashur['ehref']?>';">&nbsp;&nbsp;
		<input type="button" name="Submit" value="����ϵͳģ��" onclick="self.location.href='LoadInM.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<br>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"><div align="center">ID</div></td>
    <td width="35%" height="25"><div align="center">������</div></td>
    <td width="32%"><div align="center">����</div></td>
    <td width="28%" height="25"><div align="center">����</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
	//Ĭ�ϱ�
	if($r[isdefault])
	{
		$bgcolor="#DBEAF5";
		$movejs='';
	}
	else
	{
		$bgcolor="#ffffff";
		$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
	}
  ?>
  <tr bgcolor="<?=$bgcolor?>"<?=$movejs?>> 
    <td height="32"><div align="center"> 
        <?=$r[tid]?>
      </div></td>
    <td height="25"> 
      <?=$r[tname]?>
      &nbsp;( <?=$dbtbpre?>ecms_<b><?=$r[tbname]?></b> ) </td>
    <td><div align="center">[<a href="#ecms" onclick="window.open('ListF.php?tid=<?=$r[tid]?>&tbname=<?=$r[tbname]?><?=$ecms_hashur['ehref']?>','','width=700,height=560,scrollbars=yes,top=70,left=100,resizable=yes');"><strong>�����ֶ�</strong></a>] &nbsp;
        [<a href="#ecms" onclick="window.open('ListM.php?tid=<?=$r[tid]?>&tbname=<?=$r[tbname]?><?=$ecms_hashur['ehref']?>','','width=860,height=560,scrollbars=yes,top=70,left=100,resizable=yes');"><strong>����ϵͳģ��</strong></a>] &nbsp;
        [<a href="#ecms" onclick="window.open('ListDataTable.php?tid=<?=$r[tid]?>&tbname=<?=$r[tbname]?><?=$ecms_hashur['ehref']?>','','width=700,height=560,scrollbars=yes,top=70,left=100,resizable=yes');"><strong>����ֱ�</strong></a>]</div></td>
    <td height="25"><div align="center"> [<a href="../ecmsmod.php?enews=DefaultTable&tid=<?=$r[tid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��ҪĬ��?');"><strong>��ΪĬ�ϱ�</strong></a>] &nbsp;
        [<a href="CopyTable.php?enews=CopyNewTable&tid=<?=$r[tid]?><?=$ecms_hashur['ehref']?>"><strong>����</strong></a>] &nbsp;
        [<a href="AddTable.php?enews=EditTable&tid=<?=$r[tid]?><?=$ecms_hashur['ehref']?>"><strong>�޸�</strong></a>] &nbsp;
        [<a href="../ecmsmod.php?enews=DelTable&tid=<?=$r[tid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');"><strong>ɾ��</strong></a>] 
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
