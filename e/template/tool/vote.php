<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>ͶƱ: <?=$r[title]?></title>
<meta name="keywords" content="<?=$r[title]?> ͶƱ" />
<meta name="description" content="<?=$r[title]?> ͶƱ" />
<link href="../../data/images/qcss.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td height="25">����:<?=$r[title]?>&nbsp;(<?=$voteclass?>)</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
<?php
//ȡ����
$r_r=explode($r_exp,$r[votetext]);
for($i=0;$i<count($r_r);$i++)
{
	$f_r=explode($f_exp,$r_r[$i]);
	if($r[votenum])
	{
		$width=number_format(($f_r[1]/$r[votenum])*100,2);
	}
	else
	{
		$width=0;
	}
	?>
        <tr height=24> 
          <td width="48%"><img src="../../data/images/msgnav.gif" width="5" height="5">&nbsp; 
            <?=$f_r[0]?>
          </td>
          <td width="10%"><div align="center"><?=$f_r[1]?>Ʊ</div></td>
          <td width="42%"><img src="../../data/images/showvote.gif" width="<?=$width?>" height="6" border=0>
            <?=$width?>%
          </td>
        </tr>
	<?php
}
?>
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="right" cellpadding="3" cellspacing="1">
        <tr>
          <td>����ʱ�䣺<?=$r[addtime]?>��&nbsp;&nbsp;��&nbsp;<b><?=$r[votenum]?></b>&nbsp;Ʊ</td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<br>
<br>
<center><input type=button name=button value=�ر� onclick="self.window.close();"></center>
</body>
</html>