<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='�����б�';
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../../member/cp/>��Ա����</a>&nbsp;>&nbsp;�����б�";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<script type="text/javascript" src="../../data/js/jstime/WdatePicker.js"></script>
<form name="form1" method="get" action="index.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr> 
      <td>������Ϊ: 
        <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
        ʱ��� 
        <input name="starttime" type="text" id="starttime2" value="<?=$starttime?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        �� 
        <input name="endtime" type="text" id="endtime2" value="<?=$endtime?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        ֹ�Ķ��� 
        <input type="submit" name="Submit6" value="����"> <input name="sear" type="hidden" id="sear2" value="1"> 
      </td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class=tableborder>
    <tr class=header> 
      <td width="5%" height="23"> <div align="center">���</div></td>
      <td width="17%"><div align="center">���(����鿴)</div></td>
      <td width="17%"><div align="center">����ʱ��</div></td>
      <td width="12%"><div align="center">�ܽ��</div></td>
      <td width="14%"><div align="center">֧����ʽ</div></td>
      <td width="28%"><div align="center">״̬</div></td>
      <td width="7%"><div align="center">����</div></td>
    </tr>
<?
$todaytime=time();
$j=0;
while($r=$empire->fetch($sql))
{
	$j++;
	//��������
	$total=0;
	if($r[payby]==1)
	{
		$total=$r[alltotalfen]+$r[pstotal];
		$mytotal="<a href='#ecms' title='��Ʒ��(".$r[alltotalfen].")+�˷�(".$r[pstotal].")'>".$total." ��</a>";
	}
	else
	{
		//��Ʊ
		$fpa='';
		$pre='';
		if($r[fp])
		{
			$fpa="+��Ʊ��(".$r[fptotal].")";
		}
		//�Ż�
		if($r['pretotal'])
		{
			$pre="-�Ż�(".$r[pretotal].")";
		}
		$total=$r[alltotal]+$r[pstotal]+$r[fptotal]-$r[pretotal];
		$mytotal="<a href='#ecms' title='��Ʒ��(".$r[alltotal].")+�˷�(".$r[pstotal].")".$fpa.$pre."'>".$total." Ԫ</a>";
	}
	//֧����ʽ
	if($r[payby]==1)
	{
		$payfsname=$r[payfsname]."<br>(��������)";
	}
	elseif($r[payby]==2)
	{
		$payfsname=$r[payfsname]."<br>(����)";
	}
	else
	{
		$payfsname=$r[payfsname];
	}
	//״̬
	if($r['checked']==1)
	{
		$ch="��ȷ��";
	}
	elseif($r['checked']==2)
	{
		$ch="ȡ��";
	}
	elseif($r['checked']==3)
	{
		$ch="�˻�";
	}
	else
	{
		$ch="<font color=red>δȷ��</font>";
	}
	if($r['outproduct']==1)
	{
		$ou="�ѷ���";
	}
	elseif($r['outproduct']==2)
	{
		$ou="������";
	}
	else
	{
		$ou="<font color=red>δ����</font>";
	}
	if($r['haveprice']==1)
	{
		$ha="�Ѹ���";
	}
	else
	{
		$ha="<font color=red>δ����</font>";
	}
	//����
	$doing='<a href="../doaction.php?enews=DelDd&ddid='.$r[ddid].'" onclick="return confirm(\'ȷ��Ҫȡ����\');">ȡ��</a>';
	if($r['checked']||$r['outproduct']||$r['haveprice'])
	{
		$doing='--';
	}
	$dddeltime=$shoppr['dddeltime']*60;
	if($todaytime-$dddeltime>to_time($r['ddtime']))
	{
		$doing='--';
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <div align="center">
          <?=$j?>
          </div></td>
      <td> <div align="center"><a href="#ecms" onclick="window.open('../ShowDd/?ddid=<?=$r[ddid]?>','','width=700,height=600,scrollbars=yes,resizable=yes');"> 
          <?=$r[ddno]?>
          </a></div></td>
      <td> <div align="center"> 
          <?=$r[ddtime]?>
        </div></td>
      <td> <div align="center"> 
          <?=$mytotal?>
        </div></td>
      <td><div align="center"> 
          <?=$payfsname?>
        </div></td>
      <td> <div align="center"><strong> 
          <?=$ha?>
          </strong>/<strong> 
          <?=$ou?>
          </strong>/<strong> 
          <?=$ch?>
          </strong></div></td>
      <td><div align="center"><?=$doing?></div></td>
    </tr>
<?
}
?>
    <tr bgcolor="#FFFFFF"> 
      <td> <div align="center"></div></td>
      <td colspan="6"> <div align="left">&nbsp; 
          <?=$returnpage?>
        </div></td>
    </tr>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>