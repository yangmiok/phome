<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php

//���ò�ѯ�Զ����ֶ��б�,���ſ�ͷ������ö��Ÿ񿪣���ʽ��ui.�ֶ�����
$useraddf=',ui.userpic';

//��ҳSQL
$query='select '.eReturnSelectMemberF('userid,username,email,registertime,groupid','u.').$useraddf.' from '.eReturnMemberTable().' u'.$add." order by u.".egetmf('userid')." desc limit $offset,$line";
$sql=$empire->query($query);

//����
$public_diyr['pagetitle']='��Ա�б�';
$url="<a href='../../../'>��ҳ</a>&nbsp;>&nbsp;��Ա�б�";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="memberform" method="get" action="index.php">
    <input type="hidden" name="sear" value="1">
    <input type="hidden" name="groupid" value="<?=$groupid?>">
    <tr class="header"> 
      <td width="10%"><div align="center">ID</div></td>
      <td width="38%" height="25"><div align="center">�û���</div></td>
      <td width="30%" height="25"><div align="center">ע��ʱ��</div></td>
      <td width="22%" height="25"><div align="center"></div></td>
    </tr>
    <?php
	while($r=$empire->fetch($sql))
	{
		//ע��ʱ��
		$registertime=eReturnMemberRegtime($r['registertime'],"Y-m-d H:i:s");
		//�û���
		$groupname=$level_r[$r['groupid']]['groupname'];
		//�û�ͷ��
		$userpic=$r['userpic']?$r['userpic']:$public_r[newsurl].'e/data/images/nouserpic.gif';
	?>
    <tr bgcolor="#FFFFFF"> 
      <td><div align="center"> 
          <?=$r['userid']?>
        </div></td>
      <td height="25"> <a href='<?=$public_r[newsurl]?>e/space/?userid=<?=$r['userid']?>' target='_blank'> 
        <?=$r['username']?>
        </a> </td>
      <td height="25"><div align="center"> 
          <?=$registertime?>
        </div></td>
      <td height="25"><div align="center"> [<a href="<?=$public_r[newsurl]?>e/member/ShowInfo/?userid=<?=$r['userid']?>" target="_blank">��Ա����</a>] 
          [<a href="<?=$public_r[newsurl]?>e/space/?userid=<?=$r['userid']?>" target="_blank">��Ա�ռ�</a>]</div></td>
    </tr>
    <?
  	}
  	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="3"> 
        <?=$returnpage?>
      </td>
      <td height="25"> <div align="center"> 
          <input name="keyboard[]" type="text" id="keyboard" size="10">
          <input type="submit" name="Submit" value="����">
        </div></td>
    </tr>
  </form>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>