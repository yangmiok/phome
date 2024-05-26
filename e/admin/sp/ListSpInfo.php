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

//��֤Ȩ��
function CheckSpInfoLevel($spid){
	global $empire,$dbtbpre,$lur;
	$spr=$empire->fetch1("select spid,spname,varname,sptype,maxnum,groupid,userclass,username from {$dbtbpre}enewssp where spid='$spid'");
	if(!$spr['spid'])
	{
		printerror('ErrorUrl','');
	}
	//��֤����Ȩ��
	CheckDoLevel($lur,$spr[groupid],$spr[userclass],$spr[username]);
	return $spr;
}

//������Ƭ��Ϣ
function AddSpInfo($add,$userid,$username){
	global $empire,$dbtbpre;
	$spid=(int)$add[spid];
	if(!$spid)
	{
		printerror('ErrorUrl','');
	}
	//��֤
	$spr=CheckSpInfoLevel($spid);
	if($spr[sptype]==1)//��̬��Ƭ
	{
		$log=AddSpInfo1($spid,$spr,$add);
	}
	elseif($spr[sptype]==2)//��̬��Ƭ
	{
		$log=AddSpInfo2($spid,$spr,$add);
	}
	else
	{
		printerror('ErrorUrl','');
	}
	//ɾ��������Ƭ��Ϣ
	DelMoreSpInfo($spid,$spr);
	//���¸���
	UpdateTheFileEditOther(7,$spid,'other');
	//������־
	insert_dolog($log);
	printerror("AddSpInfoSuccess","AddSpInfo.php?enews=AddSpInfo&spid=$spid".hReturnEcmsHashStrHref2(0));
}

//������Ƭ��Ϣ
function LoadInSpInfo($add,$userid,$username){
	global $empire,$dbtbpre,$class_r,$emod_r,$etable_r;
	$spid=(int)$add[spid];
	if(!$spid)
	{
		printerror('ErrorUrl','');
	}
	//��֤
	$spr=CheckSpInfoLevel($spid);
	$tbname=RepPostVar($add['tbname']);
	$infoids=$add['infoids'];
	if(!$tbname||!$infoids)
	{
		printerror('ErrorUrl','');
	}
	$tbr=$empire->fetch1("select tbname from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
	if(!$tbr['tbname'])
	{
		printerror('ErrorUrl','');
	}
	//����ֶ�
	$mid=$etable_r[$tbname]['mid'];
	$smalltextf=$emod_r[$mid]['smalltextf'];
	$sf='';
	if($smalltextf&&$smalltextf<>',')
	{
		$smr=explode(',',$smalltextf);
		$sf=$smr[1];
	}
	$addf='';
	if($sf&&!strstr($emod_r[$mid]['tbdataf'],','.$sf.','))
	{
		$addf=','.$sf;
	}
	//����
	$infor=explode(',',$infoids);
	$count=count($infor);
	for($i=0;$i<$count;$i++)
	{
		$infoid=(int)$infor[$i];
		if(!$infoid)
		{
			continue;
		}
		$r=$empire->fetch1("select id,classid,isurl,titleurl,newstime,titlepic,title,stb".$addf." from {$dbtbpre}ecms_".$tbname." where id='$infoid' limit 1");
		if(!$r['id'])
		{
			continue;
		}
		if($sf&&!$addf)
		{
			$finfor=$empire->fetch1("select ".$sf." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$infoid' limit 1");
			$r['smalltext']=$finfor[$sf];
		}
		else
		{
			$r['smalltext']=$r[$sf];
		}
		$r['newstime']=date("Y-m-d H:i:s",$r['newstime']);
		if($spr[sptype]==1)//��̬��Ƭ
		{
			$log=AddSpInfo1($spid,$spr,$r);
		}
		elseif($spr[sptype]==2)//��̬��Ƭ
		{
			$log=AddSpInfo2($spid,$spr,$r,1);
		}
		else
		{
			printerror('ErrorUrl','');
		}
	}
	//ɾ��������Ƭ��Ϣ
	DelMoreSpInfo($spid,$spr);
	//������־
	insert_dolog("tbname=$tbname<br>id=$infoids");
	printerror("LoadInSpInfoSuccess","ListSpInfo.php?spid=$spid".hReturnEcmsHashStrHref2(0));
}

//���Ӿ�̬��Ƭ��Ϣ
function AddSpInfo1($spid,$spr,$add){
	global $empire,$dbtbpre;
	$add['title']=eDoRepPostComStr($add['title'],1);
	$add['titlepic']=eDoRepPostComStr($add['titlepic'],1);
	$add['titleurl']=eDoRepPostComStr($add['titleurl'],1);
	$titlefont=TitleFont($add[titlefont],$add[titlecolor]);
	$newstime=$add[newstime]?to_time($add[newstime]):time();
	$sql=$empire->query("insert into {$dbtbpre}enewssp_1(spid,title,titlepic,bigpic,titleurl,smalltext,titlefont,newstime,titlepre,titlenext) values('$spid','".eaddslashes2($add[title])."','".eaddslashes2($add[titlepic])."','".eaddslashes2($add[bigpic])."','".eaddslashes2($add[titleurl])."','".eaddslashes2($add[smalltext])."','".eaddslashes2($titlefont)."','$newstime','".eaddslashes2($add[titlepre])."','".eaddslashes2($add[titlenext])."');");
	$sid=$empire->lastid();
	$log="spid=$spid&sid=$sid&title=$add[title]";
	return $log;
}

//���Ӷ�̬��Ƭ��Ϣ
function AddSpInfo2($spid,$spr,$add,$ecms=0){
	global $empire,$dbtbpre,$class_r;
	$add[classid]=(int)$add[classid];
	$add[id]=(int)$add[id];
	if(empty($class_r[$add[classid]][tbname]))
	{
		if($ecms==1)
		{
			return '';
		}
		else
		{
			printerror('HaveNotInfo','');
		}
	}
	$infor=$empire->fetch1("select id,classid,newstime from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index where id='$add[id]'");
	if(!$infor[id]||$infor[classid]!=$add[classid])
	{
		if($ecms==1)
		{
			return '';
		}
		else
		{
			printerror('HaveNotInfo','');
		}
	}
	$newstime=$add[newstime]?to_time($add[newstime]):$infor[newstime];
	//�Ƿ��ظ�
	$rer=$empire->fetch1("select sid from {$dbtbpre}enewssp_2 where spid='$spid' and id='$add[id]' and classid='$add[classid]' limit 1");
	if($rer['sid'])
	{
		if($ecms==1)
		{
			return '';
		}
		else
		{
			printerror('HaveSpInfo','');
		}
	}
	$sql=$empire->query("insert into {$dbtbpre}enewssp_2(spid,classid,id,newstime) values('$spid','$add[classid]','$add[id]','$newstime');");
	$sid=$empire->lastid();
	$log="spid=$spid&sid=$sid&classid=$add[classid]&id=$add[id]";
	return $log;
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

//�޸���Ƭ��Ϣ
function EditSpInfo($add,$userid,$username){
	global $empire,$dbtbpre;
	$spid=(int)$add[spid];
	$sid=(int)$add['sid'];
	if(!$spid)
	{
		printerror('ErrorUrl','');
	}
	//��֤
	$spr=CheckSpInfoLevel($spid);
	if($spr[sptype]==1)//��̬��Ƭ
	{
		$log=EditSpInfo1($spid,$spr,$sid,$add);
	}
	elseif($spr[sptype]==2)//��̬��Ƭ
	{
		$log=EditSpInfo2($spid,$spr,$sid,$add);
	}
	elseif($spr[sptype]==3)//������Ƭ
	{
		$log=EditSpInfo3($spid,$spr,$sid,$add);
	}
	else
	{
		printerror('ErrorUrl','');
	}
	//ɾ��������Ƭ��Ϣ
	DelMoreSpInfo($spid,$spr);
	//���¸���
	UpdateTheFileEditOther(7,$spid,'other');
	//������־
	insert_dolog($log);
	printerror("EditSpInfoSuccess","ListSpInfo.php?spid=$spid".hReturnEcmsHashStrHref2(0));
}

//�޸ľ�̬��Ƭ��Ϣ
function EditSpInfo1($spid,$spr,$sid,$add){
	global $empire,$dbtbpre;
	if(!$sid)
	{
		printerror('ErrorUrl','');
	}
	$checknum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssp_1 where sid='$sid' and spid='$spid'");
	if(!$checknum)
	{
		printerror('ErrorUrl','');
	}
	$add['title']=eDoRepPostComStr($add['title'],1);
	$add['titlepic']=eDoRepPostComStr($add['titlepic'],1);
	$add['titleurl']=eDoRepPostComStr($add['titleurl'],1);
	$titlefont=TitleFont($add[titlefont],$add[titlecolor]);
	$newstime=$add[newstime]?to_time($add[newstime]):time();
	$empire->query("update {$dbtbpre}enewssp_1 set title='".eaddslashes2($add[title])."',titlepic='".eaddslashes2($add[titlepic])."',bigpic='".eaddslashes2($add[bigpic])."',titleurl='".eaddslashes2($add[titleurl])."',smalltext='".eaddslashes2($add[smalltext])."',titlefont='".eaddslashes2($titlefont)."',newstime='$newstime',titlepre='".eaddslashes2($add[titlepre])."',titlenext='".eaddslashes2($add[titlenext])."' where sid='$sid' and spid='$spid'");
	$log="spid=$spid&sid=$sid&title=$add[title]";
	return $log;
}

//�޸Ķ�̬��Ƭ��Ϣ
function EditSpInfo2($spid,$spr,$sid,$add){
	global $empire,$dbtbpre,$class_r;
	if(!$sid)
	{
		printerror('ErrorUrl','');
	}
	$checknum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssp_2 where sid='$sid' and spid='$spid'");
	if(!$checknum)
	{
		printerror('ErrorUrl','');
	}
	$add[classid]=(int)$add[classid];
	$add[id]=(int)$add[id];
	if(empty($class_r[$add[classid]][tbname]))
	{
		printerror('HaveNotInfo','');
	}
	$infor=$empire->fetch1("select id,classid,newstime from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index where id='$add[id]'");
	if(!$infor[id]||$infor[classid]!=$add[classid])
	{
		printerror('HaveNotInfo','');
	}
	$newstime=$add[newstime]?to_time($add[newstime]):$infor[newstime];
	//�Ƿ��ظ�
	$rer=$empire->fetch1("select sid from {$dbtbpre}enewssp_2 where spid='$spid' and id='$add[id]' and classid='$add[classid]' and sid<>$sid limit 1");
	if($rer['sid'])
	{
		printerror('HaveSpInfo','');
	}
	$empire->query("update {$dbtbpre}enewssp_2 set classid='$add[classid]',id='$add[id]',newstime='$newstime' where sid='$sid' and spid='$spid'");
	$log="spid=$spid&sid=$sid&classid=$add[classid]&id=$add[id]";
	return $log;
}

//�޸Ĵ�����Ƭ��Ϣ
function EditSpInfo3($spid,$spr,$sid,$add){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select sid from {$dbtbpre}enewssp_3 where spid='$spid'");
	if($r['sid'])
	{
		$empire->query("update {$dbtbpre}enewssp_3 set sptext='".eaddslashes2($add[sptext])."' where spid='$spid'");
		$sid=$r['sid'];
	}
	else
	{
		$empire->query("insert into {$dbtbpre}enewssp_3(spid,sptext) values('$spid','".eaddslashes2($add[sptext])."');");
		$sid=$empire->lastid();
	}
	//����
	EditSpInfo3_bak($spid,$sid,$add[sptext]);
	$log="spid=$spid&sid=$sid&sptype=3";
	return $log;
}

//���ݴ�����Ƭ��Ϣ
function EditSpInfo3_bak($spid,$sid,$sptext){
	global $empire,$dbtbpre,$lur;
	$baknum=10;	//�����������
	$username=$lur[username];
	$time=time();
	$empire->query("insert into {$dbtbpre}enewssp_3_bak(sid,spid,sptext,lastuser,lasttime) values('$sid','$spid','".eaddslashes2($sptext)."','$username','$time');");
	//ɾ�����౸��
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssp_3_bak where sid='$sid'");
	if($num>$baknum)
	{
		$limitnum=$num-$baknum;
		$ids='';
		$dh='';
		$sql=$empire->query("select bid from {$dbtbpre}enewssp_3_bak where sid='$sid' order by bid limit ".$limitnum);
		while($r=$empire->fetch($sql))
		{
			$ids.=$dh.$r[bid];
			$dh=',';
		}
		$empire->query("delete from {$dbtbpre}enewssp_3_bak where bid in ($ids)");
	}
}

//��ԭ��Ƭ��Ϣ��¼
function SpInfoReBak($add,$userid,$username){
	global $empire,$dbtbpre;
	$spid=(int)$add[spid];
	$sid=(int)$add['sid'];
	$bid=(int)$add[bid];
	if(!$spid||!$sid||!$bid)
	{
		printerror('ErrorUrl','');
	}
	//��֤
	$spr=CheckSpInfoLevel($spid);
	if($spr['sptype']!=3)
	{
		printerror('ErrorUrl','');
	}
	$br=$empire->fetch1("select bid,sptext from {$dbtbpre}enewssp_3_bak where bid='$bid' and sid='$sid' and spid='$spid'");
	if(!$br['bid'])
	{
		printerror('ErrorUrl','');
	}
	$sql=$empire->query("update {$dbtbpre}enewssp_3 set sptext='".StripAddsData($br[sptext])."' where sid='$sid'");
	if($sql)
	{
		//������־
		insert_dolog("spid=".$spid."&spname=".$spr[spname]."<br>sid=$sid&bid=$bid");
		echo"<script>opener.ReSpInfoBak();window.close();</script>";
		exit();
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ����Ƭ��Ϣ
function DelSpInfo($add,$userid,$username){
	global $empire,$dbtbpre;
	$spid=(int)$add[spid];
	$sid=(int)$add['sid'];
	if(!$spid||!$sid)
	{
		printerror('ErrorUrl','');
	}
	//��֤
	$spr=CheckSpInfoLevel($spid);
	if($spr[sptype]==1)//��̬��Ƭ
	{
		$r=$empire->fetch1("select sid,title from {$dbtbpre}enewssp_1 where sid='$sid' and spid='$spid'");
		if(!$r['sid'])
		{
			printerror('ErrorUrl','');
		}
		$empire->query("delete from {$dbtbpre}enewssp_1 where sid='$sid' and spid='$spid'");
		$log="spid=$spid&sid=$sid&title=$r[title]";
	}
	elseif($spr[sptype]==2)//��̬��Ƭ
	{
		$r=$empire->fetch1("select sid,classid,id from {$dbtbpre}enewssp_2 where sid='$sid' and spid='$spid'");
		if(!$r['sid'])
		{
			printerror('ErrorUrl','');
		}
		$empire->query("delete from {$dbtbpre}enewssp_2 where sid='$sid' and spid='$spid'");
		$log="spid=$spid&sid=$sid&classid=$r[classid]&id=$r[id]";
	}
	else
	{
		printerror('ErrorUrl','');
	}
	//������־
	insert_dolog($log);
	printerror("DelSpInfoSuccess","ListSpInfo.php?spid=$spid".hReturnEcmsHashStrHref2(0));
}

//�����޸���Ƭ����ʱ��
function EditSpInfoTime($add,$userid,$username){
	global $empire,$dbtbpre;
	$spid=(int)$add[spid];
	$sid=$add['sid'];
	$newstime=$add[newstime];
	if(!$spid)
	{
		printerror('ErrorUrl','');
	}
	$count=count($sid);
	if(!$count)
	{
		printerror('EmptySpInfoTime','');
	}
	//��֤
	$spr=CheckSpInfoLevel($spid);
	if($spr[sptype]==1)//��̬��Ƭ
	{
		for($i=0;$i<$count;$i++)
		{
			$dosid=(int)$sid[$i];
			$donewstime=$newstime[$i]?to_time($newstime[$i]):time();
			$empire->query("update {$dbtbpre}enewssp_1 set newstime='$donewstime' where sid='$dosid' and spid='$spid'");
		}
	}
	elseif($spr[sptype]==2)//��̬��Ƭ
	{
		for($i=0;$i<$count;$i++)
		{
			$dosid=(int)$sid[$i];
			$donewstime=$newstime[$i]?to_time($newstime[$i]):time();
			$empire->query("update {$dbtbpre}enewssp_2 set newstime='$donewstime' where sid='$dosid' and spid='$spid'");
		}
	}
	else
	{
		printerror('ErrorUrl','');
	}
	//������־
	insert_dolog("spid=$spid");
	printerror("EditSpInfoTimeSuccess","ListSpInfo.php?spid=$spid".hReturnEcmsHashStrHref2(0));
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=="AddSpInfo")//������Ƭ��Ϣ
{
	AddSpInfo($_POST,$logininid,$loginin);
}
elseif($enews=="EditSpInfo")//�޸���Ƭ��Ϣ
{
	EditSpInfo($_POST,$logininid,$loginin);
}
elseif($enews=="DelSpInfo")//ɾ����Ƭ��Ϣ
{
	DelSpInfo($_GET,$logininid,$loginin);
}
elseif($enews=="SpInfoReBak")//��ԭ��Ƭ��Ϣ��¼
{
	SpInfoReBak($_GET,$logininid,$loginin);
}
elseif($enews=="EditSpInfoTime")//�����޸���Ƭ��Ϣʱ��
{
	EditSpInfoTime($_POST,$logininid,$loginin);
}
elseif($enews=="LoadInSpInfo")//����������Ƭ��Ϣ
{
	LoadInSpInfo($_GET,$logininid,$loginin);
}

$spid=(int)$_GET['spid'];
//��Ƭ
$spr=CheckSpInfoLevel($spid);
//������Ƭ
if($spr[sptype]==3)
{
	Header("Location:AddSpInfo.php?enews=EditSpInfo&spid=$spid".$ecms_hashur['ehref']);
	exit();
}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=50;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$search="&spid=$spid".$ecms_hashur['ehref'];
$url="<a href=UpdateSp.php".$ecms_hashur['whehref'].">������Ƭ</a>&nbsp;>&nbsp;".$spr[spname]."&nbsp;>&nbsp;������Ƭ��Ϣ";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ƭ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ChangeInfoDoAction(tbname,infoids){
	if(tbname==''||infoids=='')
	{
		return false;
	}
	else
	{
		self.location.href='../sp/ListSpInfo.php?<?=$ecms_hashur['href']?>&enews=LoadInSpInfo&spid=<?=$spid?>&tbname='+tbname+'&infoids='+infoids;
	}
}
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td width="50%">λ��: 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="������Ƭ��Ϣ" onclick="self.location.href='AddSpInfo.php?enews=AddSpInfo&spid=<?=$spid?><?=$ecms_hashur['ehref']?>';">
		&nbsp;&nbsp;
		<input type="button" name="Submit5" value="����������Ƭ��Ϣ" onclick="window.open('../info/ChangeInfo.php?enews=LoadInSpInfo&spid=<?=$spid?><?=$ecms_hashur['ehref']?>');">
      </div></td>
  </tr>
</table>
<br>
<?php
if($spr[sptype]==1)
{
	$query="select spid,sid,title,titlepic,titleurl,titlefont,newstime from {$dbtbpre}enewssp_1 where spid='$spid'";
	$totalquery="select count(*) as total from {$dbtbpre}enewssp_1 where spid='$spid'";
	$num=$empire->gettotal($totalquery);//ȡ��������
	$query=$query." order by newstime desc limit $offset,$line";
	$sql=$empire->query($query);
	$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
	<form action="ListSpInfo.php" method="post" name="spform" id="spform" onsubmit="return confirm('ȷ��Ҫ�޸�?');">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
    <td width="51%" height="25"><div align="center">����</div></td>
    <td width="30%"><div align="center">����ʱ��</div></td>
    <td width="19%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
		//����ͼƬ
		$showtitlepic="";
		if($r[titlepic])
		{
			$showtitlepic="<a href='".$r[titlepic]."' title='Ԥ������ͼƬ' target=_blank><img src='../../data/images/showimg.gif' border=0></a>";
		}
		//����
		$r[title]=DoTitleFont($r[titlefont],stripSlashes($r[title]));
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="32"> 
      <?=$showtitlepic?>
	  <a href='<?=$r[titleurl]?>' target=_blank><?=stripSlashes($r[title])?></a>
    </td>
    <td><div align="center">
          <input name="sid[]" type="hidden" id="sid[]" value="<?=$r['sid']?>">
          <input name="newstime[]" type="text" value="<?=date('Y-m-d H:i:s',$r[newstime])?>" size="22">
        </div></td>
    <td height="25"><div align="center">[<a href="AddSpInfo.php?enews=EditSpInfo&spid=<?=$spid?>&sid=<?=$r['sid']?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
        [<a href="ListSpInfo.php?enews=DelSpInfo&spid=<?=$spid?>&sid=<?=$r['sid']?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="3">&nbsp; 
      <?=$returnpage?>&nbsp;&nbsp;&nbsp;
	  <input type="hidden" name="enews" value="EditSpInfoTime">
        <input name="spid" type="hidden" id="spid" value="<?=$spid?>">
        <input type="submit" name="Submit" value="�����޸�ʱ��">
        <input type="reset" name="Submit2" value="����"></td>
  </tr>
  </form>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25"><font color="#666666">˵������Ϣ�ǰ�����ʱ���������Ҫ��˳������޸ķ���ʱ�䣬����ʱ�����ÿ����Ϊ��ǰʱ�䡣</font></td>
  </tr>
</table>
<?php
}
elseif($spr[sptype]==2)
{
	$query="select spid,sid,classid,id,newstime from {$dbtbpre}enewssp_2 where spid='$spid'";
	$totalquery="select count(*) as total from {$dbtbpre}enewssp_2 where spid='$spid'";
	$num=$empire->gettotal($totalquery);//ȡ��������
	$query=$query." order by newstime desc limit $offset,$line";
	$sql=$empire->query($query);
	$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
	<form action="ListSpInfo.php" method="post" name="spform" id="spform" onsubmit="return confirm('ȷ��Ҫ�޸�?');">
	<?=$ecms_hashur['form']?>
  <tr class="header"> 
    <td width="46%" height="25"><div align="center">����</div></td>
    <td width="23%"><div align="center">����ʱ��</div></td>
    <td width="17%"><div align="center">������Ŀ</div></td>
    <td width="14%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  		if(empty($class_r[$r[classid]][tbname]))
		{
			continue;
		}
		//������
		$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]."_index where id='$r[id]' limit 1");
		//���ر�
		$infotb=ReturnInfoMainTbname($class_r[$r[classid]][tbname],$index_r['checked']);
  		$infor=$empire->fetch1("select id,classid,isurl,titleurl,isgood,firsttitle,plnum,totaldown,onclick,newstime,titlepic,title from ".$infotb." where id='$r[id]' limit 1");
		//����ͼƬ
		$showtitlepic="";
		if($infor[titlepic])
		{
			$showtitlepic="<a href='".$infor[titlepic]."' title='Ԥ������ͼƬ' target=_blank><img src='../../data/images/showimg.gif' border=0></a>";
		}
		//����
		$infor[title]=DoTitleFont($infor[titlefont],stripSlashes($infor[title]));
		//��������
		$titleurl=sys_ReturnBqTitleLink($infor);
		//��Ŀ����
		$classurl=sys_ReturnBqClassname($r,9);
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="32"> 
      <?=$showtitlepic?>
      <a href='<?=$titleurl?>' target=_blank><?=stripSlashes($infor[title])?></a> </td>
    <td><div align="center">
          <input name="sid[]" type="hidden" id="sid[]" value="<?=$r['sid']?>">
          <input name="newstime[]" type="text" value="<?=date('Y-m-d H:i:s',$r[newstime])?>" size="22"> 
      </div></td>
    <td><div align="center"><a href="<?=$classurl?>" target="_blank"><?=$class_r[$r[classid]][classname]?></a></div></td>
    <td height="25"><div align="center">[<a href="AddSpInfo.php?enews=EditSpInfo&spid=<?=$spid?>&sid=<?=$r['sid']?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
        [<a href="ListSpInfo.php?enews=DelSpInfo&spid=<?=$spid?>&sid=<?=$r['sid']?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="4">&nbsp; 
      <?=$returnpage?>&nbsp;&nbsp;&nbsp;
	  <input type="hidden" name="enews" value="EditSpInfoTime">
        <input name="spid" type="hidden" id="spid" value="<?=$spid?>">
        <input type="submit" name="Submit" value="�����޸�ʱ��">
        <input type="reset" name="Submit2" value="����">
    </td>
  </tr>
  </form>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="25"><font color="#666666">˵������Ϣ�ǰ�����ʱ���������Ҫ��˳������޸ķ���ʱ�䣬����ʱ�����ÿ����Ϊ��ǰʱ�䡣</font></td>
  </tr>
</table>
<?php
}
?>
</body>
</html>
<?
db_close();
$empire=null;
?>
