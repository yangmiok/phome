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
//��֤Ȩ��
CheckLevel($logininid,$loginin,$classid,"searchall");

//������������Դ
function AddSearchLoadTb($add,$userid,$username){
	global $empire,$dbtbpre;
	$tbname=RepPostVar($add['tbname']);
	$titlefield=RepPostVar($add['titlefield']);
	$infotextfield=RepPostVar($add['infotextfield']);
	$smalltextfield=RepPostVar($add['smalltextfield']);
	$loadnum=(int)$add['loadnum'];
	if(!$tbname||!$titlefield||!$infotextfield||!$smalltextfield||!$loadnum)
	{
		printerror("EmptySearchLoadTb","history.go(-1)");
	}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"searchall");
	//���Ƿ����
	$tbnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssearchall_load where tbname='$tbname'");
	if($tbnum)
	{
		printerror("ReSearchLoadTb","history.go(-1)");
	}
	$lasttime=time();
	$sql=$empire->query("insert into {$dbtbpre}enewssearchall_load(tbname,titlefield,infotextfield,smalltextfield,loadnum,lasttime,lastid) values('$tbname','$titlefield','$infotextfield','$smalltextfield',$loadnum,$lasttime,0);");
	$lid=$empire->lastid();
	GetSearchAllTb();
	if($sql)
	{
		//������־
		insert_dolog("lid=".$lid."&tbname=".$tbname);
		printerror("AddSearchLoadTbSuccess","AddSearchLoadTb.php?enews=AddSearchLoadTb".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸���������Դ
function EditSearchLoadTb($add,$userid,$username){
	global $empire,$dbtbpre;
	$lid=(int)$add['lid'];
	$tbname=RepPostVar($add['tbname']);
	$titlefield=RepPostVar($add['titlefield']);
	$infotextfield=RepPostVar($add['infotextfield']);
	$smalltextfield=RepPostVar($add['smalltextfield']);
	$loadnum=(int)$add['loadnum'];
	if(!$tbname||!$titlefield||!$infotextfield||!$smalltextfield||!$loadnum)
	{
		printerror("EmptySearchLoadTb","history.go(-1)");
	}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"searchall");
	if($tbname<>$add['oldtbname'])
	{
		//���Ƿ����
		$tbnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssearchall_load where tbname='$tbname' and lid<>$lid limit 1");
		if($tbnum)
		{
			printerror("ReSearchLoadTb","history.go(-1)");
		}
	}
	$sql=$empire->query("update {$dbtbpre}enewssearchall_load set tbname='$tbname',titlefield='$titlefield',infotextfield='$infotextfield',smalltextfield='$smalltextfield',loadnum='$loadnum' where lid='$lid'");
	GetSearchAllTb();
	if($sql)
	{
		//������־
		insert_dolog("lid=".$lid."&tbname=".$tbname);
		printerror("EditSearchLoadTbSuccess","ListSearchLoadTb.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ����������Դ
function DelSearchLoadTb($lid,$userid,$username){
	global $empire,$dbtbpre;
	$lid=(int)$lid;
	if(!$lid)
	{
		printerror("NotDelSearchLoadTbid","history.go(-1)");
	}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"searchall");
	$r=$empire->fetch1("select tbname from {$dbtbpre}enewssearchall_load where lid='$lid'");
	if(!$r['tbname'])
	{
		printerror("NotDelSearchLoadTbid","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewssearchall_load where lid='$lid'");
	$classids=ReturnTbGetClassids($r['tbname']);
	if($classids)
	{
		$delsql=$empire->query("delete from {$dbtbpre}enewssearchall where classid in (".$classids.")");
	}
	GetSearchAllTb();
	if($sql)
	{
		//������־
		insert_dolog("lid=".$lid."&tbname=".$r['tbname']);
		printerror("DelSearchLoadTbSuccess","ListSearchLoadTb.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ������Դ����
function SearchallDelData($add,$userid,$username){
	global $empire,$dbtbpre;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"searchall");
	$lid=$add['lid'];
	$count=count($lid);
	for($i=0;$i<$count;$i++)
	{
		$id=(int)$lid[$i];
		if(empty($id))
		{
			continue;
		}
		$lr=$empire->fetch1("select tbname from {$dbtbpre}enewssearchall_load where lid='$id'");
		if(empty($lr['tbname']))
		{
			continue;
		}
		$classids=ReturnTbGetClassids($lr['tbname']);
		if($classids)
		{
			$empire->query("delete from {$dbtbpre}enewssearchall where classid in (".$classids.")");
			$empire->query("update {$dbtbpre}enewssearchall_load set lastid=0 where lid='$id'");
		}
	}
	//������־
	insert_dolog("");
	printerror("SearchallDelDataSuccess","ListSearchLoadTb.php".hReturnEcmsHashStrHref2(1));
}

//ȫվ��������
function SetSearchAll($add,$userid,$username){
	global $empire,$dbtbpre;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"searchall");
	$openschall=(int)$add['openschall'];
	$schallfield=(int)$add['schallfield'];
	$schallminlen=(int)$add['schallminlen'];
	$schallmaxlen=(int)$add['schallmaxlen'];
	$schallnotcid=','.$add['schallnotcid'].',';
	$schallnum=(int)$add['schallnum'];
	$schallpagenum=(int)$add['schallpagenum'];
	$schalltime=(int)$add['schalltime'];
	$schallnotcid=hRepPostStr($schallnotcid,1);
	$sql=$empire->query("update {$dbtbpre}enewspublic set openschall=$openschall,schallfield=$schallfield,schallminlen=$schallminlen,schallmaxlen=$schallmaxlen,schallnotcid='$schallnotcid',schallnum='$schallnum',schallpagenum='$schallpagenum',schalltime='$schalltime' limit 1");
	GetConfig();
	//������־
	insert_dolog("");
	printerror("SetSearchAllSuccess","SetSearchAll.php".hReturnEcmsHashStrHref2(1));
}

//�������ݱ������Ŀ�б�
function ReturnTbGetClassids($tbname){
	global $empire,$dbtbpre;
	$ids='';
	$sql=$empire->query("select classid from {$dbtbpre}enewsclass where tbname='$tbname' and islast=1");
	while($r=$empire->fetch($sql))
	{
		$dh=',';
		if($ids=='')
		{
			$dh='';
		}
		$ids.=$dh.$r['classid'];
	}
	return $ids;
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//������������Դ
if($enews=="AddSearchLoadTb")
{
	AddSearchLoadTb($_POST,$logininid,$loginin);
}
//�޸���������Դ
elseif($enews=="EditSearchLoadTb")
{
	EditSearchLoadTb($_POST,$logininid,$loginin);
}
//ɾ����������Դ
elseif($enews=="DelSearchLoadTb")
{
	$lid=$_GET['lid'];
	DelSearchLoadTb($lid,$logininid,$loginin);
}
//ɾ������Դ����
elseif($enews=="SearchallDelData")
{
	SearchallDelData($_GET,$logininid,$loginin);
}
//ȫվ��������
elseif($enews=="SetSearchAll")
{
	SetSearchAll($_POST,$logininid,$loginin);
}

$query="select lid,tbname,lasttime,lastid from {$dbtbpre}enewssearchall_load order by lid";
$sql=$empire->query($query);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������������Դ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
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
function CheckSearchAll(obj){
	if(!confirm('ȷ��Ҫ����?'))
	{
		return false;
	}
	if(obj.enews.value=='SearchallDelData')
	{
		obj.action="ListSearchLoadTb.php";
	}
	else
	{
		obj.action="SearchLoadData.php";
	}
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã�<a href="ListSearchLoadTb.php<?=$ecms_hashur['whehref']?>">����ȫվ��������Դ</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="������������Դ" onclick="self.location.href='AddSearchLoadTb.php?enews=AddSearchLoadTb<?=$ecms_hashur['ehref']?>';">
		&nbsp;&nbsp;
        <input type="button" name="Submit52" value="ȫվ��������" onclick="self.location.href='SetSearchAll.php<?=$ecms_hashur['whehref']?>';">
        &nbsp;&nbsp; 
        <input type="button" name="Submit3" value="�����������" onclick="self.location.href='ClearSearchAll.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<form name="searchform" method="GET" action="SearchLoadData.php" onsubmit="return CheckSearchAll(document.searchform);">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="5%"><div align="center"> </div></td>
      <td width="33%" height="25"><div align="center">�������ݱ�</div></td>
      <td width="18%"><div align="center">�����ID</div></td>
      <td width="24%"><div align="center">�����ʱ��</div></td>
      <td width="20%" height="25"><div align="center">����</div></td>
    </tr>
    <?
	while($r=$empire->fetch($sql))
	{
	?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td><div align="center"> 
          <input name="lid[]" type="checkbox" id="lid[]" value="<?=$r[lid]?>">
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[tbname]?>
        </div></td>
      <td><div align="center"> 
          <?=$r[lastid]?>
        </div></td>
      <td><div align="center"> 
          <?=date("Y-m-d H:i:s",$r[lasttime])?>
        </div></td>
      <td height="25"><div align="center">[<a href="AddSearchLoadTb.php?enews=EditSearchLoadTb&lid=<?=$r[lid]?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
          [<a href="SearchLoadData.php?lid[]=<?=$r[lid]?><?=$ecms_hashur['href']?>">����</a>] [<a href="ListSearchLoadTb.php?enews=DelSearchLoadTb&lid=<?=$r[lid]?><?=$ecms_hashur['href']?>" onclick="return confirm('��ͬʱɾ�������ݱ��������¼��ȷ��Ҫɾ��?');">ɾ��</a>] 
        </div></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td><div align="center">
          <input type=checkbox name=chkall value=on onclick="CheckAll(this.form)">
        </div></td>
      <td height="25" colspan="4"><input type="submit" name="Submit" value="��������������" onclick="document.searchform.enews.value='SearchallLoadData';">
        &nbsp;&nbsp;<input type="submit" name="Submit2" value="ɾ��������" onclick="document.searchform.enews.value='SearchallDelData';">
        <input name="enews" type="hidden" id="enews" value="SearchallLoadData"> 
      </td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
