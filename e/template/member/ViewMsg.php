<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='�鿴��Ϣ';
$url="<a href=../../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../../cp/>��Ա����</a>&nbsp;>&nbsp;<a href=../../msg/>��Ϣ�б�</a>&nbsp;>&nbsp;�鿴��Ϣ";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
          <form name="form1" method="post" action="../../doaction.php">
            <tr class="header"> 
              <td height="23" colspan="2">
                <?=stripSlashes($r[title])?>              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td width="19%" height="25">�����ߣ�</td>
              <td width="81%" height="25"><a href="../../ShowInfo/?userid=<?=$r[from_userid]?>"> 
                <?=$r[from_username]?>
                </a></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">����ʱ�䣺</td>
              <td height="25">
                <?=$r[msgtime]?>              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25" valign="top">���ݣ�</td>
              <td height="25"> 
                <?=nl2br(stripSlashes($r[msgtext]))?>              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25" valign="top">&nbsp;</td>
              <td height="25">[<a href="#ecms" onclick="javascript:history.go(-1);"><strong>����</strong></a>] 
                [<a href="../AddMsg/?enews=AddMsg&re=1&mid=<?=$mid?>"><strong>�ظ�</strong></a>] 
                [<a href="../AddMsg/?enews=AddMsg&mid=<?=$mid?>"><strong>ת��</strong></a>] 
                [<a href="../../doaction.php?enews=DelMsg&mid=<?=$mid?>" onclick="return confirm('ȷ��Ҫɾ��?');"><strong>ɾ��</strong></a>]</td>
            </tr>
          </form>
        </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>