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
CheckLevel($logininid,$loginin,$classid,"workflow");

//�����û���
function ReturnWfGroup($groupid){
	$count=count($groupid);
	if($count==0)
	{
		return '';
	}
	$ids=',';
	for($i=0;$i<$count;$i++)
	{
		$ids.=$groupid[$i].',';
	}
	return $ids;
}

//���ӽڵ�
function AddWorkflowItem($add,$userid,$username){
	global $empire,$dbtbpre;
	$wfid=(int)$add['wfid'];
	$tno=(int)$add['tno'];
	$lztype=(int)$add['lztype'];
	$tbdo=(int)$add['tbdo'];
	$tddo=(int)$add['tddo'];
	if(!$wfid||!$tno)
	{
		printerror('EmptyWorkflowItem','history.go(-1)');
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"workflow");
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsworkflowitem where wfid='$wfid' and tno='$tno' limit 1");
	if($num)
	{
		printerror('HaveWorkflowItem','history.go(-1)');
	}
	$groupid=ReturnWfGroup($add[groupid]);
	$userclass=ReturnWfGroup($add[userclass]);
	$username=','.$add[username].',';
	if($groupid==''&&$userclass==''&&$add[username]=='')
	{
		printerror('EmptyWorkflowItemUser','history.go(-1)');
	}
	$add['tname']=hRepPostStr($add['tname'],1);
	$add['ttext']=hRepPostStr($add['ttext'],1);
	$groupid=hRepPostStr($groupid,1);
	$userclass=hRepPostStr($userclass,1);
	$username=hRepPostStr($username,1);
	$add['tstatus']=hRepPostStr($add['tstatus'],1);
	$sql=$empire->query("insert into {$dbtbpre}enewsworkflowitem(wfid,tname,tno,ttext,groupid,userclass,username,lztype,tbdo,tddo,tstatus) values('$wfid','$add[tname]','$tno','$add[ttext]','$groupid','$userclass','$username','$lztype','$tbdo','$tddo','$add[tstatus]');");
	$tid=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("wfid=$wfid&tid=$tid<br>tname=".$add[tname]);
		printerror("AddWorkflowItemSuccess","AddWfItem.php?enews=AddWorkflowItem&wfid=$wfid".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸Ľڵ�
function EditWorkflowItem($add,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$add['tid'];
	$wfid=(int)$add['wfid'];
	$tno=(int)$add['tno'];
	$lztype=(int)$add['lztype'];
	$tbdo=(int)$add['tbdo'];
	$tddo=(int)$add['tddo'];
	if(!$tid||!$wfid||!$tno)
	{
		printerror('EmptyWorkflowItem','history.go(-1)');
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"workflow");
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsworkflowitem where wfid='$wfid' and tno='$tno' and tid<>$tid limit 1");
	if($num)
	{
		printerror('HaveWorkflowItem','history.go(-1)');
	}
	$groupid=ReturnWfGroup($add[groupid]);
	$userclass=ReturnWfGroup($add[userclass]);
	$username=','.$add[username].',';
	if($groupid==''&&$userclass==''&&$add[username]=='')
	{
		printerror('EmptyWorkflowItemUser','history.go(-1)');
	}
	$add['tname']=hRepPostStr($add['tname'],1);
	$add['ttext']=hRepPostStr($add['ttext'],1);
	$groupid=hRepPostStr($groupid,1);
	$userclass=hRepPostStr($userclass,1);
	$username=hRepPostStr($username,1);
	$add['tstatus']=hRepPostStr($add['tstatus'],1);
	$sql=$empire->query("update {$dbtbpre}enewsworkflowitem set tname='$add[tname]',tno='$tno',ttext='$add[ttext]',groupid='$groupid',userclass='$userclass',username='$username',lztype='$lztype',tbdo='$tbdo',tddo='$tddo',tstatus='$add[tstatus]' where tid='$tid'");
	if($sql)
	{
		//������־
		insert_dolog("wfid=$wfid&tid=$tid<br>tname=".$add[tname]);
		printerror("EditWorkflowItemSuccess","ListWfItem.php?wfid=$wfid".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ���ڵ�
function DelWorkflowItem($add,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$add[tid];
	$wfid=(int)$add['wfid'];
	if(!$tid||!$wfid)
	{
		printerror("NotDelWorkflowItemid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"workflow");
	$r=$empire->fetch1("select tname from {$dbtbpre}enewsworkflowitem where tid='$tid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsworkflowitem where tid='$tid'");
	if($sql)
	{
		//������־
		insert_dolog("wfid=$wfid&tid=$tid<br>tname=".$r[tname]);
		printerror("DelWorkflowItemSuccess","ListWfItem.php?wfid=$wfid".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸Ľڵ���
function EditWorkflowItemTno($add,$userid,$username){
	global $empire,$dbtbpre;
	$wfid=(int)$add['wfid'];
	$tno=$add[tno];
	$tid=$add[tid];
	for($i=0;$i<count($tid);$i++)
	{
		$newtno=(int)$tno[$i];
		if(empty($newtno))
		{
			continue;
		}
		$newtid=(int)$tid[$i];
		$empire->query("update {$dbtbpre}enewsworkflowitem set tno='$newtno' where tid='$newtid'");
    }
	//������־
	insert_dolog("wfid=$wfid");
	printerror("EditWorkflowItemSuccess","ListWfItem.php?wfid=$wfid".hReturnEcmsHashStrHref2(0));
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=="AddWorkflowItem")//���ӽڵ�
{
	AddWorkflowItem($_POST,$logininid,$loginin);
}
elseif($enews=="EditWorkflowItem")//�޸Ľڵ�
{
	EditWorkflowItem($_POST,$logininid,$loginin);
}
elseif($enews=="DelWorkflowItem")//ɾ���ڵ�
{
	DelWorkflowItem($_GET,$logininid,$loginin);
}
elseif($enews=="EditWorkflowItemTno")//�޸Ľڵ���
{
	EditWorkflowItemTno($_POST,$logininid,$loginin);
}

$wfid=(int)$_GET['wfid'];
if(!$wfid)
{
	printerror('ErrorUrl','');
}
$wfr=$empire->fetch1("select wfid,wfname from {$dbtbpre}enewsworkflow where wfid='$wfid'");
if(!$wfr['wfid'])
{
	printerror('ErrorUrl','');
}
$query="select tid,tname,tno,lztype from {$dbtbpre}enewsworkflowitem where wfid='$wfid' order by tno,tid";
$sql=$empire->query($query);
$url="<a href=ListWf.php".$ecms_hashur['whehref'].">��������</a> &gt; ".$wfr[wfname]." &gt; <a href='ListWfItem.php?wfid=$wfid".$ecms_hashur['ehref']."'>����ڵ�</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td width="50%">λ��: 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="���ӽڵ�" onclick="self.location.href='AddWfItem.php?enews=AddWorkflowItem&wfid=<?=$wfid?><?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ListWfItem.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="10%"><div align="center">���</div></td>
      <td width="44%" height="25"> <div align="center">�ڵ�����</div></td>
      <td width="16%"><div align="center">��ת��ʽ</div></td>
      <td width="23%" height="25"><div align="center">����</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td><div align="center"> 
          <input name="tno[]" type="text" id="tno[]" value="<?=$r[tno]?>" size="5">
		<input type="hidden" name="tid[]" value="<?=$r[tid]?>">
        </div></td>
      <td height="25"> 
        <?=$r[tname]?>
      </td>
      <td><div align="center"> 
          <?=$r[lztype]==1?'��ǩ':'��ͨ��ת'?>
        </div></td>
      <td height="25"><div align="center">[<a href="AddWfItem.php?enews=EditWorkflowItem&tid=<?=$r[tid]?>&wfid=<?=$wfid?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
          [<a href="AddWfItem.php?enews=AddWorkflowItem&tid=<?=$r[tid]?>&wfid=<?=$wfid?>&docopy=1<?=$ecms_hashur['ehref']?>">����</a>] 
          [<a href="ListWfItem.php?enews=DelWorkflowItem&tid=<?=$r[tid]?>&wfid=<?=$wfid?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="4"> <input type="submit" name="Submit" value="�޸ı��"> 
        <input name="enews" type="hidden" id="enews" value="EditWorkflowItemTno">
        <input name="wfid" type="hidden" id="wfid" value="<?=$wfid?>"> </td>
    </tr>
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
