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
CheckLevel($logininid,$loginin,$classid,"madmingroup");

//���ӻ�Ա������
function AddMAdminGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add['agname']))
	{
		printerror('EmptyMAdminGroup','history.go(-1)');
	}
	$add['agname']=hRepPostStr($add['agname'],1);
	$add['isadmin']=(int)$add['isadmin'];
	$sql=$empire->query("insert into {$dbtbpre}enewsag(agname,isadmin,auids) values('$add[agname]','$add[isadmin]','');");
	if($sql)
	{
		$agid=$empire->lastid();
		//���»���
		GetConfig();
		GetMemberLevel();
		insert_dolog("agid=$agid&agname=$add[agname]");//������־
		printerror("AddMAdminGroupSuccess","AddMAdminGroup.php?enews=AddMAdminGroup".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸Ļ�Ա������
function EditMAdminGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	$agid=intval($add['agid']);
	if(empty($add['agname'])||!$agid)
	{
		printerror('EmptyMAdminGroup','history.go(-1)');
	}
	$add['agname']=hRepPostStr($add['agname'],1);
	$add['isadmin']=(int)$add['isadmin'];
	$addupdate='';
	if($agid==1||$agid==2)
	{
		$addupdate='';
	}
	else
	{
		$addupdate=",isadmin='$add[isadmin]'";
	}
	$sql=$empire->query("update {$dbtbpre}enewsag set agname='$add[agname]'".$addupdate." where agid='$agid'");
	//���»���
	GetConfig();
	GetMemberLevel();
	if($sql)
	{
		insert_dolog("agid=$agid&agname=$add[agname]");//������־
		printerror("EditMAdminGroupSuccess","ListMAdminGroup.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ����Ա������
function DelMAdminGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	$agid=intval($add['agid']);
	if(!$agid)
	{
		printerror('EmptyMAdminGroupid','history.go(-1)');
	}
	$r=$empire->fetch1("select agid,agname from {$dbtbpre}enewsag where agid='$agid'");
	if(!$r['agid'])
	{
		printerror('EmptyMAdminGroupid','history.go(-1)');
	}
	if($agid==1||$agid==2)
	{
		printerror('NotDelSysMAdminGroupid','history.go(-1)');
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsag where agid='$agid'");
	$empire->query("update ".eReturnMemberTable()." set ".egetmf('agid')."=0 where ".egetmf('agid')."='$agid'");
	//���»���
	GetConfig();
	GetMemberLevel();
	if($sql)
	{
		insert_dolog("agid=$gid&agname=$r[agname]");//������־
		printerror("DelMAdminGroupSuccess","ListMAdminGroup.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//���ӻ�Ա����Ա
function AddMAgUser($add,$userid,$username){
	global $empire,$dbtbpre;
	$agid=(int)$add['agid'];
	$adduserid=(int)$add['adduserid'];
	$addusername=RepPostVar($add['addusername']);
	if(!$agid||!$adduserid||!$addusername)
	{
		printerror("EmptyMAgUser","history.go(-1)");
	}
	$magr=$empire->fetch1("select * from {$dbtbpre}enewsag where agid='$agid'");
	if(!$magr['agid'])
	{
		printerror("EmptyMAgUser","history.go(-1)");
	}
	$mr=$empire->fetch1("select ".eReturnSelectMemberF('userid')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$adduserid' and ".egetmf('username')."='$addusername' limit 1");
	if(!$mr['userid'])
	{
		printerror("ErrorMAgUser","history.go(-1)");
	}
	//�Ƿ����
	if(strstr($magr['auids'],','.$adduserid.','))
	{
		printerror("HaveMAgUser","history.go(-1)");
	}
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsag where auids like '%,".$adduserid.",%' limit 1");
	if($num)
	{
		printerror("HaveMAgUser","history.go(-1)");
	}
	if($magr['auids'])
	{
		$new_auids=$magr['auids'].$adduserid.',';
	}
	else
	{
		$new_auids=','.$adduserid.',';
	}
	$sql=$empire->query("update {$dbtbpre}enewsag set auids='$new_auids' where agid='$agid' limit 1");
	$empire->query("update ".eReturnMemberTable()." set ".egetmf('agid')."='$agid' where ".egetmf('userid')."='$adduserid'");
	//���»���
	GetConfig();
	GetMemberLevel();
	if($sql)
	{
		//������־
		insert_dolog("agid=".$agid."<br>userid=".$adduserid."&username=".$addusername);
		printerror("AddMAgUserSuccess","ListMAgUser.php?agid=$agid".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ����Ա����Ա
function DelMAgUser($add,$userid,$username){
	global $empire,$dbtbpre;
	$agid=(int)$add['agid'];
	$adduserid=(int)$add['adduserid'];
	if(!$agid||!$adduserid)
	{
		printerror("EmptyMAgUser","history.go(-1)");
	}
	$magr=$empire->fetch1("select * from {$dbtbpre}enewsag where agid='$agid'");
	if(!$magr['agid'])
	{
		printerror("EmptyMAgUser","history.go(-1)");
	}
	$new_auids=str_replace(",".$adduserid.",",",",$magr['auids']);
	if($new_auids==',')
	{
		$new_auids='';
	}
	$sql=$empire->query("update {$dbtbpre}enewsag set auids='$new_auids' where agid='$agid' limit 1");
	$empire->query("update ".eReturnMemberTable()." set ".egetmf('agid')."=0 where ".egetmf('userid')."='$adduserid'");
	//���»���
	GetConfig();
	GetMemberLevel();
	if($sql)
	{
		//������־
		insert_dolog("agid=".$agid."<br>userid=".$adduserid);
		printerror("DelMAgUserSuccess","ListMAgUser.php?agid=$agid".hReturnEcmsHashStrHref2(0));
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
if($enews=="AddMAdminGroup")
{
	AddMAdminGroup($_POST,$logininid,$loginin);
}
elseif($enews=="EditMAdminGroup")
{
	EditMAdminGroup($_POST,$logininid,$loginin);
}
elseif($enews=="DelMAdminGroup")
{
	DelMAdminGroup($_GET,$logininid,$loginin);
}
elseif($enews=="AddMAgUser")
{
	AddMAgUser($_POST,$logininid,$loginin);
}
elseif($enews=="DelMAgUser")
{
	DelMAgUser($_GET,$logininid,$loginin);
}


$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=50;//ÿҳ��ʾ����
$page_line=25;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select * from {$dbtbpre}enewsag";
$totalquery="select count(*) as total from {$dbtbpre}enewsag";
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by agid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>��Ա������</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">λ�ã�<a href="ListMAdminGroup.php<?=$ecms_hashur['whehref']?>">�����Ա������</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="���ӻ�Ա������" onclick="self.location.href='AddMAdminGroup.php?enews=AddMAdminGroup<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>

<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"> <div align="center">ID</div></td>
    <td width="32%" height="25"> <div align="center">������</div></td>
    <td width="26%"><div align="center">������</div></td>
    <td width="21%"><div align="center">��Ա�б�</div></td>
    <td width="16%" height="25"> <div align="center">����</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  	$color="#ffffff";
	$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
	$membernum=0;
	if($r['auids'])
	{
		$mr=explode(",",$r['auids']);
		$membernum=count($mr)-2;
	}
	if($r['isadmin']==9)
	{
		$isadminname='����Ա';
	}
	elseif($r['isadmin']==5)
	{
		$isadminname='����';
	}
	elseif($r['isadmin']==1)
	{
		$isadminname='ʵϰ����';
	}
	else
	{
		$isadminname='';
	}
  ?>
  <tr bgcolor="<?=$color?>"<?=$movejs?>> 
    <td height="25"> <div align="center"> 
        <?=$r[agid]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[agname]?>
      </div></td>
    <td><div align="center"><?=$isadminname?></div></td>
    <td><div align="center"><a href="ListMAgUser.php?agid=<?=$r['agid']?><?=$ecms_hashur['ehref']?>" target="_blank">�����Ա�б� (<strong><?=$membernum?></strong>)</a></div></td>
    <td height="25"> <div align="center"> [<a href="AddMAdminGroup.php?enews=EditMAdminGroup&agid=<?=$r[agid]?><?=$ecms_hashur['ehref']?>">�޸�</a>]&nbsp;[<a href="ListMAdminGroup.php?enews=DelMAdminGroup&agid=<?=$r[agid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
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
