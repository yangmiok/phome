<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$buycar=getcvar('mybuycar');
$record="!";
$field="|";
$totalmoney=0;	//��Ʒ�ܽ��
$buytype=0;	//֧�����ͣ�1Ϊ���,0Ϊ����
$totalfen=0;	//��Ʒ�ܻ���
$buycarr=explode($record,$buycar);
$bcount=count($buycarr);
?>
<table width='100%' border=0 align=center cellpadding=3 cellspacing=1>
  <form name=form1 method=post action='../doaction.php'>
  <input type=hidden name=enews value=EditBuycar>
    <tr class='header'> 
      <td width='16%' height=23> <div align=center>ͼƬ</div></td>
      <td width='29%'> <div align=center>��Ʒ����</div></td>
      <td width='14%'> <div align=center>�г��۸�</div></td>
      <td width='14%'> <div align=center>�Żݼ۸�</div></td>
      <td width='8%'> <div align=center>����</div></td>
      <td width='14%'> <div align=center>С��</div></td>
      <td width='5%'> <div align=center>ɾ��</div></td>
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
	$totalfen+=$productr[buyfen]*$pnum;
	//��ƷͼƬ
	if(empty($productr[titlepic]))
	{
		$productr[titlepic]="../../data/images/notimg.gif";
	}
	//��������
	$titleurl=sys_ReturnBqTitleLink($productr);
	$thistotal=$productr[price]*$pnum;
	$totalmoney+=$thistotal;
?>
<tr>
	<td align="center"><a href="<?=$titleurl?>" target="_blank"><img src="<?=$productr[titlepic]?>" border=0 width=80 height=80></a></td>
	<td align="center"><a href="<?=$titleurl?>" target="_blank"><?=$productr[title]?></a><?=$addatt?' - '.$addatt:''?></td>
	<td align="right">��<?=$productr[tprice]?></td>
	<td align="right"><b>��<?=$productr[price]?></b></td>
	<td align="center"><input type="text" name="num[]" value="<?=$pnum?>" size="6"></td>
	<td align="right">��<?=$thistotal?></td>
	<td align="center"><input type="checkbox" name="del[]" value="<?=$productid.'|'.$addatt?>"></td>
	<input type="hidden" name="productid[]" value="<?=$productid?>">
	<input type="hidden" name="addatt[]" value="<?=$addatt?>">
</tr>
<?php
}
?>
<?php
if(!$buytype)//��������
{
?>
<tr height="25"> 
    <td colspan="6"><div align="right">�ϼƵ���:<strong><?=$totalfen?></strong></div></td>
    <td>&nbsp;</td>
</tr>
<?php
}
else
{
?>
<tr height="27"> 
    <td colspan="6"><div align="right">�ϼ�:<strong>��<?=$totalmoney?></strong></div></td>
    <td>&nbsp;</td>
</tr>
<?php
}
?>
<tr> 
    <td colspan="7" height="25"><div align="right">
		<a href="../doaction.php?enews=ClearBuycar"><img src="../../data/images/shop/clearbuycar.gif" width=92 height=23 border=0></a>&nbsp;&nbsp;
          <input name="imageField" type="image" src="../../data/images/shop/editbuycar.gif" width=135 height=23 border=0>
          &nbsp;&nbsp;
		<a href="javascript:window.close();"><img src="../../data/images/shop/buynext.gif" width=87 height=23 border=0></a>
		&nbsp;&nbsp;
		<a href="../order/"><img src="../../data/images/shop/buycarnext.gif" width=87 height=19 border=0></a>
	</div></td>
</tr>
</form>
</table>
