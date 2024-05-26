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
CheckLevel($logininid,$loginin,$classid,"template");

//������ҳ����
function AddIndexpage($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[tempname]||!$add[temptext])
	{
		printerror("EmptyIndexpageName","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$add[tempname]=hRepPostStr($add[tempname],1);
	$add[temptext]=RepPhpAspJspcode($add[temptext]);
	$sql=$empire->query("insert into {$dbtbpre}enewsindexpage(tempname,temptext) values('".$add[tempname]."','".eaddslashes2($add[temptext])."');");
	$tempid=$empire->lastid();
	//����ģ��
	AddEBakTemp('indexpage',1,$tempid,$add[tempname],$add[temptext],0,0,'',0,0,'',0,0,0,$userid,$username);
	if($sql)
	{
		//������־
		insert_dolog("tempid=$tempid&tempname=$add[tempname]");
		printerror("AddIndexpageSuccess","AddIndexpage.php?enews=AddIndexpage&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸���ҳ����
function EditIndexpage($add,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	$tempid=(int)$add[tempid];
	if(!$tempid||!$add[tempname]||!$add[temptext])
	{
		printerror("EmptyIndexpageName","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$add[tempname]=hRepPostStr($add[tempname],1);
	$add[temptext]=RepPhpAspJspcode($add[temptext]);
	$sql=$empire->query("update {$dbtbpre}enewsindexpage set tempname='".$add[tempname]."',temptext='".eaddslashes2($add[temptext])."' where tempid='$tempid'");
	//����ģ��
	AddEBakTemp('indexpage',1,$tempid,$add[tempname],$add[temptext],0,0,'',0,0,'',0,0,0,$userid,$username);
	//ˢ����ҳ
	if($tempid==$public_r['indexpageid'])
	{
		NewsBq($classid,eaddslashes($add[temptext]),1,0);
		//ɾ����̬ģ�建���ļ�
		DelOneTempTmpfile('indexpage');
	}
	if($sql)
	{
		//������־
		insert_dolog("tempid=$tempid&tempname=$add[tempname]");
		printerror("EditIndexpageSuccess","ListIndexpage.php?gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ����ҳ����
function DelIndexpage($tempid,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	$tempid=(int)$tempid;
	if(empty($tempid))
	{
		printerror("NotChangeIndexpageid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$_GET['gid'];
	$r=$empire->fetch1("select tempname from {$dbtbpre}enewsindexpage where tempid='$tempid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsindexpage where tempid='$tempid'");
	if($tempid==$public_r['indexpageid'])
	{
		$empire->query("update {$dbtbpre}enewspublic set indexpageid=0");
		GetConfig();//���»���
	}
	//ɾ�����ݼ�¼
	DelEbakTempAll('indexpage',1,$tempid);
	//ˢ����ҳ
	if($tempid==$public_r['indexpageid'])
	{
		$indextempr=$empire->fetch1("select indextemp from ".GetTemptb("enewspubtemp")." limit 1");
		$indextemp=$indextempr['indextemp'];
		NewsBq($classid,$indextemp,1,0);
		//ɾ����̬ģ�建���ļ�
		DelOneTempTmpfile('indexpage');
	}
	if($sql)
	{
		//������־
		insert_dolog("tempid=$tempid&tempname=$r[tempname]");
		printerror("DelIndexpageSuccess","ListIndexpage.php?gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//������ҳ����
function DefIndexpage($tempid,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	$tempid=(int)$tempid;
	if(empty($tempid))
	{
		printerror("NotChangeIndexpageid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$_GET['gid'];
	$r=$empire->fetch1("select tempname,temptext from {$dbtbpre}enewsindexpage where tempid='$tempid'");
	if($tempid==$public_r['indexpageid'])
	{
		$def=0;
		$mess='NoDefIndexpageSuccess';
		$sql=$empire->query("update {$dbtbpre}enewspublic set indexpageid=0");
	}
	else
	{
		$def=1;
		$mess='DefIndexpageSuccess';
		$sql=$empire->query("update {$dbtbpre}enewspublic set indexpageid='$tempid'");
	}
	GetConfig();//���»���
	//ˢ����ҳ
	if($def)
	{
		NewsBq($classid,$r[temptext],1,0);
		//ɾ����̬ģ�建���ļ�
		DelOneTempTmpfile('indexpage');
	}
	else
	{
		$indextempr=$empire->fetch1("select indextemp from ".GetTemptb("enewspubtemp")." limit 1");
		$indextemp=$indextempr['indextemp'];
		NewsBq($classid,$indextemp,1,0);
		//ɾ����̬ģ�建���ļ�
		DelOneTempTmpfile('indexpage');
	}
	if($sql)
	{
		//������־
		insert_dolog("tempid=$tempid&tempname=$r[tempname]&def=$def");
		printerror($mess,"ListIndexpage.php?gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//����
$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include("../../class/t_functions.php");
	include("../../data/dbcache/class.php");
	include("../../data/dbcache/MemberLevel.php");
	include("../../class/tempfun.php");
}
//������ҳ����
if($enews=="AddIndexpage")
{
	AddIndexpage($_POST,$logininid,$loginin);
}
//�޸���ҳ����
elseif($enews=="EditIndexpage")
{
	EditIndexpage($_POST,$logininid,$loginin);
}
//ɾ����ҳ����
elseif($enews=="DelIndexpage")
{
	DelIndexpage($_GET['tempid'],$logininid,$loginin);
}
//������ҳ����
elseif($enews=="DefIndexpage")
{
	DefIndexpage($_GET['tempid'],$logininid,$loginin);
}

$gid=(int)$_GET['gid'];
$url="<a href=ListIndexpage.php?gid=$gid".$ecms_hashur['ehref'].">������ҳ����</a>";
$search="&gid=$gid".$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select tempid,tempname from {$dbtbpre}enewsindexpage";
$totalquery="select count(*) as total from {$dbtbpre}enewsindexpage";
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by tempid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������ҳ����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton"> 
        <input type="button" name="Submit5" value="������ҳ����" onclick="self.location.href='AddIndexpage.php?enews=AddIndexpage&gid=<?=$gid?><?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
  
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"><div align="center">ID</div></td>
    <td width="49%" height="25"><div align="center">��������</div></td>
    <td width="17%"><div align="center">����/ȡ��</div></td>
    <td width="29%" height="25"><div align="center">����</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  	//Ĭ�Ϸ���
	if($public_r['indexpageid']==$r['tempid'])
	{
		$bgcolor='#DBEAF5';
		$openindexpage='ȡ���˷���';
		$movejs='';
	}
	else
	{
		$bgcolor='#ffffff';
		$openindexpage='���ô˷���';
		$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
	}
  ?>
  <tr bgcolor="<?=$bgcolor?>"<?=$movejs?>> 
    <td height="25"><div align="center"> 
        <?=$r[tempid]?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[tempname]?>
      </div></td>
    <td><div align="center"> <a href="ListIndexpage.php?enews=DefIndexpage&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ������?');"><?=$openindexpage?></a></div></td>
    <td height="25"><div align="center"> [<a href="AddIndexpage.php?enews=EditIndexpage&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
        [<a href="AddIndexpage.php?enews=AddIndexpage&docopy=1&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>">����</a>] 
        [<a href="../ecmstemp.php?enews=PreviewIndexpage&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['href']?>" target="_blank">Ԥ��</a>] 
        [<a href="ListIndexpage.php?enews=DelIndexpage&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="ffffff"> 
    <td height="25" colspan="4">&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td height="25"><font color="#666666">˵������ҳ���������Խ�ĳһ������Ϊ��ʱ��ҳ���ر����ڽڼ��������ر���ҳ�ǳ����á�ȫ��ȡ��ʱΪʹ��Ĭ����ҳģ�塣</font></td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
