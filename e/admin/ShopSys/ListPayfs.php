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
CheckLevel($logininid,$loginin,$classid,"shoppayfs");

//����֧����ʽ
function AddPayfs($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add[payname]))
	{
		printerror("EmptyPayname","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"shoppayfs");
	$add[userpay]=(int)$add[userpay];
	$add[userfen]=(int)$add[userfen];
	$add['isclose']=(int)$add['isclose'];
	$add['payname']=ehtmlspecialchars($add['payname']);
	$sql=$empire->query("insert into {$dbtbpre}enewsshoppayfs(payname,payurl,paysay,userpay,userfen,isclose) values('".eaddslashes($add[payname])."','".eaddslashes($add[payurl])."','".eaddslashes($add[paysay])."','$add[userpay]','$add[userfen]','$add[isclose]');");
	$payid=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("payid=".$payid."<br>payname=".$add[payname]);
		printerror("AddPayfsSuccess","AddPayfs.php?enews=AddPayfs".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸�֧����ʽ
function EditPayfs($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[payid]=(int)$add[payid];
	if(empty($add[payname])||!$add[payid])
	{
		printerror("EmptyPayname","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"shoppayfs");
	$add[userpay]=(int)$add[userpay];
	$add[userfen]=(int)$add[userfen];
	$add['isclose']=(int)$add['isclose'];
	$add['payname']=ehtmlspecialchars($add['payname']);
	$sql=$empire->query("update {$dbtbpre}enewsshoppayfs set payname='".eaddslashes($add[payname])."',payurl='".eaddslashes($add[payurl])."',paysay='".eaddslashes($add[paysay])."',userpay='$add[userpay]',userfen='$add[userfen]',isclose='$add[isclose]' where payid='$add[payid]'");
	if($sql)
	{
		//������־
		insert_dolog("payid=".$add[payid]."<br>payname=".$add[payname]);
		printerror("EditPayfsSuccess","ListPayfs.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ��֧����ʽ
function DelPayfs($payid,$userid,$username){
	global $empire,$dbtbpre;
	$payid=(int)$payid;
	if(!$payid)
	{
		printerror("EmptyPayfsid","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"shoppayfs");
	$r=$empire->fetch1("select payname from {$dbtbpre}enewsshoppayfs where payid='$payid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsshoppayfs where payid='$payid'");
	if($sql)
	{
		//������־
		insert_dolog("payid=".$payid."<br>payname=".$r[payname]);
		printerror("DelPayfsSuccess","ListPayfs.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//����ΪĬ��֧����ʽ
function DefPayfs($payid,$userid,$username){
	global $empire,$dbtbpre;
	$payid=(int)$payid;
	if(!$payid)
	{
		printerror("EmptyPayfsid","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"shoppayfs");
	$r=$empire->fetch1("select payname from {$dbtbpre}enewsshoppayfs where payid='$payid'");
	$upsql=$empire->query("update {$dbtbpre}enewsshoppayfs set isdefault=0");
	$sql=$empire->query("update {$dbtbpre}enewsshoppayfs set isdefault=1 where payid='$payid'");
	if($sql)
	{
		//������־
		insert_dolog("payid=".$payid."<br>payname=".$r[payname]);
		printerror("DefPayfsSuccess","ListPayfs.php".hReturnEcmsHashStrHref2(1));
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
if($enews=="AddPayfs")
{
	AddPayfs($_POST,$logininid,$loginin);
}
elseif($enews=="EditPayfs")
{
	EditPayfs($_POST,$logininid,$loginin);
}
elseif($enews=="DelPayfs")
{
	$payid=$_GET['payid'];
	DelPayfs($payid,$logininid,$loginin);
}
elseif($enews=="DefPayfs")
{
	$payid=$_GET['payid'];
	DefPayfs($payid,$logininid,$loginin);
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
$query="select * from {$dbtbpre}enewsshoppayfs";
$num=$empire->num($query);//ȡ��������
$query=$query." order by payid limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>����֧����ʽ</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">λ�ã�<a href="ListPayfs.php<?=$ecms_hashur['whehref']?>">����֧����ʽ</a>&nbsp;&nbsp;&nbsp; 
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit" value="����֧����ʽ" onclick="self.location.href='AddPayfs.php?enews=AddPayfs<?=$ecms_hashur['ehref']?>'">
      </div></td>
  </tr>
</table>

<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"> <div align="center">ID</div></td>
    <td width="41%" height="25"> <div align="center">֧����ʽ</div></td>
    <td width="16%"><div align="center">Ĭ��</div></td>
    <td width="16%"><div align="center">����</div></td>
    <td width="22%" height="25"> <div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r[payid]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[payname]?>
      </div></td>
    <td><div align="center"><?=$r[isdefault]==1?'��':'--'?></div></td>
    <td><div align="center"><?=$r[isclose]==1?'�ر�':'����'?></div></td>
    <td height="25"> <div align="center">[<a href="AddPayfs.php?enews=EditPayfs&payid=<?=$r[payid]?><?=$ecms_hashur['ehref']?>">�޸�</a>] [<a href="ListPayfs.php?enews=DefPayfs&payid=<?=$r[payid]?><?=$ecms_hashur['href']?>">��ΪĬ��</a>] [<a href="ListPayfs.php?enews=DelPayfs&payid=<?=$r[payid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="5">&nbsp;&nbsp;&nbsp; 
      <?=$returnpage?>    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
