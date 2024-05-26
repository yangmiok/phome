<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../data/dbcache/class.php");
require "../".LoadLang("pub/fun.php");
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

//�����趨
function SetShopDd($add,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"shopdd");
	$ddid=$add['ddid'];
	$doing=$add['doing'];
	$checked=(int)$add['checked'];
	$haveprice=(int)$add['haveprice'];
	$outproduct=(int)$add['outproduct'];
	$count=count($ddid);
	if(empty($count))
	{
		printerror("NotSetDdid","history.go(-1)");
	}
	$shoppr=ShopSys_hReturnSet();
	$add='';
	$ids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$ddid[$i]=(int)$ddid[$i];
		$ids.=$dh.$ddid[$i];
		$dh=',';
    }
	$add='ddid in ('.$ids.')';
	$mess='ErrorUrl';
	$log='';
	if($doing==1)	//����״̬
	{
		$sql=$empire->query("update {$dbtbpre}enewsshopdd set checked='$checked' where ".$add);
		$mess="SetCheckedSuccess";
		$log="doing=$doing&do=SetChecked&checked=$checked<br>ddid=$ids";
		//������־
		$log_ecms='SetChecked';
		$log_bz='';
		if($checked==1)
		{
			$log_addbz='ȷ��';
		}
		elseif($checked==2)
		{
			$log_addbz='ȡ��';
		}
		elseif($checked==3)
		{
			$log_addbz='�˻�';
		}
		elseif($checked==0)
		{
			$log_addbz='δȷ��';
		}
		//д�붩����־
		if($ids)
		{
			$logsql=$empire->query("select ddid,havecutnum from {$dbtbpre}enewsshopdd where ".$add);
			while($logr=$empire->fetch($logsql))
			{
				ShopSys_DdInsertLog($logr['ddid'],$log_ecms,$log_bz,$log_addbz);//������־
				//���
				if($shoppr['cutnumtype']==0&&$checked==2&&$logr['havecutnum'])
				{
					$ddaddr=$empire->fetch1("select buycar from {$dbtbpre}enewsshopdd_add where ddid='$logr[ddid]'");
					Shopsys_hCutMaxnum($logr['ddid'],$ddaddr['buycar'],$logr['havecutnum'],$shoppr,1);
				}
			}
		}
    }
	elseif($doing==2)	//����״̬
	{
		$sql=$empire->query("update {$dbtbpre}enewsshopdd set outproduct='$outproduct' where ".$add);
		$mess="SetOutProductSuccess";
		$log="doing=$doing&do=SetOutProduct&outproduct=$outproduct<br>ddid=$ids";
		//������־
		$log_ecms='SetOutProduct';
		$log_bz='';
		if($outproduct==1)
		{
			$log_addbz='�ѷ���';
		}
		elseif($outproduct==2)
		{
			$log_addbz='������';
		}
		elseif($outproduct==0)
		{
			$log_addbz='δ����';
		}
		//д�붩����־
		if($ids)
		{
			$logsql=$empire->query("select ddid from {$dbtbpre}enewsshopdd where ".$add);
			while($logr=$empire->fetch($logsql))
			{
				ShopSys_DdInsertLog($logr['ddid'],$log_ecms,$log_bz,$log_addbz);//������־
			}
		}
    }
	elseif($doing==3)	//����״̬
	{
		$sql=$empire->query("update {$dbtbpre}enewsshopdd set haveprice='$haveprice' where ".$add);
		$mess="SetHavepriceSuccess";
		$log="doing=$doing&do=SetHaveprice&haveprice=$haveprice<br>ddid=$ids";
		//������־
		$log_ecms='SetHaveprice';
		$log_bz='';
		if($haveprice==1)
		{
			$log_addbz='�Ѹ���';
		}
		elseif($haveprice==0)
		{
			$log_addbz='δ����';
		}
		//д�붩����־
		if($ids)
		{
			$logsql=$empire->query("select ddid,havecutnum from {$dbtbpre}enewsshopdd where ".$add);
			while($logr=$empire->fetch($logsql))
			{
				ShopSys_DdInsertLog($logr['ddid'],$log_ecms,$log_bz,$log_addbz);//������־
				//���
				if($shoppr['cutnumtype']==1&&$haveprice==1&&!$logr['havecutnum'])
				{
					$ddaddr=$empire->fetch1("select buycar from {$dbtbpre}enewsshopdd_add where ddid='$logr[ddid]'");
					Shopsys_hCutMaxnum($logr['ddid'],$ddaddr['buycar'],$logr['havecutnum'],$shoppr,0);
				}
			}
		}
    }
	elseif($doing==4)	//ɾ������
	{
		$log_ecms='DelDd';
		$log_bz='';
		$log_addbz='';
		//���
		if($ids)
		{
			$logsql=$empire->query("select ddid,havecutnum,checked,haveprice from {$dbtbpre}enewsshopdd where ".$add." and havecutnum=1");
			while($logr=$empire->fetch($logsql))
			{
				if($logr['haveprice']==1)
				{
					continue;
				}
				if($logr['havecutnum'])
				{
					$ddaddr=$empire->fetch1("select buycar from {$dbtbpre}enewsshopdd_add where ddid='$logr[ddid]'");
					Shopsys_hCutMaxnum($logr['ddid'],$ddaddr['buycar'],$logr['havecutnum'],$shoppr,1);
				}
			}
		}
		$sql=$empire->query("delete from {$dbtbpre}enewsshopdd where ".$add);
		$sql2=$empire->query("delete from {$dbtbpre}enewsshopdd_add where ".$add);
		$sql3=$empire->query("delete from {$dbtbpre}enewsshop_ddlog where ".$add);
		$mess="DelDdSuccess";
		$log="doing=$doing&do=DelDd<br>ddid=$ids";
    }
	else
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	if($sql)
	{
		//������־
		insert_dolog($log);
		printerror($mess,EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=="SetShopDd")
{
	SetShopDd($_POST,$logininid,$loginin);
}
else
{}

//���¿��
$shoppr=ShopSys_hReturnSet();
ShopSys_hTimeCutMaxnum(0,$shoppr);

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//ÿҳ��ʾ����
$page_line=18;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$totalquery="select count(*) as total from {$dbtbpre}enewsshopdd";
$query="select ddid,ddno,ddtime,userid,username,outproduct,haveprice,checked,truename,psid,psname,pstotal,alltotal,payfsid,payfsname,payby,alltotalfen,fp,fptotal,pretotal from {$dbtbpre}enewsshopdd";
$add='';
$and=' where ';
//����
$sear=RepPostStr($_GET['sear'],1);
if($sear)
{
	$keyboard=$_GET['keyboard'];
	$keyboard=RepPostVar2($keyboard);
	if($keyboard)
	{
		$show=(int)$_GET['show'];
		if($show==1)//����������
		{
			$add=$and."ddno like '%$keyboard%'";
		}
		elseif($show==2)//�û���
		{
			$add=$and."username like '%$keyboard%'";
		}
		elseif($show==3)//����
		{
			$add=$and."truename like '%$keyboard%'";
		}
		elseif($show==4)//����
		{
			$add=$and."email like '%$keyboard%'";
		}
		else//��ַ
		{
			$add=$and."address like '%$keyboard%'";
		}
		$and=' and ';
	}
	//����״̬
	$checked=(int)$_GET['checked'];
	if($checked==1)//��ȷ��
	{
		$add.=$and."checked=1";
		$and=' and ';
	}
	elseif($checked==9)//δȷ��
	{
		$add.=$and."checked=0";
		$and=' and ';
	}
	elseif($checked==2)//ȡ��
	{
		$add.=$and."checked=2";
		$and=' and ';
	}
	elseif($checked==3)//�˻�
	{
		$add.=$and."checked=3";
		$and=' and ';
	}
	//�Ƿ񸶿�
	$haveprice=(int)$_GET['haveprice'];
	if($haveprice==1)//�Ѹ���
	{
		$add.=$and."haveprice=1";
		$and=' and ';
	}
	elseif($haveprice==9)//δ����
	{
		$add.=$and."haveprice=0";
		$and=' and ';
	}
	//�Ƿ񷢻�
	$outproduct=(int)$_GET['outproduct'];
	if($outproduct==1)//�ѷ���
	{
		$add.=$and."outproduct=1";
		$and=' and ';
	}
	elseif($outproduct==9)//δ����
	{
		$add.=$and."outproduct=0";
		$and=' and ';
	}
	elseif($outproduct==2)//������
	{
		$add.=$and."outproduct=2";
		$and=' and ';
	}
	//ʱ��
	$starttime=RepPostVar($_GET['starttime']);
	$endtime=RepPostVar($_GET['endtime']);
	if($endtime!="")
	{
		$ostarttime=$starttime." 00:00:00";
		$oendtime=$endtime." 23:59:59";
		$add.=$and."ddtime>='$ostarttime' and ddtime<='$oendtime'";
		$and=' and ';
	}
	$search.="&sear=1&keyboard=$keyboard&show=$show&checked=$checked&outproduct=$outproduct&haveprice=$haveprice&starttime=$starttime&endtime=$endtime";
}
//����
$myorder=(int)$_GET['myorder'];
if($myorder==2)//��Ʒ���
{
	$orderby='alltotal desc';
}
elseif($myorder==3)
{
	$orderby='alltotal asc';
}
elseif($myorder==4)//��Ʒ����
{
	$orderby='alltotalfen desc';
}
elseif($myorder==5)
{
	$orderby='alltotalfen asc';
}
elseif($myorder==6)//�Żݽ��
{
	$orderby='pretotal desc';
}
elseif($myorder==7)
{
	$orderby='pretotal asc';
}
elseif($myorder==1)//����ʱ��
{
	$orderby='ddid asc';
}
else
{
	$orderby='ddid desc';
}
$totalquery.=$add;
$query.=$add;
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by ".$orderby." limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>������</title>
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<a href="ListDd.php<?=$ecms_hashur['whehref']?>">������</a></td>
  </tr>
</table>

  
<form name="form1" method="get" action="ListDd.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td>����: <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>"> 
        <select name="show" id="show">
          <option value="1"<?=$show==1?' selected':''?>>������</option>
          <option value="2"<?=$show==2?' selected':''?>>�û���</option>
		  <option value="3"<?=$show==3?' selected':''?>>�ջ�������</option>
		  <option value="4"<?=$show==4?' selected':''?>>�ջ�������</option>
		  <option value="5"<?=$show==5?' selected':''?>>�ջ��˵�ַ</option>
        </select> 
        <select name="checked" id="checked">
          <option value="0"<?=$checked==0?' selected':''?>>���޶���״̬</option>
          <option value="1"<?=$checked==1?' selected':''?>>��ȷ��</option>
          <option value="9"<?=$checked==9?' selected':''?>>δȷ��</option>
		  <option value="2"<?=$checked==2?' selected':''?>>ȡ��</option>
		  <option value="3"<?=$checked==3?' selected':''?>>�˻�</option>
        </select> 
        <select name="outproduct" id="outproduct">
          <option value="0"<?=$outproduct==0?' selected':''?>>���޷���״̬</option>
          <option value="1"<?=$outproduct==1?' selected':''?>>�ѷ���</option>
          <option value="9"<?=$outproduct==9?' selected':''?>>δ����</option>
		  <option value="2"<?=$outproduct==2?' selected':''?>>������</option>
        </select>
        <select name="haveprice" id="haveprice">
          <option value="0"<?=$haveprice==0?' selected':''?>>���޸���״̬</option>
          <option value="1"<?=$haveprice==1?' selected':''?>>�Ѹ���</option>
          <option value="9"<?=$haveprice==9?' selected':''?>>δ����</option>
        </select>
        <select name="myorder" id="myorder">
          <option value="0"<?=$myorder==0?' selected':''?>>����ʱ�併��</option>
          <option value="1"<?=$myorder==1?' selected':''?>>����ʱ������</option>
          <option value="2"<?=$myorder==2?' selected':''?>>��Ʒ����</option>
          <option value="3"<?=$myorder==3?' selected':''?>>��Ʒ�������</option>
          <option value="4"<?=$myorder==4?' selected':''?>>��Ʒ��������</option>
          <option value="5"<?=$myorder==5?' selected':''?>>��Ʒ��������</option>
          <option value="6"<?=$myorder==6?' selected':''?>>�Żݽ������</option>
          <option value="7"<?=$myorder==7?' selected':''?>>�Żݽ���</option>
        </select></td>
    </tr>
    <tr>
      <td>ʱ��:�� 
        <input name="starttime" type="text" id="starttime2" value="<?=$starttime?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        �� 
        <input name="endtime" type="text" id="endtime2" value="<?=$endtime?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        ֹ�Ķ��� 
        <input type="submit" name="Submit6" value="����"> <input name="sear" type="hidden" id="sear2" value="1"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class=tableborder>
  <form name="listdd" method="post" action="ListDd.php" onsubmit="return confirm('ȷ��Ҫ����?');">
  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=SetShopDd>
    <input type=hidden name=doing value=0>
    <tr class=header> 
      <td width="5%" height="23"> <div align="center">ѡ��</div></td>
      <td width="19%"><div align="center">���(����鿴)</div></td>
      <td width="21%"><div align="center">����ʱ��</div></td>
      <td width="13%"><div align="center">������</div></td>
      <td width="11%"><div align="center">�ܽ��</div></td>
      <td width="12%"><div align="center">֧����ʽ</div></td>
      <td width="19%"><div align="center">״̬</div></td>
    </tr>
    <?
	while($r=$empire->fetch($sql))
	{
		if(empty($r[userid]))//�ǻ�Ա
		{
			$username="<font color=cccccc>".$r[truename]."</font>";
		}
		else
		{
			$username="<a href='../member/AddMember.php?enews=EditMember&userid=".$r[userid].$ecms_hashur['ehref']."' target=_blank>".$r[username]."</a>";
		}
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
		//����״̬
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
		//����״̬
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
		//����״̬
		if($r['haveprice']==1)
		{
			$ha="�Ѹ���";
		}
		else
		{
			$ha="<font color=red>δ����</font>";
		}
	?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25"> <div align="center"> 
          <input name="ddid[]" type="checkbox" id="ddid[]" value="<?=$r[ddid]?>">
        </div></td>
      <td> <div align="center"><a href="#ecms" onclick="window.open('ShowDd.php?ddid=<?=$r[ddid]?><?=$ecms_hashur['ehref']?>','','width=700,height=600,scrollbars=yes,resizable=yes');">
          <?=$r[ddno]?>
          </a></div></td>
      <td> <div align="center">
          <?=$r[ddtime]?>
        </div></td>
      <td> <div align="center">
          <?=$username?>
        </div></td>
      <td> <div align="center">
          <?=$mytotal?>
        </div></td>
      <td><div align="center">
          <?=$payfsname?>
        </div></td>
      <td> <div align="center"><strong><?=$ha?></strong>/<strong><?=$ou?></strong>/<strong><?=$ch?></strong></div></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td> <div align="center"> 
          <input type=checkbox name=chkall value=on onClick='CheckAll(this.form)'>
        </div></td>
      <td colspan="6"><select name="checked" id="checked">
        <option value="1">ȷ��</option>
        <option value="2">ȡ��</option>
        <option value="3">�˻�</option>
        <option value="0">δȷ��</option>
      </select>
      <input type="submit" name="Submit" value="���ö���״̬" onClick="document.listdd.doing.value='1';document.listdd.enews.value='SetShopDd';document.listdd.action='ListDd.php';"> 
        &nbsp;
        <select name="outproduct" id="outproduct">
          <option value="1">�ѷ���</option>
          <option value="2">������</option>
          <option value="0">δ����</option>
        </select> 
        <input type="submit" name="Submit2" value="���÷���״̬" onClick="document.listdd.doing.value='2';document.listdd.enews.value='SetShopDd';document.listdd.action='ListDd.php';"> 
        &nbsp;
        <select name="haveprice" id="haveprice">
          <option value="1">�Ѹ���</option>
          <option value="0">δ����</option>
        </select> 
        <input type="submit" name="Submit3" value="���ø���״̬" onClick="document.listdd.doing.value='3';document.listdd.enews.value='SetShopDd';document.listdd.action='ListDd.php';">
&nbsp;
<select name="cutmaxnum" id="cutmaxnum">
  <option value="1">��ԭ���</option>
  <option value="0">���ٿ��</option>
</select>
<input type="submit" name="Submit32" value="���ÿ��" onClick="document.listdd.doing.value='5';document.listdd.enews.value='DoCutMaxnum';document.listdd.action='ecmsshop.php';">
        &nbsp; 
		<input type="submit" name="Submit5" value="ɾ������" onClick="document.listdd.doing.value='4';document.listdd.enews.value='SetShopDd';document.listdd.action='ListDd.php';"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td> <div align="center"></div></td>
      <td colspan="6"> <div align="left">&nbsp;
          <?=$returnpage?>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td colspan="6"><font color="#666666">������Ϊ��ɫ,��Ϊ�ǻ�Ա�����˻����Զ���ԭ��棬���ֶ���ԭ��棻�ѻ�ԭ���Ŀ��ϵͳ�����ظ���ԭ��</font></td>
    </tr>
  </form>
</table>

</body>
</html>
<?
db_close();
$empire=null;
?>
