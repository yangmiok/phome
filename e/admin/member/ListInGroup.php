<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../member/class/user.php");
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
CheckLevel($logininid,$loginin,$classid,"ingroup");

//���ӻ�Ա�ڲ���
function AddInGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add['gname']))
	{
		printerror('EmptyInGroup','history.go(-1)');
	}
	$add['gname']=hRepPostStr($add['gname'],1);
	$add['myorder']=(int)$add['myorder'];
	$sql=$empire->query("insert into {$dbtbpre}enewsingroup(gname,myorder) values('$add[gname]','$add[myorder]');");
	//���»���
	GetMemberLevel();
	if($sql)
	{
		$gid=$empire->lastid();
		insert_dolog("gid=$gid&gname=$add[gname]");//������־
		printerror("AddInGroupSuccess","AddInGroup.php?enews=AddInGroup".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸Ļ�Ա�ڲ���
function EditInGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	$gid=intval($add['gid']);
	if(empty($add['gname'])||!$gid)
	{
		printerror('EmptyInGroup','history.go(-1)');
	}
	$add['gname']=hRepPostStr($add['gname'],1);
	$add['myorder']=(int)$add['myorder'];
	$sql=$empire->query("update {$dbtbpre}enewsingroup set gname='$add[gname]',myorder='$add[myorder]' where gid='$gid'");
	//���»���
	GetMemberLevel();
	if($sql)
	{
		insert_dolog("gid=$gid&gname=$add[gname]");//������־
		printerror("EditInGroupSuccess","ListInGroup.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ����Ա�ڲ���
function DelInGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	$gid=intval($add['gid']);
	if(!$gid)
	{
		printerror('EmptyInGroupid','history.go(-1)');
	}
	$r=$empire->fetch1("select gid,gname from {$dbtbpre}enewsingroup where gid='$gid'");
	if(!$r['gid'])
	{
		printerror('EmptyInGroupid','history.go(-1)');
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsingroup where gid='$gid'");
	//���»���
	GetMemberLevel();
	if($sql)
	{
		insert_dolog("gid=$gid&gname=$r[gname]");//������־
		printerror("DelInGroupSuccess","ListInGroup.php".hReturnEcmsHashStrHref2(1));
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
}
if($enews=="AddInGroup")
{
	AddInGroup($_POST,$logininid,$loginin);
}
elseif($enews=="EditInGroup")
{
	EditInGroup($_POST,$logininid,$loginin);
}
elseif($enews=="DelInGroup")
{
	DelInGroup($_GET,$logininid,$loginin);
}


$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=16;//ÿҳ��ʾ����
$page_line=25;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select * from {$dbtbpre}enewsingroup";
$totalquery="select count(*) as total from {$dbtbpre}enewsingroup";
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by gid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>��Ա�ڲ���</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">λ�ã�<a href="ListInGroup.php<?=$ecms_hashur['whehref']?>">�����Ա�ڲ���</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="���ӻ�Ա�ڲ���" onclick="self.location.href='AddInGroup.php?enews=AddInGroup<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>

<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%" height="25"> <div align="center">ID</div></td>
    <td width="49%" height="25"> <div align="center">������</div></td>
    <td width="24%"><div align="center">��Ա��</div></td>
    <td width="21%" height="25"> <div align="center">����</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  	$color="#ffffff";
	$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
	$membernum=$empire->gettotal("select count(*) as total from ".eReturnMemberTable()." where ".egetmf('ingid')."='$r[gid]'");
  ?>
  <tr bgcolor="<?=$color?>"<?=$movejs?>> 
    <td height="25"> <div align="center"> 
        <?=$r[gid]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[gname]?>
      </div></td>
    <td><div align="center"><a href="ListMember.php?sear=1&ingid=<?=$r['gid']?><?=$ecms_hashur['ehref']?>" target="_blank" title="����鿴�б�"><?=$membernum?></a></div></td>
    <td height="25"> <div align="center"> [<a href="AddInGroup.php?enews=EditInGroup&gid=<?=$r[gid]?><?=$ecms_hashur['ehref']?>">�޸�</a>]&nbsp;[<a href="ListInGroup.php?enews=DelInGroup&gid=<?=$r[gid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="4">&nbsp;&nbsp;&nbsp; 
      <?=$returnpage?>    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
