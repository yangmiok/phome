<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='ע���Ա';
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../cp/>��Ա����</a>&nbsp;>&nbsp;ѡ��ע���Ա����";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<br>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="ChRegForm" method="GET" action="index.php">
  <input name="tobind" type="hidden" id="tobind" value="<?=$tobind?>">
    <tr class="header"> 
      <td height="25"><div align="center">ѡ��ע���Ա����<?=$tobind?' (���˺�)':''?></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="70%" height="25"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		<?php
		while($r=$empire->fetch($sql))
		{
			$checked='';
			if($r[groupid]==eReturnMemberDefGroupid())
			{
				$checked=' checked';
			}
		?>
          <tr>
            <td height="23">
			<input type="radio" name="groupid" value="<?=$r[groupid]?>"<?=$checked?>>
              <?=$r[groupname]?>
            </td>
          </tr>
		<?php
		}
		?>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> &nbsp;<input type="submit" name="button" value="��һ��"></td>
    </tr>
  </form>
</table>
<br>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>