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
CheckLevel($logininid,$loginin,$classid,"key");

//�������ݹؼ��ַ���
function AddKeyClass($classname,$userid,$username){
	global $empire,$dbtbpre;
	if(!$classname)
	{
		printerror("EmptyKeyClass","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"key");
	$classname=hRepPostStr($classname,1);
	$sql=$empire->query("insert into {$dbtbpre}enewskeyclass(classname) values('$classname');");
	$classid=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$classname);
		printerror("AddKeyClassSuccess","KeyClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸����ݹؼ��ַ���
function EditKeyClass($classid,$classname,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(!$classname||!$classid)
	{
		printerror("EmptyKeyClass","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"key");
	$classname=hRepPostStr($classname,1);
	$sql=$empire->query("update {$dbtbpre}enewskeyclass set classname='$classname' where classid='$classid'");
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$classname);
		printerror("EditKeyClassSuccess","KeyClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ�����ݹؼ��ַ���
function DelKeyClass($classid,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(!$classid)
	{
		printerror("NotKeyClassid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"key");
	$r=$empire->fetch1("select classname from {$dbtbpre}enewskeyclass where classid='$classid'");
	$sql=$empire->query("delete from {$dbtbpre}enewskeyclass where classid='$classid'");
	$sql1=$empire->query("update {$dbtbpre}enewskey set cid=0 where cid='$classid'");
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$r[classname]);
		printerror("DelKeyClassSuccess","KeyClass.php".hReturnEcmsHashStrHref2(1));
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
//�������ݹؼ��ַ���
if($enews=="AddKeyClass")
{
	$classname=$_POST['classname'];
	AddKeyClass($classname,$logininid,$loginin);
}
//�޸����ݹؼ��ַ���
elseif($enews=="EditKeyClass")
{
	$classname=$_POST['classname'];
	$classid=$_POST['classid'];
	EditKeyClass($classid,$classname,$logininid,$loginin);
}
//ɾ�����ݹؼ��ַ���
elseif($enews=="DelKeyClass")
{
	$classid=$_GET['classid'];
	DelKeyClass($classid,$logininid,$loginin);
}

$sql=$empire->query("select classid,classname from {$dbtbpre}enewskeyclass order by classid desc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�������ݹؼ��ַ���</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href=key.php<?=$ecms_hashur['whehref']?>>�������ݹؼ���</a>&nbsp;&gt;&nbsp;<a href="KeyClass.php<?=$ecms_hashur['whehref']?>">�������ݹؼ��ַ���</a></td>
  </tr>
</table>
<form name="form1" method="post" action="KeyClass.php">
  <input type=hidden name=enews value=AddKeyClass>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">�������ݹؼ��ַ���:</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> ��������: 
        <input name="classname" type="text" id="classname">
        <input type="submit" name="Submit" value="����">
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td width="10%"><div align="center">ID</div></td>
    <td width="59%" height="25"><div align="center">��������</div></td>
    <td width="31%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=KeyClass.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditKeyClass>
    <input type=hidden name=classid value=<?=$r[classid]?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
      <td><div align="center"><?=$r[classid]?></div></td>
      <td height="25"> <div align="center">
          <input name="classname" type="text" id="classname" value="<?=$r[classname]?>">
        </div></td>
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit3" value="�޸�">
          &nbsp; 
          <input type="button" name="Submit4" value="ɾ��" onclick="if(confirm('ȷ��Ҫɾ��?')){self.location.href='KeyClass.php?enews=DelKeyClass&classid=<?=$r[classid]?><?=$ecms_hashur['href']?>';}">
        </div></td>
    </tr>
  </form>
  <?
  }
  db_close();
  $empire=null;
  ?>
</table>
</body>
</html>
