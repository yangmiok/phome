<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='���Ѽ�¼';
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../cp/>��Ա����</a>&nbsp;>&nbsp;���Ѽ�¼";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
          <tr class="header"> 
            <td width="55%" height="25"><div align="center">����</div></td>
            <td width="16%" height="25"><div align="center">�۳�����</div></td>
            <td width="29%" height="25"><div align="center">ʱ��</div></td>
          </tr>
	<?php
	while($r=$empire->fetch($sql))
	{
		if(empty($class_r[$r[classid]][tbname]))
		{continue;}
		$nr=$empire->fetch1("select title,isurl,titleurl,classid from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]." where id='$r[id]' limit 1");
		//��������
		$titlelink=sys_ReturnBqTitleLink($nr);
		if(!$nr['classid'])
		{
			$r['title']="����Ϣ��ɾ��";
			$titlelink="#EmpireCMS";
		}
		if($r['online']==0)
		{
			$type='����';
		}
		elseif($r['online']==1)
		{
			$type='�ۿ�';
		}
		elseif($r['online']==2)
		{
			$type='�鿴';
		}
		elseif($r['online']==3)
		{
			$type='����';
		}
	?>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">[
              <?=$type?>
              ] &nbsp;<a href='<?=$titlelink?>' target='_blank'> 
              <?=$r[title]?>
              </a> </td>
            <td height="25"><div align="center"> 
                <?=$r[cardfen]?>
              </div></td>
            <td height="25"><div align="center"> 
                <?=date("Y-m-d H:i:s",$r[truetime])?>
              </div></td>
          </tr>
          <?
	}
	?>
          <tr bgcolor="#FFFFFF"> 
            <td height="25" colspan="3"> 
              <?=$returnpage?>            </td>
          </tr>
        </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>