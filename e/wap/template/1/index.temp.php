<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
$add='';
$bclassid=(int)$_GET['bclassid'];
if($pr['wapshowmid'])
{
	$add=" and modid in (".$pr['wapshowmid'].")";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=$pagetitle?> - Powered by EmpireCMS</title>
<meta name="keywords" content="<?=$pagekey?>" />
<meta name="description" content="<?=$pagedes?>" />
<link href="skin/default/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
if($bclassid)
{
	$returnurl="index.php?style=$wapstyle&amp;bclassid=".($class_r[$bclassid]['bclassid']?$class_r[$bclassid]['bclassid']:0);
?>
<p><b>����Ŀ�б�</b><?=$class_r[$bclassid]['classname']?></p>
<?php
}
else
{
	$returnurl="index.php?style=$wapstyle";
?>
<p><b>��վ��Ŀ:</b><?=$pagetitle?></p>
<?php
}
?>
<p>
<?php
$sql=$empire->query("select classid,classname,islast from {$dbtbpre}enewsclass where bclassid='$bclassid' and showclass=0 and wburl=''".$add." order by myorder,classid");
while($r=$empire->fetch($sql))
{
	$classurl="list.php?classid=".$r[classid]."&amp;style=".$wapstyle."&amp;bclassid=".$bclassid;
	$indexurl="index.php?style=".$wapstyle."&amp;bclassid=".$r[classid];
	if($r['islast'])
	{
		$showsonclass="";
	}
	else
	{
		$showsonclass=" <small>(<a href=\"$indexurl\">�¼���Ŀ</a>)</small>";
	}
?>
<a href="<?=$classurl?>"><?=$r['classname']?></a><?=$showsonclass?><br />
<?php
}
?>
</p>
<p><a href="<?=$returnurl?>">����</a> <a href="index.php?style=<?=$wapstyle?>">��վ��ҳ</a></p>
</body>
</html>