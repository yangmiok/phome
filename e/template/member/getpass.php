<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='ȡ������';
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../cp/>��Ա����</a>&nbsp;>&nbsp;ȡ������";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<br>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="GetPassForm" method="POST" action="../doaction.php">
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">��������</div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="23%" height="25">�û���</td>
      <td width="77%"><?=$username?></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">������</td>
      <td><input name="newpassword" type="password" id="newpassword" size="38"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�ظ�������</td>
      <td><input name="renewpassword" type="password" id="renewpassword" size="38"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp; </td>
      <td> <input type="submit" name="button" value="�޸�"> 
        <input name="enews" type="hidden" id="enews" value="DoGetPassword">
        <input name="id" type="hidden" id="id" value="<?=$r[id]?>">
        <input name="tt" type="hidden" id="tt" value="<?=$r[tt]?>">
        <input name="cc" type="hidden" id="cc" value="<?=$r[cc]?>"></td>
    </tr>
  </form>
</table>
<br>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>