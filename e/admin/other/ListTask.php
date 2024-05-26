<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
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
CheckLevel($logininid,$loginin,$classid,"task");

//���������
function ReturnTogMins($min){
	$count=count($min);
	if($count==0)
	{
		return ',';
	}
	$str=',';
	for($i=0;$i<$count;$i++)
	{
		$str.=$min[$i].',';
	}
	return $str;
}

//���Ӽƻ�����
function AddTask($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add['taskname'])||empty($add['filename']))
	{
		printerror('EmptyTaskname','');
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"task");
	if(strstr($add['filename'],'/')||strstr($add['filename'],"\\"))
	{
		printerror('ErrorTaskFilename','');
	}
	$userid=(int)$add['userid'];
	$isopen=(int)$add['isopen'];
	$add['dominute']=ReturnTogMins($add['min']);
	$add['taskname']=hRepPostStr($add['taskname'],1);
	$add['filename']=hRepPostStr($add['filename'],1);
	$add['doweek']=hRepPostStr($add['doweek'],1);
	$add['doday']=hRepPostStr($add['doday'],1);
	$add['dohour']=hRepPostStr($add['dohour'],1);
	$add['dominute']=hRepPostStr($add['dominute'],1);
	$sql=$empire->query("insert into {$dbtbpre}enewstask(taskname,userid,isopen,filename,lastdo,doweek,doday,dohour,dominute) values('$add[taskname]',$userid,$isopen,'$add[filename]',0,'$add[doweek]','$add[doday]','$add[dohour]','$add[dominute]');");
	if($sql)
	{
		$id=$empire->lastid();
		//������־
		insert_dolog("id=$id&taskname=$add[taskname]&filename=$add[filename]");
		printerror('AddTaskSuccess','AddTask.php?enews=AddTask'.hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror('DbError',"");
	}
}

//�޸ļƻ�����
function EditTask($add,$userid,$username){
	global $empire,$dbtbpre;
	$id=(int)$add['id'];
	if(!$id||empty($add['taskname'])||empty($add['filename']))
	{
		printerror('EmptyTaskname','');
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"task");
	if(strstr($add['filename'],'/')||strstr($add['filename'],"\\"))
	{
		printerror('ErrorTaskFilename','');
	}
	$userid=(int)$add['userid'];
	$isopen=(int)$add['isopen'];
	$add['dominute']=ReturnTogMins($add['min']);
	$add['taskname']=hRepPostStr($add['taskname'],1);
	$add['filename']=hRepPostStr($add['filename'],1);
	$add['doweek']=hRepPostStr($add['doweek'],1);
	$add['doday']=hRepPostStr($add['doday'],1);
	$add['dohour']=hRepPostStr($add['dohour'],1);
	$add['dominute']=hRepPostStr($add['dominute'],1);
	$sql=$empire->query("update {$dbtbpre}enewstask set taskname='$add[taskname]',userid=$userid,isopen=$isopen,filename='$add[filename]',doweek='$add[doweek]',doday='$add[doday]',dohour='$add[dohour]',dominute='$add[dominute]' where id=$id");
	if($sql)
	{
		//������־
		insert_dolog("id=$id&taskname=$add[taskname]&filename=$add[filename]");
		printerror('EditTaskSuccess','ListTask.php'.hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror('DbError',"");
	}
}

//ɾ���ƻ�����
function DelTask($add,$userid,$username){
	global $empire,$dbtbpre;
	$id=(int)$add['id'];
	if(!$id)
	{
		printerror('EmptyDelTaskId','');
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"task");
	$r=$empire->fetch1("select taskname,filename from {$dbtbpre}enewstask where id=$id");
	$sql=$empire->query("delete from {$dbtbpre}enewstask where id=$id");
	if($sql)
	{
		//������־
		insert_dolog("id=$id&taskname=$r[taskname]&filename=$r[filename]");
		printerror('DelTaskSuccess','ListTask.php'.hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror('DbError',"");
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}

if($enews=="AddTask")
{
	AddTask($_POST,$logininid,$loginin);
}
elseif($enews=="EditTask")
{
	EditTask($_POST,$logininid,$loginin);
}
elseif($enews=="DelTask")
{
	DelTask($_GET,$logininid,$loginin);
}
else
{}

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=20;//ÿҳ��ʾ����
$page_line=20;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select id,taskname,isopen,lastdo,doweek,doday,dohour,dominute from {$dbtbpre}enewstask";
$totalquery="select count(*) as total from {$dbtbpre}enewstask";
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by id desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>����ƻ�����</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">λ�ã�<a href='ListTask.php<?=$ecms_hashur['whehref']?>'>����ƻ�����</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit" value="���Ӽƻ�����" onclick="self.location.href='AddTask.php?enews=AddTask<?=$ecms_hashur['ehref']?>';">&nbsp;&nbsp;
		<input type="button" name="Submit" value="���мƻ�����ҳ��" onclick="window.open('../task.php<?=$ecms_hashur['whhref']?>');">
      </div></td>
  </tr>
</table>

<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%" height="25"> <div align="center">ID</div></td>
    <td width="25%" height="25"> <div align="center">��������</div></td>
    <td width="15%" height="25"> 
      <div align="center">����</div></td>
    <td width="5%">
<div align="center">Сʱ</div></td>
    <td width="5%">
<div align="center">����</div></td>
    <td width="5%"><div align="center">��</div></td>
    <td width="17%"><div align="center">���ִ��ʱ��</div></td>
    <td width="5%"><div align="center">״̬</div></td>
    <td width="17%" height="25"> <div align="center">����</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  	$r['doweek']=','.$r['doweek'].','!=',*,'&&$r['doweek']==0?7:$r['doweek'];
	$lastdo=$r['lastdo']?date("Y-m-d H:i",$r['lastdo']):'---';
	if(strlen($r['dominute'])>26)
	{
		$r['dominute']=substr($r['dominute'],0,23).'...';
	}
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r['id']?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r['taskname']?>
      </div></td>
    <td height="25"><div align="center"><?=$r['dominute']?></div></td>
    <td><div align="center"><?=$r['dohour']?></div></td>
    <td><div align="center"><?=$r['doweek']?></div></td>
    <td><div align="center"><?=$r['doday']?></div></td>
    <td><div align="center"><?=$lastdo?></div></td>
    <td><div align="center"><?=$r['isopen']==1?'����':'�ر�'?></div></td>
    <td height="25"> <div align="center">[<a href="../task.php?ecms=TodoTask&id=<?=$r[id]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫִ��?');">ִ��</a>] 
        [<a href="AddTask.php?enews=EditTask&id=<?=$r[id]?><?=$ecms_hashur['ehref']?>">�޸�</a>]&nbsp;[<a href="ListTask.php?enews=DelTask&id=<?=$r[id]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="9">&nbsp;&nbsp;&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
