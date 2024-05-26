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
CheckLevel($logininid,$loginin,$classid,"sp");

//������Ƭ����
function AddSpClass($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[classname])
	{
		printerror("EmptySpClassname","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"sp");
	$add['classname']=hRepPostStr($add['classname'],1);
	$add['classsay']=hRepPostStr($add['classsay'],1);
	$sql=$empire->query("insert into {$dbtbpre}enewsspclass(classname,classsay) values('$add[classname]','$add[classsay]');");
	$classid=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$add[classname]);
		printerror("AddSpClassSuccess","AddSpClass.php?enews=AddSpClass".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸���Ƭ����
function EditSpClass($add,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$add[classid];
	if(!$classid||!$add[classname])
	{
		printerror("EmptySpClassname","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"sp");
	$add['classname']=hRepPostStr($add['classname'],1);
	$add['classsay']=hRepPostStr($add['classsay'],1);
	$sql=$empire->query("update {$dbtbpre}enewsspclass set classname='$add[classname]',classsay='$add[classsay]' where classid='$classid'");
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$add[classname]);
		printerror("EditSpClassSuccess","ListSpClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ����Ƭ����
function DelSpClass($classid,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(!$classid)
	{
		printerror("NotDelSpClassid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"sp");
	$r=$empire->fetch1("select classname from {$dbtbpre}enewsspclass where classid='$classid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsspclass where classid='$classid'");
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$r[classname]);
		printerror("DelSpClassSuccess","ListSpClass.php".hReturnEcmsHashStrHref2(1));
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
if($enews=="AddSpClass")//������Ƭ����
{
	AddSpClass($_POST,$logininid,$loginin);
}
elseif($enews=="EditSpClass")//�޸���Ƭ����
{
	EditSpClass($_POST,$logininid,$loginin);
}
elseif($enews=="DelSpClass")//ɾ����Ƭ����
{
	$classid=$_GET['classid'];
	DelSpClass($classid,$logininid,$loginin);
}

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=30;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select classid,classname from {$dbtbpre}enewsspclass";
$totalquery="select count(*) as total from {$dbtbpre}enewsspclass";
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by classid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$url="<a href=ListSp.php".$ecms_hashur['whehref'].">������Ƭ</a>&nbsp;>&nbsp;<a href=ListSpClass.php".$ecms_hashur['whehref'].">������Ƭ����</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ƭ����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td width="50%">λ��: 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="������Ƭ����" onclick="self.location.href='AddSpClass.php?enews=AddSpClass<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="9%" height="25"><div align="center">ID</div></td>
    <td width="70%" height="25"><div align="center">��������</div></td>
    <td width="21%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"> 
        <?=$r[classid]?>
      </div></td>
    <td height="25" align="center"> 
      <a href="ListSp.php?<?=$ecms_hashur['ehref']?>&cid=<?=$r[classid]?>" target="_blank"><?=$r[classname]?></a>
    </td>
    <td height="25"><div align="center">[<a href="AddSpClass.php?enews=EditSpClass&classid=<?=$r[classid]?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
        [<a href="ListSpClass.php?enews=DelSpClass&classid=<?=$r[classid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="3">&nbsp; 
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
