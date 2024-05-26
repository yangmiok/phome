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
CheckLevel($logininid,$loginin,$classid,"picnews");

//����ͼƬ��Ϣ����
function AddPicClass($classname,$userid,$username){
	global $empire,$dbtbpre;
	if(!$classname)
	{printerror("EmptyPicNewsClass","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"picnews");
	$classname=hRepPostStr($classname,1);
	$sql=$empire->query("insert into {$dbtbpre}enewspicclass(classname) values('$classname');");
	$classid=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$classname);
		printerror("AddPicNewsClassSuccess","PicClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸�ͼƬ��Ϣ����
function EditPicClass($classid,$classname,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(!$classname||!$classid)
	{printerror("EmptyPicNewsClass","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"picnews");
	$classname=hRepPostStr($classname,1);
	$sql=$empire->query("update {$dbtbpre}enewspicclass set classname='$classname' where classid='$classid'");
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$classname);
		printerror("EditPicNewsClassSuccess","PicClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ��ͼƬ��Ϣ����
function DelPicClass($classid,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(!$classid)
	{printerror("NotPicNewsClassid","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"picnews");
	$r=$empire->fetch1("select classname from {$dbtbpre}enewspicclass where classid='$classid'");
	$sql=$empire->query("delete from {$dbtbpre}enewspicclass where classid='$classid'");
	$sql1=$empire->query("delete from {$dbtbpre}enewspic where classid='$classid'");
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$r[classname]);
		printerror("DelPicNewsClassSuccess","PicClass.php".hReturnEcmsHashStrHref2(1));
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
//����ͼƬ���ŷ���
if($enews=="AddPicClass")
{
	$classname=$_POST['classname'];
	AddPicClass($classname,$logininid,$loginin);
}
//�޸�ͼƬ���ŷ���
elseif($enews=="EditPicClass")
{
	$classname=$_POST['classname'];
	$classid=$_POST['classid'];
	EditPicClass($classid,$classname,$logininid,$loginin);
}
//ɾ��ͼƬ���ŷ���
elseif($enews=="DelPicClass")
{
	$classid=$_GET['classid'];
	DelPicClass($classid,$logininid,$loginin);
}

$sql=$empire->query("select classid,classname from {$dbtbpre}enewspicclass order by classid desc");
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
    <td>λ�ã�<a href=ListPicNews.php<?=$ecms_hashur['whehref']?>>����ͼƬ��Ϣ</a>&nbsp;&gt;&nbsp;<a href="PicClass.php<?=$ecms_hashur['whehref']?>">����ͼƬ��Ϣ����</a></td>
  </tr>
</table>
<form name="form1" method="post" action="PicClass.php">
  <input type=hidden name=enews value=AddPicClass>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">����ͼƬ��Ϣ���:</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> �������: 
        <input name="classname" type="text" id="classname">
        <input type="submit" name="Submit" value="����">
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td width="10%"><div align="center">ID</div></td>
    <td width="59%" height="25"><div align="center">�������</div></td>
    <td width="31%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=PicClass.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditPicClass>
    <input type=hidden name=classid value=<?=$r[classid]?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
      <td><div align="center"><?=$r[classid]?></div></td>
      <td height="25"> <div align="center">
          <input name="classname" type="text" id="classname" value="<?=$r[classname]?>">
        </div></td>
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit3" value="�޸�">
          &nbsp; 
          <input type="button" name="Submit4" value="ɾ��" onclick="if(confirm('ȷ��Ҫɾ��?')){self.location.href='PicClass.php?enews=DelPicClass&classid=<?=$r[classid]?><?=$ecms_hashur['href']?>';}">
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
