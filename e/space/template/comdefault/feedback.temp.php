<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
//λ��
$url="$spacename &gt; ���߷���";
include("header.temp.php");
?>
<?=$spacegg?>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#96C8F1">
  <tr> 
    <td background="template/default/images/bg_title_sider.gif"><b>���߷���</b></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <form name="addfeedback" method="post" action="../member/mspace/index.php">
          <input type="hidden" name="userid" value="<?=$userid?>">
          <input type="hidden" name="enews" value="AddMemberFeedback">
          <tr> 
            <td width="18%" height="25">��ϵ��</td>
            <td width="82%"><input name="name" type="text" id="name" size="38"> 
            </td>
          </tr>
          <tr> 
            <td height="25">��˾����</td>
            <td><input name="company" type="text" id="company" size="38"> </td>
          </tr>
          <tr> 
            <td height="25">��ϵ����</td>
            <td><input name="email" type="text" id="email" size="38"> </td>
          </tr>
          <tr> 
            <td height="25">��ϵ�绰</td>
            <td><input name="phone" type="text" id="phone" size="38"></td>
          </tr>
          <tr> 
            <td height="25">����</td>
            <td><input name="fax" type="text" id="fax" size="38"> </td>
          </tr>
          <tr> 
            <td height="25">��ϵ��ַ</td>
            <td><input name="address" type="text" id="address" size="45">
              �ʱ�: 
              <input name="zip" type="text" id="zip" size="8"> </td>
          </tr>
          <tr> 
            <td height="25">��������</td>
            <td><input name="title" type="text" id="title" value="<?=RepPostStr($_GET['title'],1)?>" size="60"> 
            </td>
          </tr>
          <tr> 
            <td height="25" valign="top">��������</td>
            <td><textarea name="ftext" cols="60" rows="12" id="ftext"></textarea> 
            </td>
          </tr>
          <tr>
            <td height="25">��֤��</td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="52"><input name="key" type="text" id="key" size="6" /></td>
                  <td id="spacefbshowkey"><a href="#EmpireCMS" onclick="edoshowkey('spacefbshowkey','spacefb','<?=$public_r['newsurl']?>');" title="�����ʾ��֤��">�����ʾ��֤��</a></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="25">&nbsp;</td>
            <td><input type="submit" name="Submit" value="�ύ"> </td>
          </tr>
        </form>
      </table> </td>
  </tr>
</table>
<?php
include("footer.temp.php");
?>