<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$qappname=$appr['qappname'];

$public_diyr['pagetitle']='�󶨵�¼';
$url="λ��:<a href='../../'>��ҳ</a>&nbsp;>&nbsp;�󶨵�¼";
$regurl=$public_r['newsurl'].'e/member/register/?tobind=1';
$loginurl=$public_r['newsurl'].'e/member/login/?tobind=1';
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td height="30" colspan="2"><font color="#FF0000"><strong>���ã���ͨ��<?=$qappname?>�ɹ���¼��</strong></font></td>
  </tr>
  <tr>
    <td width="50%" valign="top"><form name="bindform" method="post" action="doaction.php">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td height="25"><div align="center"><strong>1������������˺ţ����Ե�������¼��</strong></div></td>
        </tr>
        <tr>
          <td height="50"><div align="center">
            <input type="button" name="Submit" value="���ϵ�¼��" onclick="window.open('<?=$loginurl?>');">
            <input name="enews" type="hidden" id="enews" value="BindUser">
          </div></td>
          </tr>
        <tr>
          <td height="25"><div align="center">��ʾ������ɹ����´�
            <?=$qappname?>
            ��ʽ��¼����ֱ�ӵ�¼���������˺š�</div></td>
          </tr>
      </table>
        </form>
    </td>
    <td width="50%" valign="top"><form name="bindregform" method="post" action="doaction.php">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td height="25"><div align="center"><strong>2�������û���˺ţ������Կ���ע��</strong></div></td>
          </tr>
        <tr>
          <td height="50"><div align="center">
            <input type="button" name="Submit2" value="����ע���" onclick="window.open('<?=$regurl?>');">
            <input name="enews" type="hidden" id="enews" value="BindReg">
          </div></td>
          </tr>
        <tr>
          <td height="25"><div align="center">��ʾ������ɹ����´�
            <?=$qappname?>
            ��ʽ��¼����ֱ�ӵ�¼���������˺š�</div></td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>