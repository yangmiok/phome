<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ظ�����</title>
<link href="../../data/images/qcss.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="regbook" method="post" action="index.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class=header> 
      <td height="25" colspan="2">�ظ�/�޸�����
        <input name="enews" type="hidden" id="enews" value="ReMemberGbook">
        <input name="gid" type="hidden" id="gid" value="<?=$gid?>">
        </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="20%" height="25">���Է�����:</td>
      <td width="80%" height="25"> 
        <?=stripSlashes($r['uname'])?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������:</td>
      <td height="25" style='word-break:break-all'> 
        <?=nl2br(stripSlashes($r[gbtext]))?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ʱ��:</td>
      <td height="25">
        <?=$r[addtime]?>&nbsp;
        (IP:
        <?=$r[ip]?>)
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>�ظ�����:</strong></td>
      <td height="25"><textarea name="retext" cols="60" rows="9" id="retext"><?=stripSlashes($r[retext])?></textarea> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ">
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center">[ <a href="javascript:window.close();">�� 
          ��</a> ]</div></td>
    </tr>
  </table>
</form>
</body>
</html>