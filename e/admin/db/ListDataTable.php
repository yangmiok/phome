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
CheckLevel($logininid,$loginin,$classid,"table");
$tid=(int)$_GET['tid'];
$tbname=RepPostVar($_GET['tbname']);
if(!$tid||!$tbname)
{
	printerror("ErrorUrl","history.go(-1)");
}
$r=$empire->fetch1("select tid,datatbs,deftb from {$dbtbpre}enewstable where tid='$tid'");
if(!$r[tid])
{
	printerror("ErrorUrl","history.go(-1)");
}
$tr=explode(',',$r[datatbs]);
$url="���ݱ�:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListDataTable.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">������ֱ�</a>";
$datatbname=$dbtbpre.'ecms_'.$tbname.'_data_';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������ֱ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="adddatatableform" method="post" action="../ecmsmod.php" onsubmit="return confirm('ȷ��Ҫ����?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td>���Ӹ���ֱ�
        <input name="enews" type="hidden" id="enews" value="AddDataTable">
        <input name="tid" type="hidden" id="tid" value="<?=$tid?>"> <input name="tbname" type="hidden" id="tbname" value="<?=$tbname?>"></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">
        <?=$datatbname?>
        <input name="datatb" type="text" id="datatb" value="0" size="6">
        <input type="submit" name="Submit" value="����">
        <font color="#666666">(����Ҫ������)</font></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="38%" height="25"><div align="center">����</div></td>
    <td width="33%" height="25"><div align="center">��¼��</div></td>
    <td width="29%" height="25"><div align="center">����</div></td>
  </tr>
  <?php
  $count=count($tr)-1;
  $maxtb=0;
  for($i=1;$i<$count;$i++)
  {
  	$total_r=$empire->fetch1("SHOW TABLE STATUS LIKE '".$datatbname.$tr[$i]."';");
	$bgcolor="#ffffff";
	$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
	if($tr[$i]==$r['deftb'])
	{
		$bgcolor="#DBEAF5";
		$movejs='';
	}
	if($tr[$i]>$maxtb)
	{
		$maxtb=$tr[$i];
	}
	$dostr=$tr[$i]==1?"":"&nbsp;&nbsp;&nbsp;[<a href=\"../ecmsmod.php?tid=$tid&tbname=$tbname&enews=DelDataTable&datatb=".$tr[$i].$ecms_hashur['href']."\" onclick=\"return confirm('ȷ��Ҫɾ����ɾ����ɾ�������������Ϣ?');\">ɾ��</a>]";
  ?>
  <tr bgcolor="<?=$bgcolor?>"<?=$movejs?>> 
    <td height="25"> 
      <?=$datatbname?><b><?=$tr[$i]?></b>
    </td>
    <td height="25"><div align="center"> 
        <?=$total_r['Rows']?>
      </div></td>
    <td height="25"><div align="center">[<a href="../ecmsmod.php?tid=<?=$tid?>&tbname=<?=$tbname?>&enews=DefDataTable&datatb=<?=$tr[$i]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫ���������Ϊ��ǰ��ű�?');">��Ϊ��ǰ��ű�</a>]<?=$dostr?></div></td>
  </tr>
  <?php
	}
	?>
</table>
<script>
document.adddatatableform.datatb.value="<?=$maxtb+1?>";
</script>
</body>
</html>
<?php
db_close();
$empire=null;
?>
