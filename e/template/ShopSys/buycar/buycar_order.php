<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$buycar=getcvar('mybuycar');
if(empty($buycar))
{
	printerror('��Ĺ��ﳵû����Ʒ','',1,0,1);
}
$record="!";
$field="|";
$totalmoney=0;	//��Ʒ�ܽ��
$buytype=0;	//֧�����ͣ�1Ϊ���,0Ϊ����
$totalfen=0;	//��Ʒ�ܻ���
$classids='';	//��Ŀ����
$cdh='';
$buycarr=explode($record,$buycar);
$bcount=count($buycarr);
?>
<table width="100%" border=0 align=center cellpadding=3 cellspacing=1>
<tr class="header"> 
	<td width="41%" height=23><div align="center">��Ʒ����</div></td>
	<td width="15%"><div align="center">�г��۸�</div></td>
	<td width="15%"><div align="center">�Żݼ۸�</div></td>
	<td width="8%"><div align="center">����</div></td>
	<td width="21%"><div align="center">С��</div></td>
</tr>
<?php
for($i=0;$i<$bcount-1;$i++)
{
	$pr=explode($field,$buycarr[$i]);
	$productid=$pr[1];
	$fr=explode(",",$pr[1]);
	//ID
	$classid=(int)$fr[0];
	$id=(int)$fr[1];
	if(empty($class_r[$classid][tbname]))
	{
		continue;
	}
	//����
	$addatt='';
	if($pr[2])
	{
		$addatt=$pr[2];
	}
	//����
	$pnum=(int)$pr[3];
	if($pnum<1)
	{
		$pnum=1;
	}
	//ȡ�ò�Ʒ��Ϣ
	$productr=$empire->fetch1("select title,tprice,price,isurl,titleurl,classid,id,titlepic,buyfen from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' limit 1");
	if(!$productr['id']||$productr['classid']!=$classid)
	{
		continue;
	}
	//�Ƿ�ȫ������
	if(!$productr[buyfen])
	{
		$buytype=1;
	}
	$thistotalfen=$productr[buyfen]*$pnum;
	$totalfen+=$thistotalfen;
	//��ƷͼƬ
	if(empty($productr[titlepic]))
	{
		$productr[titlepic]="../../data/images/notimg.gif";
	}
	//��������
	$titleurl=sys_ReturnBqTitleLink($productr);
	$thistotal=$productr[price]*$pnum;
	$totalmoney+=$thistotal;
	//��Ŀ����
	$classids.=$cdh.$productr['classid'];
	$cdh=',';
?>
<tr>
	<td align="center" height=23><a href="<?=$titleurl?>" target="_blank"><?=$productr[title]?></a><?=$addatt?' - '.$addatt:''?></td>
	<td align="right">��<?=$productr[tprice]?></td>
	<td align="right"><b>��<?=$productr[price]?></b></td>
	<td align="right"><?=$pnum?></td>
	<td align="right">��<?=$thistotal?></td>
</tr>
<?php
}
?>
<?php
if(!$buytype)//��������
{
?>
<tr height="25"> 
    <td colspan="5"><div align="right">�ϼƵ���:<strong><?=$totalfen?></strong></div></td>
</tr>
<?php
}
else
{
?>
<tr height="27"> 
    <td colspan="5"><div align="right">�ϼ�:<strong>��<?=$totalmoney?></strong></div></td>
</tr>
<?php
}
?>
</table>
