<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("class/hShopSysFun.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
//��֤Ȩ��
CheckLevel($logininid,$loginin,$classid,"shopdd");
$enews=ehtmlspecialchars($_GET['enews']);
$url="�鿴����";
$ddid=(int)$_GET['ddid'];
if(!$ddid)
{
	printerror('ErrorUrl','');
}
$r=$empire->fetch1("select * from {$dbtbpre}enewsshopdd where ddid='$ddid'");
if(!$r['ddid'])
{
	printerror('ErrorUrl','');
}
$addr=$empire->fetch1("select * from {$dbtbpre}enewsshopdd_add where ddid='$ddid'");
//�ύ��
if(empty($r[userid]))//�ǻ�Ա
{
	$username="<font color=cccccc>�ο�</font>";
}
else
{
	$username="<a href='../member/AddMember.php?enews=EditMember&userid=".$r[userid].$ecms_hashur['ehref']."' target=_blank>".$r[username]."</a>";
}
//��Ҫ��Ʊ
$fp="��";
if($r[fp])
{
	$fp="��";
}
//���
$total=0;
if($r[payby]==1)
{
	$pstotal=$r[pstotal]." ��";
	$alltotal=$r[alltotalfen]." ��";
	$total=$r[pstotal]+$r[alltotalfen];
	$mytotal=$total." ��";
}
else
{
	$pstotal=$r[pstotal]." Ԫ";
	$alltotal=$r[alltotal]." Ԫ";
	$total=$r[pstotal]+$r[alltotal]+$r[fptotal]-$r[pretotal];
	$mytotal=$total." Ԫ";
}
//֧����ʽ
if($r[payby]==1)
{
	$payfsname=$r[payfsname]."(���ֹ���)";
}
elseif($r[payby]==2)
{
	$payfsname=$r[payfsname]."(����)";
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
//����
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
//��ʾ��Ʒ��Ϣ
function ShowBuyproduct($buycar,$payby){
	global $empire,$dbtbpre;
	$record="!";
	$field="|";
	$buycarr=explode($record,$buycar);
	$bcount=count($buycarr);
	$totalmoney=0;
	$totalfen=0;
	?>
	<table width='100%' border=0 align=center cellpadding=3 cellspacing=1>
        <tr class='header'> 
            <td width='9%' height=23> <div align=center>���</div></td>
            <td width='42%'> <div align=center>��Ʒ����</div></td>
            <td width='15%'> <div align=center>����</div></td>
            <td width='10%'> <div align=center>����</div></td>
            <td width='19%'> <div align=center>С��</div></td>
        </tr>
	<?php
	$j=0;
	for($i=0;$i<$bcount-1;$i++)
	{
		$j++;
		$pr=explode($field,$buycarr[$i]);
		$productid=$pr[1];
		$fr=explode(",",$pr[1]);
		//ID
		$classid=(int)$fr[0];
		$id=(int)$fr[1];
		//����
		$addatt='';
		if($pr[2])
		{
			$addatt=$pr[2];
		}
		//����
		$pnum=(int)$pr[3];
		if(empty($pnum))
		{
			$pnum=1;
		}
		//����
		$price=$pr[4];
		$thistotal=$price*$pnum;
		$buyfen=$pr[5];
		$thistotalfen=$buyfen*$pnum;
		if($payby==1)
		{
			$showprice=$buyfen." ��";
			$showthistotal=$thistotalfen." ��";
		}
		else
		{
			$showprice=$price." Ԫ";
			$showthistotal=$thistotal." Ԫ";
		}
		//��Ʒ����
		$title=stripSlashes($pr[6]);
		//��������
		$titleurl="../../public/InfoUrl/?classid=$classid&id=$id";
		$totalmoney+=$thistotal;
		$totalfen+=$thistotalfen;
		?>
		<tr>
	<td align=center><?=$j?></td>
	<td align=center><a href="<?=$titleurl?>" target="_blank"><?=$title?></a><?=$addatt?' - '.$addatt:''?></td>
	<td align=right><b>��<?=$showprice?></b></td>
	<td align=right><?=$pnum?></td>
	<td align=right><?=$showthistotal?></td>
	</tr>
		<?php
    }
	//��������
	if($payby==1)
	{
		?>
	<tr> 
      <td colspan=5><div align=right>�ϼƵ���:<strong><?=$totalfen?></strong></div></td>
      <td>&nbsp;</td>
    </tr>
		<?php
	}
	else
	{
		?>
	<tr> 
      <td colspan=5><div align=right>�ϼ�:<strong>��<?=$totalmoney?></strong></div></td>
      <td>&nbsp;</td>
    </tr>
		<?php
	}
	?>
	</table>
	<?php
}

//------ ������־ ------
//�����¼�

$shopecms_r=array
(
	'SetChecked'=>'���ö���״̬',
	'SetOutProduct'=>'���÷���״̬',
	'SetHaveprice'=>'���ø���״̬',
	'DelDd'=>'ɾ������',
	'EditPretotal'=>'�޸��Żݽ��',
	'DdRetext'=>'�޸ĺ�̨������ע',
	'DoCutMaxnum'=>'���ÿ��',
);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>�鿴����</title>
<script>
function PrintDd()
{
	pdiv.style.display="none";
	window.print();
}
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="showddform" id="showddform" method="post" action="ecmsshop.php" onsubmit="return confirm('ȷ��Ҫ����?');">
<?=$ecms_hashur['form']?>
  <input name="enews" type="hidden" id="enews" value="DdRetext">
  <input name="ddid" type="hidden" id="ddid" value="<?=$ddid?>">
  <tr> 
    <td width="61%" height="27" bgcolor="#FFFFFF"><strong>����ID: 
      <?=$r[ddno]?>
      </strong></td>
    <td width="39%" bgcolor="#FFFFFF"><strong>�µ�ʱ��: 
      <?=$r[ddtime]?>
      </strong></td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>��Ʒ��Ϣ</strong></td>
  </tr>
  <tr> 
    <td colspan="2"> 
      <?
	  ShowBuyproduct($addr[buycar],$r[payby]);
	  ?>    </td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>������Ϣ</strong></td>
  </tr>
  <tr> 
    <td height="23" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        
        <tr>
          <td height="25"><div align="right">�ύ�ߣ�</div></td>
          <td><?=$username?></td>
          <td><div align="right">�ύ��IP��ַ��</div></td>
          <td><strong>
            <?=$r[userip]?>
          </strong></td>
        </tr>
        <tr> 
          <td width="15%" height="25"> 
            <div align="right">�����ţ�</div></td>
          <td width="35%"><strong> 
            <?=$r[ddno]?>
            </strong></td>
          <td width="15%"><div align="right">����״̬��</div></td>
          <td width="35%"><strong> 
            <?=$ha?>
            </strong>/<strong> 
            <?=$ou?>
            </strong>/<strong> 
            <?=$ch?>
            </strong></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">�µ�ʱ�䣺</div></td>
          <td><strong> 
            <?=$r[ddtime]?>
            </strong></td>
          <td><div align="right">��Ʒ�ܽ�</div></td>
          <td><strong>
            <?=$alltotal?>
            </strong></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">���ͷ�ʽ��</div></td>
          <td><strong>
            <?=$r[psname]?>
            </strong></td>
          <td><div align="right">+ ��Ʒ�˷ѣ�</div></td>
          <td><strong>
            <?=$pstotal?>
            </strong></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">֧����ʽ��</div></td>
          <td><strong>
            <?=$payfsname?>
            </strong></td>
          <td><div align="right">+ ��Ʊ���ã�</div></td>
          <td><?=$r[fptotal]?></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">��Ҫ��Ʊ��</div></td>
          <td><?=$fp?></td>
          <td><div align="right">- �Żݣ�</div></td>
          <td><?=$r[pretotal]?></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">��Ʊ̧ͷ��</div></td>
          <td><strong> 
            <?=stripSlashes($r[fptt])?>
            </strong></td>
          <td><div align="right">�����ܽ�</div></td>
          <td><strong>
            <?=$mytotal?>
          </strong></td>
        </tr>
        <tr>
          <td height="25"><div align="right">��Ʊ���ƣ�</div></td>
          <td colspan="3"><strong>
            <?=stripSlashes($r[fpname])?>
          </strong></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>�ջ�����Ϣ</strong></td>
  </tr>
  <tr> 
    <td colspan="2"><table width="100%%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="20%" height="25">��ʵ����:</td>
          <td width="80%"> 
            <?=stripSlashes($r[truename])?>          </td>
        </tr>
        <tr> 
          <td height="25">QQ:</td>
          <td> 
            <?=stripSlashes($r[oicq])?>          </td>
        </tr>
        <tr> 
          <td height="25">MSN:</td>
          <td> 
            <?=stripSlashes($r[msn])?>          </td>
        </tr>
        <tr> 
          <td height="25">�̶��绰:</td>
          <td> 
            <?=stripSlashes($r[mycall])?>          </td>
        </tr>
        <tr> 
          <td height="25">�ֻ�:</td>
          <td> 
            <?=stripSlashes($r[phone])?>          </td>
        </tr>
        <tr> 
          <td height="25">��ϵ����:</td>
          <td> 
            <?=stripSlashes($r[email])?>          </td>
        </tr>
        <tr> 
          <td height="25">��ϵ��ַ:</td>
          <td> 
            <?=stripSlashes($r[address])?>          </td>
        </tr>
        <tr> 
          <td height="25">�ʱ�:</td>
          <td> 
            <?=stripSlashes($r[zip])?>          </td>
        </tr>
        <tr>
          <td height="25">��־����:</td>
          <td><?=stripSlashes($r[signbuild])?></td>
        </tr>
        <tr>
          <td height="25">����ͻ�ʱ��:</td>
          <td><?=stripSlashes($r[besttime])?></td>
        </tr>
        <tr> 
          <td height="25">��ע:</td>
          <td> 
            <?=nl2br(stripSlashes($addr[bz]))?>          </td>
        </tr>
      </table></td>
  </tr>
  <tbody id="pdiv">
  <tr>
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>��ز���</strong></td>
  </tr>
  <tr>
    <td height="23" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="16%">��̨��ע����:<br>
          <br>
          <font color="#666666">(ǰ̨��Ա�ɲ鿴�������ṩ��ݺŵ���Ϣ)</font></td>
        <td width="77%"><textarea name="retext" cols="65" rows="6" id="retext"><?=stripSlashes($addr['retext'])?></textarea></td>
        <td width="7%"><input type="submit" name="Submit2" value="�ύ" onClick="document.showddform.enews.value='DdRetext';"></td>
      </tr>
      <tr>
        <td height="25">�޸��Żݽ�</td>
        <td><input name="pretotal" type="text" id="pretotal" value="<?=$r[pretotal]?>">
        �޸�ԭ��
          <input name="bz" type="text" id="bz"></td>
        <td><input type="submit" name="Submit3" value="�ύ" onClick="document.showddform.enews.value='EditPretotal';"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>����������־</strong></td>
  </tr>
  <tr>
    <td height="23" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
      <tr class="header">
        <td width="21%" height="23"><div align="center">����ʱ��</div></td>
        <td width="17%"><div align="center">������</div></td>
        <td width="19%"><div align="center">�¼�</div></td>
        <td width="19%"><div align="center">��������</div></td>
        <td width="24%"><div align="center">����ԭ��</div></td>
      </tr>
	  <?php
	  $logsql=$empire->query("select logid,userid,username,ecms,bz,addbz,logtime from {$dbtbpre}enewsshop_ddlog where ddid='$ddid' order by logid desc");
	  while($logr=$empire->fetch($logsql))
	  {
		  $empirecms=$shopecms_r[$logr['ecms']];
		  if($logr['ecms']=='DoCutMaxnum')
		  {
			  $logr['addbz']=$logr['addbz']=='ecms=1'?'��ԭ���':'���ٿ��';
		  }
	  ?>
      <tr bgcolor="#ffffff">
        <td height="23"><div align="center"><?=$logr['logtime']?></div></td>
        <td><div align="center"><?=$logr['username']?></div></td>
        <td><div align="center"><?=$empirecms?></div></td>
        <td><?=$logr['addbz']?></td>
        <td><?=$logr['bz']?></td>
      </tr>
      <?php
	  }
	  ?>
    </table></td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center"> 
        <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr> 
            <td><div align="center">
                <input type="button" name="Submit" value=" �� ӡ " onclick="javascript:PrintDd();">
              </div></td>
          </tr>
        </table>
      </div></td>
  </tr>
  </tbody>
 </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>