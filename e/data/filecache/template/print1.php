<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=gb2312">
<title><?=ehtmlspecialchars($r[title])?> ��ӡҳ�� - Powered by EmpireCMS</title>
<meta name="keywords" content="<?=ehtmlspecialchars($r[title])?> ��ӡҳ��" />
<meta name="description" content="<?=ehtmlspecialchars($r[title])?> ��ӡҳ��" />
<style>
body{font-family:����}td,.f12{font-size:12px}.f24 {font-size:24px;}.f14 {font-size:14px;}.title14 {font-size:14px;line-height:130%}.l17 {line-height:170%;}
</style>
</head>
<body bgcolor="#ffffff" topmargin=5 leftmargin=5 marginheight=5 marginwidth=5 onLoad='window.print()'>
<center>
<table width=650 border=0 cellspacing=0 cellpadding=0>
<tr>
<td height=65 width=180><A href="http://www.phome.net/"><IMG src="../../skin/default/images/elogo.jpg" alt="�۹����" width="180" height="65" border=0></A></td> 
<td valign="bottom"><?=$url?></td>
<td width="83" align="right" valign="bottom"><a href='javascript:history.back()'>����</a>��<a href='javascript:window.print()'>��ӡ</a></td>
</tr>
</table>
<table width=650 border=0 cellpadding=0 cellspacing=20 bgcolor="#EDF0F5">
<tr>
<td>
<BR>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR>
<TH class="f24"><FONT color=#05006c><?=stripSlashes($r[title])?></FONT></TH></TR>
<TR>
<TD>
<HR SIZE=1 bgcolor="#d9d9d9">
</TD>
</TR>
<TR>
<TD align="middle" height=20><div align="center"><?=stripSlashes($r[writer])?>&nbsp;&nbsp;<?=date('Y-m-d H:i:s',$r[newstime])?>&nbsp;&nbsp;<?=stripSlashes($r[befrom])?></div></TD>
</TR>
<TR>
<TD height=15></TD>
</TR>
<TR>
<TD class="l17">
<FONT class="f14" id="zoom"> 
<P><?=stripSlashes($r[newstext])?><br>
<BR clear=all>
</P>
</FONT>
</TD>
</TR>
<TR height=10>
<TD></TD>
</TR>
</TBODY>
</TABLE>
<?=$titleurl?>
</td>
</tr>
</table>
</center>
</body>
</html>