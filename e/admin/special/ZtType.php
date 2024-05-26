<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
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

$ztid=(int)$_GET['ztid'];
if(empty($ztid))
{
	$ztid=(int)$_POST['ztid'];
}
//��֤Ȩ��
//CheckLevel($logininid,$loginin,$classid,"zt");
$returnandlevel=CheckAndUsernamesLevel('dozt',$ztid,$logininid,$loginin,$loginlevel);

//�������
function DoPostZtTypeVar($add){
	if(empty($add['ttype']))
	{
		$add['ttype']='.html';
	}
	$add['cname']=eaddslashes(ehtmlspecialchars($add['cname']));
	$add['myorder']=(int)$add['myorder'];
	$add['islist']=(int)$add['islist'];
	$add['listtempid']=(int)$add['listtempid'];
	$add['maxnum']=(int)$add['maxnum'];
	$add['tnum']=(int)$add['tnum'];
	$add['reorder']=RepPostVar2($add['reorder']);
	$add['classtext']=RepPhpAspJspcode($add['classtext']);
	if($add['tfile'])
	{
		if(!eReturnCkCFile($add['tfile']))
		{
			$add['tfile']='';
		}
		$add['tfile']=RepFilenameQz($add['tfile'],0);
	}
	$add['ttype']=hRepPostStr($add['ttype'],1);
	$add['tfile']=hRepPostStr($add['tfile'],1);
	$add['tfile']=eaddslashes($add['tfile']);
	return $add;
}

//��������
function AddZtType($add,$userid,$username){
	global $empire,$dbtbpre;
	$add=DoPostZtTypeVar($add);
	$ztid=(int)$add['ztid'];
	if(!$ztid||!$add[cname])
	{
		printerror("EmptyZtType","history.go(-1)");
	}
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"zt");
	//��֤�ļ���
	if($add['tfile'])
	{
		if($add['tfile']=='index')
		{
			printerror("ZtTypeFileExist","history.go(-1)");
		}
		$filenum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewszttype where ztid='$ztid' and tfile='$add[tfile]' limit 1");
		if($filenum)
		{
			printerror("ZtTypeFileExist","history.go(-1)");
		}
	}
	$sql=$empire->query("insert into {$dbtbpre}enewszttype(ztid,cname,myorder,islist,listtempid,maxnum,tnum,reorder,ttype,tfile) values('$ztid','$add[cname]','$add[myorder]','$add[islist]','$add[listtempid]','$add[maxnum]','$add[tnum]','$add[reorder]','$add[ttype]','$add[tfile]');");
	$lastid=$empire->lastid();
	$empire->query("insert into {$dbtbpre}enewszttypeadd(cid,classtext) values('$lastid','".eaddslashes2($add[classtext])."');");
	//�ļ���
	if(empty($add['tfile']))
	{
		$tfile='type'.$lastid;
		$empire->query("update {$dbtbpre}enewszttype set tfile='$tfile' where cid='$lastid'");
	}
	//����ҳ��
	ListHtmlIndex($lastid,'',1);
	if($sql)
	{
		//������־
		insert_dolog("ztid=".$ztid."<br>cid=".$lastid."&cname=".$add[cname]);
		printerror("AddZtTypeSuccess","ZtType.php?ztid=$ztid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸�����
function EditZtType($add,$userid,$username){
	global $empire,$dbtbpre;
	$add=DoPostZtTypeVar($add);
	$ztid=(int)$add['ztid'];
	$cid=(int)$add['cid'];
	if(!$ztid||!$cid||!$add[cname])
	{
		printerror("EmptyZtType","history.go(-1)");
	}
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"zt");
	$r=$empire->fetch1("select * from {$dbtbpre}enewszttype where cid='$cid' and ztid='$ztid' limit 1");
	if(!$r['ztid'])
	{
		printerror('ErrorUrl','');
	}
	//��֤�ļ���
	if($add['tfile']&&$add['tfile']<>$r['tfile'])
	{
		if($add['tfile']=='index')
		{
			printerror("ZtTypeFileExist","history.go(-1)");
		}
		$filenum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewszttype where ztid='$ztid' and cid<>$cid and tfile='$add[tfile]' limit 1");
		if($filenum)
		{
			printerror("ZtTypeFileExist","history.go(-1)");
		}
	}
	if(empty($add['tfile']))
	{
		$add['tfile']='type'.$cid;
	}
	$sql=$empire->query("update {$dbtbpre}enewszttype set cname='$add[cname]',myorder='$add[myorder]',islist='$add[islist]',listtempid='$add[listtempid]',maxnum='$add[maxnum]',tnum='$add[tnum]',reorder='$add[reorder]',ttype='$add[ttype]',tfile='$add[tfile]' where cid='$cid'");
	$empire->query("update {$dbtbpre}enewszttypeadd set classtext='".eaddslashes2($add[classtext])."' where cid='$cid'");
	//�ı��ļ���
	if($add['tfile'].$add['ttype']<>$r['tfile'].$r['ttype'])
	{
		DelZtcFile($cid,$r);
	}
	//����ҳ��
	ListHtmlIndex($cid,'',1);
	if($sql)
	{
		//������־
		insert_dolog("ztid=".$ztid."<br>cid=".$cid."<br>cname=".$add[cname]);
		printerror("EditZtTypeSuccess","ZtType.php?ztid=$ztid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ������
function DelZtType($add,$userid,$username){
	global $empire,$dbtbpre;
	$ztid=(int)$add['ztid'];
	$cid=(int)$add['cid'];
	if(!$ztid||!$cid)
	{
		printerror("EmptyZtTypeId","history.go(-1)");
	}
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"zt");
	$r=$empire->fetch1("select * from {$dbtbpre}enewszttype where cid='$cid' and ztid='$ztid' limit 1");
	if(!$r['ztid'])
	{
		printerror('ErrorUrl','');
	}
	$sql=$empire->query("delete from {$dbtbpre}enewszttype where cid='$cid'");
	$empire->query("delete from {$dbtbpre}enewszttypeadd where cid='$cid'");
	//ɾ��ҳ��
	DelZtcFile($cid,$r);
	$empire->query("update {$dbtbpre}enewsztinfo set cid=0 where cid='$cid'");
	if($sql)
	{
		//������־
		insert_dolog("ztid=".$ztid."<br>cid=".$cid."<br>cname=".$r[cname]);
		printerror("DelZtTypeSuccess","ZtType.php?ztid=$ztid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}


$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include '../'.LoadLang('pub/fun.php');
	include('../../class/t_functions.php');
	include('../../data/dbcache/class.php');
	include('../../data/dbcache/MemberLevel.php');
}
if($enews=="AddZtType")//��������
{
	AddZtType($_POST,$logininid,$loginin);
}
elseif($enews=="EditZtType")//�޸�����
{
	EditZtType($_POST,$logininid,$loginin);
}
elseif($enews=="DelZtType")//ɾ������
{
	DelZtType($_GET,$logininid,$loginin);
}
else
{}


$ztr=$empire->fetch1("select ztid,ztname,ztpath,zturl,zttype from {$dbtbpre}enewszt where ztid='$ztid'");
if(!$ztr['ztid'])
{
	printerror('ErrorUrl','');
}
if($ztr[zturl])
{
	$ztlink=$ztr[zturl];
}
else
{
	$ztlink=$public_r['newsurl'].$ztr[ztpath];
}
$sql=$empire->query("select cid,cname,ttype,tfile from {$dbtbpre}enewszttype where ztid='$ztid' order by cid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ר������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="74%">λ�ã�<a href="ListZt.php<?=$ecms_hashur['whehref']?>">����ר��</a> &gt; 
      <?=$ztr[ztname]?>
      &gt; <a href="ZtType.php?ztid=<?=$ztid?><?=$ecms_hashur['whehref']?>">����ר������</a></td>
    <td width="26%"><div align="right">
        <input type="button" name="Submit22" value="����ר������" onclick="self.location.href='AddZtType.php?enews=AddZtType&ztid=<?=$ztid?><?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%"><div align="center">ID</div></td>
    <td width="27%" height="25"><div align="center">��������</div></td>
    <td width="48%"><div align="center">ҳ���ַ</div></td>
    <td width="19%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
	  $curl=$ztlink.'/'.$r[tfile].$r[ttype];
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td><div align="center">
          <?=$r[cid]?>
        </div></td>
      <td height="25"> <div align="center"> 
          <?=$r[cname]?>
        </div></td>
      <td><div align="center"><input type="text" name="textfield" value="<?=$curl?>">
        <a href="<?=$curl?>" target="_blank">[�鿴]</a></div></td>
      <td height="25"><div align="center">[<a href='AddZtType.php?enews=EditZtType&cid=<?=$r[cid]?>&ztid=<?=$ztid?><?=$ecms_hashur['ehref']?>'>�޸�</a>]&nbsp;&nbsp;[<a href='ZtType.php?enews=DelZtType&cid=<?=$r[cid]?>&ztid=<?=$ztid?><?=$ecms_hashur['href']?>' onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
    </tr>
  <?
  }
  db_close();
  $empire=null;
  ?>
</table>
</body>
</html>
