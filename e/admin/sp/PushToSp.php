<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
require("../../data/dbcache/class.php");
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

//������Ϣ
function PushInfoToSp($add,$userid,$username){
	global $empire,$dbtbpre,$lur,$class_r;
	$classid=(int)$add['classid'];
	$tid=(int)$add['tid'];
	$spid=$add['spid'];
	$spcount=count($spid);
	$id=explode(',',$add[ids]);
	$count=count($id);
	if(!$count)
	{
		printerror('NotChangeSpInfo','');
	}
	if(!$spcount)
	{
		printerror('NotChangeSp','');
	}
	//����
	$tbname='';
	if($classid)
	{
		$tbname=$class_r[$classid]['tbname'];
	}
	elseif($tid)
	{
		$tbr=$empire->fetch1("select tbname from {$dbtbpre}enewstable where tid='$tid'");
		$tbname=$tbr['tbname'];
	}
	if(!$tbname)
	{
		printerror('ErrorUrl','');
	}
	//��Ƭ
	$sps='';
	$dh='';
	for($spi=0;$spi<$spcount;$spi++)
	{
		$myspid=intval($spid[$spi]);
		if(!$myspid)
		{
			continue;
		}
		$spr=$empire->fetch1("select spid,sptype,maxnum,groupid,userclass,username,isclose,cladd from {$dbtbpre}enewssp where spid='$myspid'");
		if(empty($spr[spid]))
		{
			continue;
		}
		if($spr[isclose])
		{
			continue;
		}
		if($spr[sptype]!=2)
		{
			continue;
		}
		if($spr[cladd]&&!CheckDoLevel($lur,$spr[groupid],$spr[userclass],$spr[username],1))
		{
			continue;
		}
		for($i=0;$i<$count;$i++)
		{
			$myid=intval($id[$i]);
			$infor=$empire->fetch1("select classid,newstime from {$dbtbpre}ecms_".$tbname."_index where id='$myid'");
			$rer=$empire->fetch1("select sid from {$dbtbpre}enewssp_2 where spid='$myspid' and id='$myid' and classid='$infor[classid]' limit 1");
			if($rer['sid'])
			{
				$empire->query("update {$dbtbpre}enewssp_2 set newstime='$infor[newstime]' where sid='".$rer['sid']."'");
			}
			else
			{
				$empire->query("insert into {$dbtbpre}enewssp_2(spid,classid,id,newstime) values('$myspid','$infor[classid]','$myid','$infor[newstime]');");
			}
		}
		$sps.=$dh.$myspid;
		$dh=',';
		//ɾ��������Ƭ��Ϣ
		DelMoreSpInfo($myspid,$spr);
	}
	//������־
	insert_dolog("classid=$classid&tid=$tid<br>spid=".$sps."<br>id=".$add[ids]);
	echo"<script>alert('���ͳɹ�');window.close();</script>";
	exit();
}

//ɾ��������Ƭ��Ϣ
function DelMoreSpInfo($spid,$spr){
	global $empire,$dbtbpre;
	if(!$spr[maxnum]||$spr[sptype]==3)
	{
		return '';
	}
	if($spr[sptype]==1)
	{
		$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssp_1 where spid='$spid'");
		if($num>$spr[maxnum])
		{
			$limitnum=$num-$spr[maxnum];
			$ids='';
			$dh='';
			$sql=$empire->query("select sid from {$dbtbpre}enewssp_1 where spid='$spid' order by sid limit ".$limitnum);
			while($r=$empire->fetch($sql))
			{
				$ids.=$dh.$r['sid'];
				$dh=',';
			}
			$empire->query("delete from {$dbtbpre}enewssp_1 where sid in ($ids)");
		}
	}
	elseif($spr[sptype]==2)
	{
		$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssp_2 where spid='$spid'");
		if($num>$spr[maxnum])
		{
			$limitnum=$num-$spr[maxnum];
			$ids='';
			$dh='';
			$sql=$empire->query("select sid from {$dbtbpre}enewssp_2 where spid='$spid' order by sid limit ".$limitnum);
			while($r=$empire->fetch($sql))
			{
				$ids.=$dh.$r['sid'];
				$dh=',';
			}
			$empire->query("delete from {$dbtbpre}enewssp_2 where sid in ($ids)");
		}
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=='PushInfoToSp')//������Ƭ
{
	PushInfoToSp($_POST,$logininid,$loginin);
}

//��˱�
$addecmscheck='';
$ecmscheck=(int)$_GET['ecmscheck'];
$indexchecked=1;
if($ecmscheck)
{
	$addecmscheck='&ecmscheck='.$ecmscheck;
	$indexchecked=0;
}

$add='';
//����
$cid=(int)$_GET['cid'];
if($cid)
{
	$add.=" and cid='$cid'";
}
//��Ŀ
$classid=(int)$_GET['classid'];
if($classid)
{
	$classwhere=ReturnClass($class_r[$classid][featherclass]);
	$add.=" and (classid=0 or classid='$classid' or (".$classwhere."))";
}
//��ID
$tid=(int)$_GET['tid'];
//ID
$ids=RepPostStr($_GET['id'],1);
if(!$ids)
{
	echo"<script>alert('��ѡ����Ϣ');window.close();</script>";
	exit();
}
$query="select spid,spname,varname,sppic,spsay from {$dbtbpre}enewssp where sptype=2 and isclose=0 and (cladd=0 or (cladd=1 and (groupid like '%,".$lur[groupid].",%' or userclass like '%,".$lur[classid].",%' or username like '%,".$lur[username].",%')))".$add." order by spid desc";
$sql=$empire->query($query);
//����
$scstr="";
$scsql=$empire->query("select classid,classname from {$dbtbpre}enewsspclass order by classid");
while($scr=$empire->fetch($scsql))
{
	$select="";
	if($scr[classid]==$cid)
	{
		$select=" selected";
	}
	$scstr.="<option value='".$scr[classid]."'".$select.">".$scr[classname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������Ϣ����Ƭ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td>λ��: ������Ϣ����Ƭ 
      <div align="right"> </div></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="searchform" method="GET" action="PushToSp.php<?=$ecms_hashur['whehref']?>">
  <tr> 
      <td> ѡ����ࣺ 
        <select name="select" id="select" onchange=window.location='PushToSp.php?<?=$ecms_hashur['ehref']?>&classid=<?=$classid?>&tid=<?=$tid?>&id=<?=$ids?>&cid='+this.options[this.selectedIndex].value>
          <option value="0">���з���</option>
          <?=$scstr?>
        </select></td>
  </tr>
</form>
</table>
<form name="form1" method="post" action="PushToSp.php">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
  <?=$ecms_hashur['form']?>
    <tr>
      <td>������ϢID��<?=$ids?></td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td width="26%"><div align="center">ѡ��</div></td>
      <td width="74%" height="25"> <div align="center">��Ƭ����</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
	if($r[sptype]==1)
	{
		$sptype='��̬��Ϣ';
	}
	elseif($r[sptype]==2)
	{
		$sptype='��̬��Ϣ';
	}
	else
	{
		$sptype='������Ƭ';
	}
	$sppic='';
	if($r[sppic])
	{
		$sppic='<a href="'.$r[sppic].'" title="��ƬЧ��ͼ" target="_blank"><img src="../../data/images/showimg.gif" border=0></a>';
	}
  ?>
    <tr bgcolor="#FFFFFF" id="chsp<?=$r[spid]?>"> 
      <td><div align="center"> 
          <input name="spid[]" type="checkbox" id="spid[]" value="<?=$r[spid]?>" onClick="if(this.checked){chsp<?=$r[spid]?>.style.backgroundColor='#DBEAF5';}else{chsp<?=$r[spid]?>.style.backgroundColor='#ffffff';}">
        </div></td>
      <td height="25"> 
        <?=$sppic?>
        <a title="<?=$r[spsay]?>"> 
        <?=$r[spname]?>
        </a> </td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center">
          <input type="submit" name="Submit2" value="ȷ������">
          &nbsp;&nbsp;<input type="button" name="Submit3" value="ȡ��" onclick="window.close();">
          <input name="enews" type="hidden" id="enews" value="PushInfoToSp">
          <input name="classid" type="hidden" id="classid" value="<?=$classid?>">
          <input name="tid" type="hidden" id="tid" value="<?=$tid?>">
          <input name="ids" type="hidden" id="ids" value="<?=$ids?>">
		  <input name="ecmscheck" type="hidden" id="ecmscheck" value="<?=$ecmscheck?>">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
