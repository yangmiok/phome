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
CheckLevel($logininid,$loginin,$classid,"totaldata");
$userid=(int)$_GET['userid'];
$username=RepPostVar($_GET['username']);
$tbname=RepPostVar($_GET['tbname']);
if(empty($tbname))
{
	$tbname=$public_r['tbname'];
}
if(!$userid||!$username||!$tbname)
{
	printerror('ErrorUrl','');
}
//���ݱ�
$b=0;
$htb=0;
$tbsql=$empire->query("select tbname,tname from {$dbtbpre}enewstable order by tid");
while($tbr=$empire->fetch($tbsql))
{
	$b=1;
	$select="";
	if($tbr[tbname]==$tbname)
	{
		$htb=1;
		$select=" selected";
	}
	$tbstr.="<option value='".$tbr[tbname]."'".$select.">".$tbr[tname]."</option>";
}
if($b==0)
{
	printerror('ErrorUrl','');
}
if($htb==0)
{
	printerror('ErrorUrl','');
}
//����
$year=date("Y");
$yyear=$year-1;
$date=RepPostVar($_GET['date']);
if(empty($date))
{
	$date=date("Y-m");
}
$selectdate='';
$yselectdate='';
for($i=1;$i<=12;$i++)
{
	$m=$i;
	if($i<10)
	{
		$m='0'.$i;
	}
	//����
	$sdate=$year.'-'.$m;
	$select='';
	if($sdate==$date)
	{
		$select=' selected';
	}
	$selectdate.="<option value='".$sdate."'".$select.">".$sdate."</option>";
	//ȥ��
	$ysdate=$yyear.'-'.$m;
	$yselect='';
	if($ysdate==$date)
	{
		$yselect=' selected';
	}
	$yselectdate.="<option value='".$ysdate."'".$yselect.">".$ysdate."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$username?> �ķ���ͳ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="ChangeDate" method="get" action="MoreUserTotal.php">
<?=$ecms_hashur['eform']?>
<input type="hidden" name="userid" value="<?=$userid?>">
<input type="hidden" name="username" value="<?=$username?>">
  <tr> 
    <td height="25">λ�ã�<a href="MoreUserTotal.php?tbname=<?=$tbname?>&userid=<?=$userid?>&username=<?=$username?><?=$ecms_hashur['ehref']?>"><?=$username?> �ķ���ͳ��</a></td>
  </tr>
  <tr>
    <td height="30"> <div align="center">
        <select name="date" id="date">
		<?=$yselectdate.$selectdate?>
        </select>
        <select name="tbname" id="tbname">
          <?=$tbstr?>
        </select>
        <input type="submit" name="Submit" value="��ʾ">
      </div></td>
  </tr>
</form>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="20%" height="25"> 
      <div align="center">����</div></td>
    <td width="12%" height="25"> 
      <div align="center">������</div></td>
    <td width="12%">
<div align="center">δ�����</div></td>
    <td width="11%"><div align="center">����</div></td>
    <td width="11%"><div align="center">��Ͷ��</div></td>
    <td width="12%"><div align="center">�����</div></td>
    <td width="11%"><div align="center">������</div></td>
    <td width="11%"><div align="center">������</div></td>
  </tr>
  <?php
  $dr=explode('-',$date);
  $dr[0]=(int)$dr[0];
  $dr[1]=(int)$dr[1];
  for($j=1;$j<=31;$j++)
  {
  	//������ںϷ���
	if(!checkdate($dr[1],$j,$dr[0]))
	{
		continue;
	}
 	$d=$j;
	if($j<10)
	{
		$d='0'.$j;
	}
  	$thisday=$date.'-'.$d;
	//������
	$totalnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$tbname." where userid='$userid' and ismember=0 and truetime>=".to_time($thisday." 00:00:00")." and truetime<=".to_time($thisday." 23:59:59"));
	//δ�����
	$totalchecknum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$tbname."_check where userid='$userid' and ismember=0 and truetime>=".to_time($thisday." 00:00:00")." and truetime<=".to_time($thisday." 23:59:59"));
	//�����
	$totalonclick=$empire->gettotal("select sum(onclick) as total from {$dbtbpre}ecms_".$tbname." where userid='$userid' and ismember=0 and truetime>=".to_time($thisday." 00:00:00")." and truetime<=".to_time($thisday." 23:59:59"));
	//������
	$totalplnum=$empire->gettotal("select sum(plnum) as total from {$dbtbpre}ecms_".$tbname." where userid='$userid' and ismember=0 and truetime>=".to_time($thisday." 00:00:00")." and truetime<=".to_time($thisday." 23:59:59"));
	//������
	$totaldown=$empire->gettotal("select sum(totaldown) as total from {$dbtbpre}ecms_".$tbname." where userid='$userid' and ismember=0 and truetime>=".to_time($thisday." 00:00:00")." and truetime<=".to_time($thisday." 23:59:59"));
	//���
	$checkhinfonum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$tbname." where truetime>=".to_time($thisday." 00:00:00")." and truetime<=".to_time($thisday." 23:59:59")." and eckuid='$userid' and ismember=0");
	$checkqinfonum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$tbname." where truetime>=".to_time($thisday." 00:00:00")." and truetime<=".to_time($thisday." 23:59:59")." and eckuid='$userid' and ismember=1");
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25"><div align="center">
        <?=$thisday?>
      </div></td>
    <td height="25"><div align="center">
        <?=($totalnum+$totalchecknum)?>
      </div></td>
    <td><div align="center"><?=$totalchecknum?></div></td>
    <td><div align="center"><?=$checkhinfonum?></div></td>
    <td><div align="center"><?=$checkqinfonum?></div></td>
    <td><div align="center"><?=$totalonclick?></div></td>
    <td><div align="center"><?=$totalplnum?></div></td>
    <td><div align="center"><?=$totaldown?></div></td>
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