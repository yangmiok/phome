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
CheckLevel($logininid,$loginin,$classid,"shopps");

//�������ͷ�ʽ
function AddPs($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add[pname]))
	{
		printerror("EmptyPayname","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"shopps");
	$add[price]=(float)$add[price];
	$add['isclose']=(int)$add['isclose'];
	$add['pname']=ehtmlspecialchars($add['pname']);
	$add['otherprice']=hRepPostStr($add['otherprice'],1);
	$sql=$empire->query("insert into {$dbtbpre}enewsshopps(pname,price,otherprice,psay,isclose) values('".eaddslashes($add[pname])."','$add[price]','$add[otherprice]','".eaddslashes($add[psay])."','$add[isclose]');");
	$pid=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("pid=".$pid."<br>pname=".$add[pname]);
		printerror("AddPayfsSuccess","AddPs.php?enews=AddPs".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸����ͷ�ʽ
function EditPs($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[pid]=(int)$add[pid];
	if(empty($add[pname])||!$add[pid])
	{
		printerror("EmptyPayname","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"shopps");
	$add[price]=(float)$add[price];
	$add['isclose']=(int)$add['isclose'];
	$add['pname']=ehtmlspecialchars($add['pname']);
	$add['otherprice']=hRepPostStr($add['otherprice'],1);
	$sql=$empire->query("update {$dbtbpre}enewsshopps set pname='".eaddslashes($add[pname])."',price='$add[price]',otherprice='$add[otherprice]',psay='".eaddslashes($add[psay])."',isclose='$add[isclose]' where pid='$add[pid]'");
	if($sql)
	{
		//������־
		insert_dolog("pid=".$add[pid]."<br>pname=".$add[pname]);
		printerror("EditPayfsSuccess","ListPs.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ�����ͷ�ʽ
function DelPs($pid,$userid,$username){
	global $empire,$dbtbpre;
	$pid=(int)$pid;
	if(!$pid)
	{
		printerror("EmptyPayfsid","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"shopps");
	$r=$empire->fetch1("select pname from {$dbtbpre}enewsshopps where pid='$pid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsshopps where pid='$pid'");
	if($sql)
	{
		//������־
		insert_dolog("pid=".$pid."<br>pname=".$r[pname]);
		printerror("DelPayfsSuccess","ListPs.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//����ΪĬ�����ͷ�ʽ
function DefPs($pid,$userid,$username){
	global $empire,$dbtbpre;
	$pid=(int)$pid;
	if(!$pid)
	{
		printerror("EmptyPayfsid","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"shopps");
	$r=$empire->fetch1("select pname from {$dbtbpre}enewsshopps where pid='$pid'");
	$upsql=$empire->query("update {$dbtbpre}enewsshopps set isdefault=0");
	$sql=$empire->query("update {$dbtbpre}enewsshopps set isdefault=1 where pid='$pid'");
	if($sql)
	{
		//������־
		insert_dolog("pid=".$pid."<br>pname=".$r[pname]);
		printerror("DefPayfsSuccess","ListPs.php".hReturnEcmsHashStrHref2(1));
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
if($enews=="AddPs")
{
	AddPs($_POST,$logininid,$loginin);
}
elseif($enews=="EditPs")
{
	EditPs($_POST,$logininid,$loginin);
}
elseif($enews=="DelPs")
{
	$pid=$_GET['pid'];
	DelPs($pid,$logininid,$loginin);
}
elseif($enews=="DefPs")
{
	$pid=$_GET['pid'];
	DefPs($pid,$logininid,$loginin);
}
else
{}

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=16;//ÿҳ��ʾ����
$page_line=18;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select * from {$dbtbpre}enewsshopps";
$num=$empire->num($query);//ȡ��������
$query=$query." order by pid limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>�������ͷ�ʽ</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">λ�ã�<a href="ListPs.php<?=$ecms_hashur['whehref']?>">�������ͷ�ʽ</a>&nbsp;&nbsp;&nbsp; 
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit" value="�������ͷ�ʽ" onclick="self.location.href='AddPs.php?enews=AddPs<?=$ecms_hashur['ehref']?>'">
      </div></td>
  </tr>
</table>

<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"> <div align="center">ID</div></td>
    <td width="36%" height="25"> <div align="center">���ͷ�ʽ</div></td>
    <td width="15%"><div align="center">�۸�</div></td>
    <td width="11%"><div align="center">Ĭ��</div></td>
    <td width="11%"><div align="center">����</div></td>
    <td width="22%" height="25"> <div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r[pid]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[pname]?>
      </div></td>
    <td><div align="center"> 
        <?=$r[price]?>
        Ԫ </div></td>
    <td><div align="center"><?=$r[isdefault]==1?'��':'--'?></div></td>
    <td><div align="center"><?=$r[isclose]==1?'�ر�':'����'?></div></td>
    <td height="25"> <div align="center">[<a href="AddPs.php?enews=EditPs&pid=<?=$r[pid]?><?=$ecms_hashur['ehref']?>">�޸�</a>] [<a href="ListPs.php?enews=DefPs&pid=<?=$r[pid]?><?=$ecms_hashur['href']?>">��ΪĬ��</a>] [<a href="ListPs.php?enews=DelPs&pid=<?=$r[pid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="6">&nbsp;&nbsp;&nbsp; 
      <?=$returnpage?>    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
