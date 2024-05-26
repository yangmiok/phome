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
CheckLevel($logininid,$loginin,$classid,"adminstyle");

//������ʽ����
function UpAdminstyle(){
	global $empire,$dbtbpre;
	$adminstyle=',';
	$sql=$empire->query("select path from {$dbtbpre}enewsadminstyle");
	while($r=$empire->fetch($sql))
	{
		$adminstyle.=$r['path'].',';
	}
	$empire->query("update {$dbtbpre}enewspublic set adminstyle='$adminstyle'");
	GetConfig();
}

//���Ӻ�̨��ʽ
function AddAdminstyle($add,$userid,$username){
	global $empire,$dbtbpre;
	$path=RepPathStr($add['path']);
	$path=(int)$path;
	if(empty($path)||empty($add['stylename']))
	{
		printerror("EmptyAdminStyle","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"adminstyle");
	//Ŀ¼�Ƿ����
	if(!file_exists("../adminstyle/".$path))
	{
		printerror("EmptyAdminStylePath","history.go(-1)");
	}
	$add['stylename']=hRepPostStr($add['stylename'],1);
	$sql=$empire->query("insert into {$dbtbpre}enewsadminstyle(stylename,path,isdefault) values('$add[stylename]',$path,0);");
	if($sql)
	{
		UpAdminstyle();
		$styleid=$empire->lastid();
		//������־
		insert_dolog("styleid=$styleid&stylename=$add[stylename]");
		printerror("AddAdminStyleSuccess","AdminStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸ĺ�̨��ʽ
function EditAdminStyle($add,$userid,$username){
	global $empire,$dbtbpre;
	$styleid=(int)$add['styleid'];
	$path=RepPathStr($add['path']);
	$path=(int)$path;
	if(!$styleid||empty($path)||empty($add['stylename']))
	{
		printerror("EmptyAdminStyle","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"adminstyle");
	//Ŀ¼�Ƿ����
	if(!file_exists("../adminstyle/".$path))
	{
		printerror("EmptyAdminStylePath","history.go(-1)");
	}
	$add['stylename']=hRepPostStr($add['stylename'],1);
	$sql=$empire->query("update {$dbtbpre}enewsadminstyle set stylename='$add[stylename]',path=$path where styleid=$styleid");
	if($sql)
	{
		UpAdminstyle();
		//������־
		insert_dolog("styleid=$styleid&stylename=$add[stylename]");
		printerror("EditAdminStyleSuccess","AdminStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//Ĭ�Ϻ�̨��ʽ
function DefAdminStyle($styleid,$userid,$username){
	global $empire,$dbtbpre;
	$styleid=(int)$styleid;
	if(!$styleid)
	{
		printerror("EmptyAdminStyleid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"adminstyle");
	$r=$empire->fetch1("select stylename,path from {$dbtbpre}enewsadminstyle where styleid=$styleid");
	$usql=$empire->query("update {$dbtbpre}enewsadminstyle set isdefault=0");
	$sql=$empire->query("update {$dbtbpre}enewsadminstyle set isdefault=1 where styleid=$styleid");
	$upsql=$empire->query("update {$dbtbpre}enewspublic set defadminstyle='$r[path]' limit 1");
	if($sql)
	{
		GetConfig();
		//������־
		insert_dolog("styleid=$styleid&stylename=$r[stylename]");
		printerror("DefAdminStyleSuccess","AdminStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ����̨��ʽ
function DelAdminStyle($styleid,$userid,$username){
	global $empire,$dbtbpre;
	$styleid=(int)$styleid;
	if(!$styleid)
	{
		printerror("EmptyAdminStyleid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"adminstyle");
	$r=$empire->fetch1("select stylename,path,isdefault from {$dbtbpre}enewsadminstyle where styleid=$styleid");
	if($r['isdefault'])
	{
		printerror("NotDelDefAdminStyle","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsadminstyle where styleid=$styleid");
	if($sql)
	{
		UpAdminstyle();
		//������־
		insert_dolog("styleid=$styleid&stylename=$r[stylename]");
		printerror("DelAdminStyleSuccess","AdminStyle.php".hReturnEcmsHashStrHref2(1));
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
//���Ӻ�̨��ʽ
if($enews=="AddAdminStyle")
{
	AddAdminstyle($_POST,$logininid,$loginin);
}
//�޸ĺ�̨��ʽ
elseif($enews=="EditAdminStyle")
{
	EditAdminStyle($_POST,$logininid,$loginin);
}
//Ĭ�Ϻ�̨��ʽ
elseif($enews=="DefAdminStyle")
{
	DefAdminStyle($_GET['styleid'],$logininid,$loginin);
}
//ɾ����̨��ʽ
elseif($enews=="DelAdminStyle")
{
	DelAdminStyle($_GET['styleid'],$logininid,$loginin);
}
$sql=$empire->query("select styleid,stylename,path,isdefault from {$dbtbpre}enewsadminstyle order by styleid");
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
    <td><p>λ�ã�<a href="AdminStyle.php<?=$ecms_hashur['whehref']?>">�����̨��ʽ</a></p>
      </td>
  </tr>
</table>
<form name="form1" method="post" action="AdminStyle.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">���Ӻ�̨��ʽ: 
        <input name=enews type=hidden id="enews" value=AddAdminStyle>
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> ��ʽ����: 
        <input name="stylename" type="text" id="stylename">
        ��ʽĿ¼:adminstyle/ 
        <input name="path" type="text" id="path" size="6">
        (����д����) 
        <input type="submit" name="Submit" value="����">
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="7%"><div align="center">ID</div></td>
    <td width="29%" height="25"><div align="center">��ʽ����</div></td>
    <td width="30%"><div align="center">��ʽĿ¼</div></td>
    <td width="34%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  	$bgcolor="#FFFFFF";
	$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
  	if($r[isdefault])
	{
		$bgcolor="#DBEAF5";
		$movejs='';
	}
  ?>
  <form name=form2 method=post action=AdminStyle.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditAdminStyle>
    <input type=hidden name=styleid value=<?=$r[styleid]?>>
    <tr bgcolor="<?=$bgcolor?>"<?=$movejs?>> 
      <td><div align="center">
          <?=$r[styleid]?>
        </div></td>
      <td height="25"> <div align="center"> 
          <input name="stylename" type="text" id="stylename" value="<?=$r[stylename]?>">
        </div></td>
      <td><div align="center">adminstyle/ 
          <input name="path" type="text" id="path" value="<?=$r[path]?>" size="6">
        </div></td>
      <td height="25"><div align="center">
          <input type="button" name="Submit4" value="��ΪĬ��" onclick="self.location.href='AdminStyle.php?enews=DefAdminStyle&styleid=<?=$r[styleid]?><?=$ecms_hashur['href']?>';"> 
		  &nbsp;
          <input type="submit" name="Submit3" value="�޸�">
          &nbsp; 
          <input type="button" name="Submit4" value="ɾ��" onclick="self.location.href='AdminStyle.php?enews=DelAdminStyle&styleid=<?=$r[styleid]?><?=$ecms_hashur['href']?>';">
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
