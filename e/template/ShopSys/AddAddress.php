<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$postword=$enews=='EditAddress'?'�޸ĵ�ַ':'���ӵ�ַ';
$public_diyr['pagetitle']=$postword;
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../../member/cp/>��Ա����</a>&nbsp;>&nbsp;<a href='ListAddress.php'>���͵�ַ�б�</a>&nbsp;>&nbsp;".$postword;
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form action="../doaction.php" method="post" name="addform" id="addform">
    <tr class="header">
      <td height="23" colspan="2"><?=$postword?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td width="22%" height="25">��ַ���ƣ�</td>
      <td width="78%" height="25"><input name="addressname" type="text" id="title2" value="<?=stripSlashes($r[addressname])?>" size="42">
      *</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">������</td>
      <td height="25"><input name="truename" type="text" id="addressname" value="<?=stripSlashes($r[truename])?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�����ַ��</td>
      <td height="25"><input name="email" type="text" id="truename" value="<?=stripSlashes($r[email])?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�̶��绰��</td>
      <td height="25"><input name="mycall" type="text" id="email" value="<?=stripSlashes($r[mycall])?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�ֻ����룺</td>
      <td height="25"><input name="phone" type="text" id="mycall" value="<?=stripSlashes($r[phone])?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">QQ���룺</td>
      <td height="25"><input name="oicq" type="text" id="oicq" value="<?=stripSlashes($r[oicq])?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">MSN��</td>
      <td height="25"><input name="msn" type="text" id="msn" value="<?=stripSlashes($r[msn])?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�ջ���ַ��</td>
      <td height="25"><input name="address" type="text" id="phone" value="<?=stripSlashes($r[address])?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�ʱࣺ</td>
      <td height="25"><input name="zip" type="text" id="address" value="<?=stripSlashes($r[zip])?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��ַ�ܱ߱�־�Խ�����</td>
      <td height="25"><input name="signbuild" type="text" id="zip" value="<?=stripSlashes($r[signbuild])?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">����ջ�ʱ�䣺</td>
      <td height="25"><input name="besttime" type="text" id="signbuild" value="<?=stripSlashes($r[besttime])?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ">
        &nbsp;
        <input type="reset" name="Submit2" value="����">
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>">      <input name="addressid" type="hidden" id="addressid" value="<?=$addressid?>"></td>
    </tr>
  </form>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>
