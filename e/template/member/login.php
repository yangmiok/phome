<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='��Ա��¼';
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../cp/>��Ա����</a>&nbsp;>&nbsp;��Ա��¼";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<br>
  <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="../doaction.php">
    <input type=hidden name=ecmsfrom value="<?=ehtmlspecialchars($_GET['from'])?>">
    <input type=hidden name=enews value=login>
	<input name="tobind" type="hidden" id="tobind" value="<?=$tobind?>">
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">��Ա��¼<?=$tobind?' (���˺�)':''?></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="23%" height="25">�û�����</td>
      <td width="77%" height="25"><input name="username" type="text" id="username" size="30">
	  	<?php
		if($public_r['regacttype']==1)
		{
		?>
        &nbsp;&nbsp;<a href="../register/regsend.php" target="_blank">�ʺ�δ���</a>
		<?php
		}
		?>
		</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">���룺</td>
      <td height="25"><input name="password" type="password" id="password" size="30">
        &nbsp;&nbsp;<a href="../GetPassword/" target="_blank">�������룿</a></td>
    </tr>
	 <tr bgcolor="#FFFFFF">
      <td height="25">����ʱ�䣺</td>
      <td height="25">
	  <input name=lifetime type=radio value=0 checked>
        ������
	    <input type=radio name=lifetime value=3600>
        һСʱ 
        <input type=radio name=lifetime value=86400>
        һ�� 
        <input type=radio name=lifetime value=2592000>
        һ����
<input type=radio name=lifetime value=315360000>
        ���� </td>
    </tr>
    <?php
	if($public_r['loginkey_ok'])
	{
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��֤�룺</td>
      <td height="25">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="52"><input name="key" type="text" id="key" size="6"> 
                  </td>
                  <td id="loginshowkey"><a href="#EmpireCMS" onclick="edoshowkey('loginshowkey','login','<?=$public_r['newsurl']?>');" title="�����ʾ��֤��">�����ʾ��֤��</a></td>
                </tr>
            </table>
      </td>
    </tr>
    <?php
	}	
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value=" �� ¼ ">&nbsp;&nbsp;&nbsp; <input type="button" name="button" value="����ע��" onclick="parent.location.href='../register/<?=$tobind?'?tobind=1':''?>';"></td>
    </tr>
	</form>
  </table>
<br>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>