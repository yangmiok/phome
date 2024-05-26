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
CheckLevel($logininid,$loginin,$classid,"befrom");

//������Դ
function AddBefrom($sitename,$siteurl,$userid,$username){
	global $empire,$dbtbpre;
	if(!$sitename||!$siteurl)
	{
		printerror("EmptyBefrom","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"befrom");
	$sitename=hRepPostStr($sitename,1);
	$siteurl=hRepPostStr($siteurl,1);
	$sql=$empire->query("insert into {$dbtbpre}enewsbefrom(sitename,siteurl) values('".$sitename."','".$siteurl."');");
	$lastid=$empire->lastid();
	GetConfig();//���»���
	if($sql)
	{
		//������־
		insert_dolog("befromid=".$lastid."<br>sitename=".$sitename);
		printerror("AddBefromSuccess","BeFrom.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸���Դ
function EditBefrom($befromid,$sitename,$siteurl,$userid,$username){
	global $empire,$dbtbpre;
	if(!$sitename||!$siteurl||!$befromid)
	{
		printerror("EmptyBefrom","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"befrom");
	$befromid=(int)$befromid;
	$sitename=hRepPostStr($sitename,1);
	$siteurl=hRepPostStr($siteurl,1);
	$sql=$empire->query("update {$dbtbpre}enewsbefrom set sitename='".$sitename."',siteurl='".$siteurl."' where befromid='$befromid'");
	GetConfig();//���»���
	if($sql)
	{
		//������־
		insert_dolog("befromid=".$befromid."<br>sitename=".$sitename);
		printerror("EditBefromSuccess","BeFrom.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ����Դ
function DelBefrom($befromid,$userid,$username){
	global $empire,$dbtbpre;
	$befromid=(int)$befromid;
	if(!$befromid)
	{
		printerror("NotDelBefromid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"befrom");
	$r=$empire->fetch1("select sitename from {$dbtbpre}enewsbefrom where befromid='$befromid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsbefrom where befromid='$befromid'");
	GetConfig();//���»���
	if($sql)
	{
		//������־
		insert_dolog("befromid=".$befromid."<br>sitename=".$r[sitename]);
		printerror("DelBefromSuccess","BeFrom.php".hReturnEcmsHashStrHref2(1));
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
//������Ϣ��Դ
if($enews=="AddBefrom")
{
	$sitename=$_POST['sitename'];
	$siteurl=$_POST['siteurl'];
	AddBefrom($sitename,$siteurl,$logininid,$loginin);
}
//�޸���Ϣ��Դ
elseif($enews=="EditBefrom")
{
	$sitename=$_POST['sitename'];
	$siteurl=$_POST['siteurl'];
	$befromid=$_POST['befromid'];
	EditBefrom($befromid,$sitename,$siteurl,$logininid,$loginin);
}
//ɾ����Ϣ��Դ
elseif($enews=="DelBefrom")
{
	$befromid=$_GET['befromid'];
	DelBefrom($befromid,$logininid,$loginin);
}
else
{}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=30;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$search='';
$search.=$ecms_hashur['ehref'];
$totalquery="select count(*) as total from {$dbtbpre}enewsbefrom";
$num=$empire->gettotal($totalquery);
$query="select sitename,siteurl,befromid from {$dbtbpre}enewsbefrom order by befromid desc limit $offset,$line";
$sql=$empire->query($query);
$addsitename=ehtmlspecialchars($_GET['addsitename']);
$search.="&addsitename=$addsitename";
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ϣ��Դ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href="BeFrom.php<?=$ecms_hashur['whehref']?>">������Ϣ��Դ</a></td>
  </tr>
</table>
<form name="form1" method="post" action="BeFrom.php">
  <input type=hidden name=enews value=AddBefrom>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr>
      <td height="25" class="header">������Ϣ��Դ:</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> վ������: 
        <input name="sitename" type="text" id="sitename" value="<?=$addsitename?>">
        ���ӵ�ַ:
        <input name="siteurl" type="text" id="siteurl" value="http://" size="50"> 
        <input type="submit" name="Submit" value="����">
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="70%" height="25">��Ϣ��Դ</td>
    <td width="30%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=BeFrom.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditBefrom>
    <input type=hidden name=befromid value=<?=$r[befromid]?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25">վ������: 
        <input name="sitename" type="text" id="sitename" value="<?=$r[sitename]?>">
        ���ӵ�ַ: 
        <input name="siteurl" type="text" id="siteurl" value="<?=$r[siteurl]?>" size="30"> 
      </td>
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit3" value="�޸�">
          &nbsp; 
          <input type="button" name="Submit4" value="ɾ��" onclick="if(confirm('ȷ��Ҫɾ��?')){self.location.href='BeFrom.php?enews=DelBefrom&befromid=<?=$r[befromid]?><?=$ecms_hashur['href']?>';}">
        </div></td>
    </tr>
  </form>
  <?
  }
  db_close();
  $empire=null;
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2">
	  <?=$returnpage?>
	  </td>
    </tr>
</table>
</body>
</html>
