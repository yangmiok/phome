<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='��Ա����';
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../cp/>��Ա����</a>";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <tr class="header"> 
    <td height="25">��Ա����</td>
  </tr>
  <tr> 
    <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="220" valign="top"> 
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="6">
              <tr> 
                <td height="25"><div align="center"><img src="<?=$userpic?>" width="158" height="158" style="border:1px solid #cccccc;" /></div></td>
              </tr>
              <tr> 
                <td height="25"><div align="center"><a href="../../space/?userid=<?=$user[userid]?>" target="_blank"> 
                    <?=$user[username]?>
                    </a></div></td>
              </tr>
            </table>
          </td>
          <td> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
              <tr bgcolor="#FFFFFF"> 
                <td width="15%" height="25">�û�ID:</td>
                <td width="85%" height="25"> 
                  <?=$user[userid]?>
                </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">�û���:</td>
                <td height="25"> 
                  <?=$user[username]?>
                  &nbsp;&nbsp;(<a href="../../space/?userid=<?=$user[userid]?>" target="_blank">�ҵĻ�Ա�ռ�</a>) 
                </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td width="33%" height="25">ע��ʱ��:</td>
                <td width="67%" height="25"> 
                  <?=$registertime?>
                </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">��Ա�ȼ�:</td>
                <td height="25"> 
                  <?=$level_r[$r[groupid]][groupname]?>
                </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">ʣ����Ч��:</td>
                <td height="25"> 
                  <?=$userdate?>
                  �� </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">ʣ�����:</td>
                <td height="25"> 
                  <?=$r[userfen]?>
                  ��</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">�ʻ����:</td>
                <td height="25"> 
                  <?=$r[money]?>
                  Ԫ </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">����Ϣ:</td>
                <td height="25"> 
                  <?=$havemsg?>
                </td>
              </tr>
            </table>
            <div align="center"> </div></td>
        </tr>
      </table> 
    </td>
  </tr>
  <tr>
    <td height="20">�������</td>
  </tr>
  <tr>
    <td height="36" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="16%" height="25"> 
            <div align="center"><a href="../EditInfo/"><img src="../../data/images/membercp/userinfo.gif" width="16" height="16" border="0" align="absmiddle"> 
              �޸�����</a></div></td>
          <td width="16%"> 
            <div align="center"><a href="../msg/"><img src="../../data/images/membercp/msg.gif" width="16" height="16" border="0" align="absmiddle"> 
              վ����Ϣ</a></div></td>
          <td width="16%"> 
            <div align="center"><a href="../mspace/SetSpace.php"><img src="../../data/images/membercp/space.gif" width="16" height="16" border="0" align="absmiddle"> 
              �ռ�����</a></div></td>
          <td width="16%"> 
            <div align="center"><a href="../../DoInfo/"><img src="../../data/images/membercp/info.gif" width="16" height="16" border="0" align="absmiddle"> 
              ������Ϣ</a></div></td>
          <td width="16%"> 
            <div align="center"><a href="../fava/"><img src="../../data/images/membercp/favitorie.gif" width="16" height="16" border="0" align="absmiddle"> 
              �����ղؼ�</a></div></td>
          <td width="16%">
<div align="center"><a href="../friend/"><img src="../../data/images/membercp/friend.gif" width="16" height="16" border="0" align="absmiddle"> 
              �ҵĺ���</a></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>