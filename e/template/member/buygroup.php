<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='���߳�ֵ';
$url="<a href='../../../'>��ҳ</a>&nbsp;>&nbsp;<a href='../cp/'>��Ա����</a>&nbsp;>&nbsp;���߳�ֵ";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="payform" method="post" action="../../payapi/BuyGroupPay.php">
    <tr class="header"> 
      <td height="25">��ѡ��Ҫ����ĳ�ֵ���ͣ�</td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
	  if($r[buygroupid]&&$level_r[$r[buygroupid]][level]>$level_r[$user[groupid]][level])
	  {
		  continue;
	  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td width="1%"> <input type="radio" name="id" value="<?=$r[id]?>"> 
            </td>
            <td width="97%"> 
              <?=$r[gmoney]?>
              Ԫ �� 
              <?=$r[gname]?>
              ��</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font color="#666666">
              <?=nl2br($r[gsay])?>
              </font></td>
          </tr>
        </table></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF">
      <td height="25">֧��ƽ̨��
        <SELECT name="payid" style="WIDTH: 120px">
          <?=$pays?>
        </SELECT></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><input type="submit" name="Submit" value="���ϳ�ֵ">
        &nbsp;&nbsp; <input type="button" name="Submit2" value="����" onclick="self.location.href='../../../';"> 
      </td>
    </tr>
  </form>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>