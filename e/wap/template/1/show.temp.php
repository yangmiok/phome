<?php
if(!defined('InEmpireCMS'))
{
	exit();
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
<p><b>����:</b><?=stripSlashes($r['title'])?><br/>
<b>����:</b><?=$r['writer']?><br/>
<b>����:</b><?=date("Y-m-d H:i:s",$r['newstime'])?><br/>
<b>����:</b></p>
<p><?=stripSlashes($r['newstext'])?></p>
<p><br/><a href="<?=$listurl?>">�����б�</a> <a href="index.php?style=<?=$wapstyle?>">��վ��ҳ</a></p>
</body>
</html>