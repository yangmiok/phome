<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='�����ʺż����ʼ�';
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../cp/>��Ա����</a>&nbsp;>&nbsp;�ط��ʺż����ʼ�";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<br>
<table width="600" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="RegSendForm" method="POST" action="../doaction.php">
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">�ط��ʺż����ʼ�</div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="23%" height="25">�û���(*)</td>
      <td width="77%"><input name="username" type="text" id="username" size="38"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����(*)</td>
      <td><input name="password" type="password" id="password" size="38"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����(*)</td>
      <td><input name="email" type="text" id="email" size="38"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�½�������</td>
      <td><input name="newemail" type="text" id="newemail" size="38">
        <font color="#666666">(Ҫ�ı�����������д)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��֤��</td>
      <td>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="52"><input name="key" type="text" id="key" size="6"> 
                  </td>
                  <td id="regsendshowkey"><a href="#EmpireCMS" onclick="edoshowkey('regsendshowkey','regsend','<?=$public_r['newsurl']?>');" title="�����ʾ��֤��">�����ʾ��֤��</a></td>
                </tr>
            </table>
	  </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp; </td>
      <td> <input type="submit" name="button" value="�ύ"> 
        <input name="enews" type="hidden" id="enews" value="RegSend"></td>
    </tr>
  </form>
</table>
<br>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>