<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='���͵�ַ�б�';
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../../member/cp/>��Ա����</a>&nbsp;>&nbsp;���͵�ַ�б�&nbsp;&nbsp;(<a href='AddAddress.php?enews=AddAddress'>�������͵�ַ</a>)";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width="600" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr>
    <td width="50%" height="30" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="50%" bgcolor="#FFFFFF"><div align="right">[<a href="AddAddress.php?enews=AddAddress">�������͵�ַ</a>]&nbsp;&nbsp;</div></td>
  </tr>
</table>
<br>
<table width="600" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header">
      <td width="65%" height="23"><div align="center">��ַ����</div></td>
      <td width="10%"><div align="center">Ĭ��</div></td>
      <td width="25%"><div align="center">����</div></td>
    </tr>
    <?php
	while($r=$empire->fetch($sql))
	{
		if($r['isdefault'])
		{
			$isdefault='��';
		}
		else
		{
			$isdefault='--';
		}
	?>
    <tr bgcolor="#FFFFFF">
      <td height="25"><div align="center"><?=stripSlashes($r['addressname'])?></div></td>
      <td><div align="center"><?=$isdefault?></div></td>
      <td><div align="center">[<a href="AddAddress.php?enews=EditAddress&addressid=<?=$r['addressid']?>">�޸�</a>] [<a href="../doaction.php?enews=DefAddress&addressid=<?=$r['addressid']?>" onclick="return confirm('ȷ��Ҫ��ΪĬ��?');">Ĭ��</a>] [<a href="../doaction.php?enews=DelAddress&addressid=<?=$r['addressid']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
    </tr>
    <?php
	}
	?>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>