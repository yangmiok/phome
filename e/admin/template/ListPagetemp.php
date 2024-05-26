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

//�����Զ���ҳ��ģ��
function AddPagetemp($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[tempname]||!$add[temptext])
	{
		printerror("EmptyPagetempname","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$add[tempname]=hRepPostStr($add[tempname],1);
	$add[temptext]=RepPhpAspJspcode($add[temptext]);
	$sql=$empire->query("insert into ".GetDoTemptb("enewspagetemp",$gid)."(tempname,temptext) values('$add[tempname]','".eaddslashes2($add[temptext])."');");
	$tempid=$empire->lastid();
	//����ģ��
	AddEBakTemp('pagetemp',$gid,$tempid,$add[tempname],$add[temptext],0,0,'',0,0,'',0,0,0,$userid,$username);
	if($sql)
	{
		//������־
		insert_dolog("tempid=$tempid&tempname=$add[tempname]&gid=$gid");
		printerror("AddPagetempSuccess","AddPagetemp.php?enews=AddPagetemp&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸��Զ���ҳ��ģ��
function EditPagetemp($add,$userid,$username){
	global $empire,$dbtbpre;
	$tempid=(int)$add['tempid'];
	if(!$tempid||!$add[tempname]||!$add[temptext])
	{
		printerror("EmptyPagetempname","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$add[tempname]=hRepPostStr($add[tempname],1);
	$add[temptext]=RepPhpAspJspcode($add[temptext]);
	$sql=$empire->query("update ".GetDoTemptb("enewspagetemp",$gid)." set tempname='$add[tempname]',temptext='".eaddslashes2($add[temptext])."' where tempid='$tempid'");
	//����ģ��
	AddEBakTemp('pagetemp',$gid,$tempid,$add[tempname],$add[temptext],0,0,'',0,0,'',0,0,0,$userid,$username);
	if($sql)
	{
		//������־
		insert_dolog("tempid=$tempid&tempname=$add[tempname]&gid=$gid");
		printerror("EditPagetempSuccess","ListPagetemp.php?gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ���Զ���ҳ��ģ��
function DelPagetemp($add,$userid,$username){
	global $empire,$dbtbpre;
	$tempid=(int)$add['tempid'];
	if(!$tempid)
	{
		printerror("EmptyPagetempid","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$r=$empire->fetch1("select tempname from ".GetDoTemptb("enewspagetemp",$gid)." where tempid='$tempid'");
	$sql=$empire->query("delete from ".GetDoTemptb("enewspagetemp",$gid)." where tempid='$tempid'");
	//ɾ�����ݼ�¼
	DelEbakTempAll('pagetemp',$gid,$tempid);
	if($sql)
	{
		//������־
		insert_dolog("tempid=$tempid&tempname=$r[tempname]&gid=$gid");
		printerror("DelPagetempSuccess","ListPagetemp.php?gid=$gid".hReturnEcmsHashStrHref2(0));
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
	include("../../class/tempfun.php");
}
//����ģ��
if($enews=="AddPagetemp")
{
	AddPagetemp($_POST,$logininid,$loginin);
}
//�޸�ģ��
elseif($enews=="EditPagetemp")
{
	EditPagetemp($_POST,$logininid,$loginin);
}
//ɾ��ģ��
elseif($enews=="DelPagetemp")
{
	DelPagetemp($_GET,$logininid,$loginin);
}
else
{}
$gid=(int)$_GET['gid'];
$gname=CheckTempGroup($gid);
$urlgname=$gname."&nbsp;>&nbsp;";
$url=$urlgname."<a href=ListPagetemp.php?gid=$gid".$ecms_hashur['ehref'].">�����Զ���ҳ��ģ��</a>";
$search="&gid=$gid".$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select tempid,tempname from ".GetDoTemptb("enewspagetemp",$gid);
$totalquery="select count(*) as total from ".GetDoTemptb("enewspagetemp",$gid);
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by tempid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����Զ���ҳ��ģ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="�����Զ���ҳ��ģ��" onclick="self.location.href='AddPagetemp.php?enews=AddPagetemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="10%" height="25"><div align="center">ID</div></td>
    <td width="61%" height="25"><div align="center">ģ����</div></td>
    <td width="29%" height="25"><div align="center">����</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#ffffff" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"> 
        <a href="EditTempid.php?tempno=12&tempid=<?=$r['tempid']?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>" target="_blank" title="�޸�ģ��ID"><?=$r[tempid]?></a>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[tempname]?>
      </div></td>
    <td height="25"><div align="center"> [<a href="AddPagetemp.php?enews=EditPagetemp&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
        [<a href="AddPagetemp.php?enews=AddPagetemp&docopy=1&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>">����</a>] 
        [<a href="ListPagetemp.php?enews=DelPagetemp&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="ffffff"> 
    <td height="25" colspan="3">&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>
