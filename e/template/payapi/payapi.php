<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='����֧��';
$url="<a href='../../'>��ҳ</a>&nbsp;>&nbsp;<a href=../member/cp/>��Ա����</a>&nbsp;>&nbsp;����֧��";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<script>
function ChangeShowBuyFen(amount){
	var fen;
	fen=Math.floor(amount)*<?=$pr[paymoneytofen]?>;
	document.getElementById("showbuyfen").innerHTML=fen+" ��";
}
</script>
<form name="paytofenform" method="post" action="pay.php">
  <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td height="25" colspan="2">��������� 
      <input type="hidden" name="phome" value="PayToFen"></td>
    </tr>
    <tr> 
      <td width="127" height="25" bgcolor="#FFFFFF">�����</td>
      <td width="358" bgcolor="#FFFFFF"> <input name="money" type="text" value="" size="8" onchange="ChangeShowBuyFen(document.paytofenform.money.value);">
        Ԫ <font color="#333333">( 1Ԫ = 
        <?=$pr[paymoneytofen]?>
        ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">���������</td>
      <td bgcolor="#FFFFFF" id="showbuyfen"> 0 ��</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">֧��ƽ̨��</td>
      <td height="25" bgcolor="#FFFFFF"><SELECT name="payid" style="WIDTH: 120px">
          <?=$pays?>
        </SELECT></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="ȷ������"></td>
    </tr>
  </table>
</form>
<br><br>
<form name="paytomoneyform" method="post" action="pay.php">
  <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td height="25" colspan="2">��Ԥ��� 
      <input name="phome" type="hidden" id="phome" value="PayToMoney"></td>
    </tr>
    <tr> 
      <td width="127" height="25" bgcolor="#FFFFFF">��</td>
      <td width="358" bgcolor="#FFFFFF"> <input name="money" type="text" value="" size="8">
        Ԫ</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">֧��ƽ̨��</td>
      <td height="25" bgcolor="#FFFFFF"><SELECT name="payid" style="WIDTH: 120px">
          <?=$pays?>
        </SELECT></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"><input type="submit" name="Submit3" value="ȷ��֧��"></td>
    </tr>
  </table>
</form>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>