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
CheckLevel($logininid,$loginin,$classid,"user");

//���Ӳ���
function AddUserClass($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[classname])
	{
		printerror("EmptyUserClass","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"user");
	$add[classname]=hRepPostStr($add[classname],1);
	$sql=$empire->query("insert into {$dbtbpre}enewsuserclass(classname) values('".$add[classname]."');");
	$lastid=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("classid=".$lastid."<br>classname=".$add[classname]);
		printerror("AddUserClassSuccess","UserClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸Ĳ���
function EditUserClass($add,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$add[classid];
	if(!$add[classname]||!$classid)
	{
		printerror("EmptyUserClass","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"user");
	$add[classname]=hRepPostStr($add[classname],1);
	$sql=$empire->query("update {$dbtbpre}enewsuserclass set classname='".$add[classname]."' where classid='$classid'");
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$add[classname]);
		printerror("EditUserClassSuccess","UserClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ������
function DelUserClass($classid,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(!$classid)
	{
		printerror("NotDelUserClassid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"user");
	$r=$empire->fetch1("select classname from {$dbtbpre}enewsuserclass where classid='$classid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsuserclass where classid='$classid'");
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$r[classname]);
		printerror("DelUserClassSuccess","UserClass.php".hReturnEcmsHashStrHref2(1));
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
if($enews=="AddUserClass")//���Ӳ���
{
	AddUserClass($_POST,$logininid,$loginin);
}
elseif($enews=="EditUserClass")//�޸Ĳ���
{
	EditUserClass($_POST,$logininid,$loginin);
}
elseif($enews=="DelUserClass")//ɾ������
{
	$classid=$_GET['classid'];
	DelUserClass($classid,$logininid,$loginin);
}
else
{}

$sql=$empire->query("select classid,classname from {$dbtbpre}enewsuserclass order by classid desc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title></title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><p>λ�ã�<a href="ListUser.php<?=$ecms_hashur['whehref']?>">�����û�</a> &gt; <a href="UserClass.php<?=$ecms_hashur['whehref']?>">������</a></p>
      </td>
  </tr>
</table>
<form name="form1" method="post" action="UserClass.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">���Ӳ���: 
        <input name=enews type=hidden id="enews" value=AddUserClass>
        </td>
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
  <form name=form2 method=post action=UserClass.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditUserClass>
    <input type=hidden name=classid value=<?=$r[classid]?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
      <td><div align="center"><?=$r[classid]?></div></td>
      <td height="25"> <div align="center">
          <input name="classname" type="text" id="classname" value="<?=$r[classname]?>">
        </div></td>
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit3" value="�޸�">
          &nbsp; 
          <input type="button" name="Submit4" value="ɾ��" onclick="if(confirm('ȷ��Ҫɾ��?')){self.location.href='UserClass.php?enews=DelUserClass&classid=<?=$r[classid]?><?=$ecms_hashur['href']?>';}">
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
