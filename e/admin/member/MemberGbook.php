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
CheckLevel($logininid,$loginin,$classid,"spacedata");

//ɾ������
function hDelMemberGbook($add,$userid,$username){
	global $empire,$dbtbpre;
	$gid=intval($add['gid']);
	if(!$gid)
	{
		printerror("NotDelMemberGbookid","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsmembergbook where gid='$gid'");
	if($sql)
	{
		//������־
		insert_dolog("gid=".$gid);
		printerror("DelMemberGbookSuccess",EcmsGetReturnUrl());
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//����ɾ������
function hDelMemberGbook_All($add,$userid,$username){
	global $empire,$dbtbpre;
	$gid=$add['gid'];
	$count=count($gid);
	if(empty($count))
	{
		printerror("NotDelMemberGbookid","history.go(-1)");
	}
	for($i=0;$i<$count;$i++)
	{
		$addsql.="gid='".intval($gid[$i])."' or ";
    }
	$addsql=substr($addsql,0,strlen($addsql)-4);
	$sql=$empire->query("delete from {$dbtbpre}enewsmembergbook where (".$addsql.")");
	if($sql)
	{
		//������־
		insert_dolog("");
		printerror("DelMemberGbookSuccess",EcmsGetReturnUrl());
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

$enews=$_GET['enews'];
if(empty($enews))
{$enews=$_POST['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=="hDelMemberGbook")
{
	hDelMemberGbook($_GET,$logininid,$loginin);
}
elseif($enews=="hDelMemberGbook_All")
{
	hDelMemberGbook_All($_POST,$logininid,$loginin);
}
include("../../member/class/user.php");
include "../".LoadLang("pub/fun.php");
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=12;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
//����
$search='';
$search.=$ecms_hashur['ehref'];
$and='';
if($_GET['sear'])
{
	$keyboard=RepPostVar2($_GET['keyboard']);
	if($keyboard)
	{
		$show=RepPostStr($_GET['show'],1);
		if($show==1)//��������
		{
			$and.=" where gbtext like '%$keyboard%'";	
		}
		elseif($show==2)//�ظ�����
		{
			$and.=" where retext like '%$keyboard%'";
		}
		elseif($show==3)//������
		{
			$and.=" where uname like '%$keyboard%'";
		}
		elseif($show==4)//�ռ������û�ID
		{
			$and.=" where userid='$keyboard'";
		}
		elseif($show==5)//������IP
		{
			$and.=" where ip like '%$keyboard%'";
		}
		$search.="&sear=1&keyboard=$keyboard&show=$show";
	}
}
$query="select gid,isprivate,uid,uname,ip,addtime,gbtext,retext,userid,eipport from {$dbtbpre}enewsmembergbook".$and;
$totalquery="select count(*) as total from {$dbtbpre}enewsmembergbook".$and;
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by gid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$url="��Ա�ռ�&nbsp;>&nbsp;<a href=MemberGbook.php".$ecms_hashur['whehref'].">��������</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���Թ���</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ��: 
      <?=$url?>
    </td>
    <td><div align="right"> </div></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="searchgb" method="get" action="MemberGbook.php">
<?=$ecms_hashur['eform']?>
  <tr>
    <td><div align="center">������
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="show" id="show">
            <option value="1"<?=$show==1?' selected':''?>>��������</option>
			<option value="2"<?=$show==2?' selected':''?>>�ظ�����</option>
            <option value="3"<?=$show==3?' selected':''?>>������</option>
            <option value="4"<?=$show==4?' selected':''?>>�ռ������û�ID</option>
            <option value="5"<?=$show==5?' selected':''?>>������IP</option>
          </select>
          <input type="submit" name="Submit" value="����">
          <input name="sear" type="hidden" id="sear" value="1">
        </div></td>
  </tr>
</form>
</table>
<form name=thisform method=post action=MemberGbook.php onsubmit="return confirm('ȷ��Ҫִ�в���?');">
<?=$ecms_hashur['form']?>
<?
while($r=$empire->fetch($sql))
{
	$ur=$empire->fetch1("select ".egetmf('username')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$r[userid]'");
	if($r['uid'])
	{
		$r['uname']="<b><a href='../../space/?userid=$r[uid]' target='_blank'>$r[uname]</a></b>";
	}
	$username=$ur['username'];
	$private='';
	if($r['isprivate'])
	{
		$private='<b>[���Ļ�]</b>';
	}
?>
  <table width="700" border="0" align="center" cellpadding="3" cellspacing="1" class=tableborder>
    <tr class=header> 
      <td width="55%" height="23">������: 
        <?=$r[uname]?>
        </td>  
      <td width="45%">����ʱ��: 
        <?=$r[addtime]?>&nbsp;
        (IP: <?=$r[ip]?>:<?=$r[eipport]?>) </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="23" colspan="2"> <table border=0 width='100%' cellspacing=1 cellpadding=10 bgcolor='#cccccc'>
        <tr> 
          <td width='100%' bgcolor='#FFFFFF' style='word-break:break-all'> 
            <?=$private.nl2br($r[gbtext])?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" style='word-break:break-all'>
        <tr> 
          <td><img src="../../data/images/regb.gif" width="18" height="18"><strong><font color="#FF0000">�ظ�:</font></strong> 
            <?=nl2br($r[retext])?>
          </td>
        </tr>
      </table> 
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><div align="right">
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
              <td width="55%"><strong>�ռ�����: <a href="MemberGbook.php?sear=1&show=4&keyboard=<?=$r[userid]?><?=$ecms_hashur['ehref']?>"> 
                <?=$username?>
                </a> </strong></td>
              <td width="45%"> 
                <div align="left"><strong>����:</strong>&nbsp;[<a href="MemberGbook.php?enews=hDelMemberGbook&gid=<?=$r[gid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>] 
                  <input name="gid[]" type="checkbox" value="<?=$r[gid]?>">
                </div></td>
          </tr>
        </table>
        </div></td>
  </tr>
</table>
<br>
<?
}
?>
  <table width="700" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr> 
      <td>��ҳ: 
        <?=$returnpage?>
        &nbsp;&nbsp; 
        <input type="submit" name="Submit2" value="����ɾ��" onClick="document.thisform.enews.value='hDelMemberGbook_All';">
        <input name="enews" type="hidden" id="enews" value="hDelMemberGbook_All">
      </td>
  </tr>
</table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
