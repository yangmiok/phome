<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='���ÿռ�';
$url="<a href='../../../'>��ҳ</a>&nbsp;>&nbsp;<a href='../cp/'>��Ա����</a>&nbsp;>&nbsp;���ÿռ�";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
		<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
        <form name="setspace" method="post" action="index.php">
          <tr class="header"> 
            <td height="25" colspan="2">���ÿռ�</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="17%" height="25">�ռ�����</td>
            <td width="83%"> 
              <input name="spacename" type="text" id="spacename" value="<?=stripSlashes($addr[spacename])?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>�ռ乫��</td>
            <td> 
              <textarea name="spacegg" cols="60" rows="6" id="spacegg"><?=stripSlashes($addr[spacegg])?></textarea></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">&nbsp;</td>
            <td> 
              <input type="submit" name="Submit" value="�ύ">
              <input type="reset" name="Submit2" value="����">
              <input name="enews" type="hidden" id="enews" value="DoSetSpace"></td>
          </tr>
		  </form>
        </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>