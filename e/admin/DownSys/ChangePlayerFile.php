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
//����
$returnform=ehtmlspecialchars($_GET['returnform']);
//��Ŀ¼
$openpath="../../DownSys/play";
$hand=@opendir($openpath);
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ѡ���ļ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="56%">λ�ã�<a href="ChangePlayerFile.php<?=$ecms_hashur['whehref']?>">ѡ���ļ�</a></td>
    <td width="44%"><div align="right"> </div></td>
  </tr>
</table>
<form name="chfile" method="post" action="../enews.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <?=$ecms_hashur['eform']?>
    <tr class="header"> 
      <td height="25">�ļ��� (��ǰĿ¼��<strong>/e/DownSys/play/</strong>)</td>
    </tr>
    <?php
	while($file=@readdir($hand))
	{
		$truefile=$file;
		if($file=="."||$file=="..")
		{
			continue;
		}
		//Ŀ¼
		if(is_dir($openpath."/".$file))
		{
			continue;
		}
		//�ļ�
		else
		{
			$img="txt_icon.gif";
			$target="";
		}
	 ?>
    <tr> 
      <td width="88%" height="25"><img src="../../data/images/dir/<?=$img?>" width="23" height="22"><a href="#ecms" onclick="<?=$returnform?>='<?=$truefile?>';window.close();" title="ѡ��"> 
        <?=$truefile?>
        </a></td>
    </tr>
    <?
	}
	@closedir($hand);
	?>
  </table>
</form>
</body>
</html>