<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../data/dbcache/class.php");
require '../'.LoadLang('pub/fun.php');
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
CheckLevel($logininid,$loginin,$classid,"class");

//�����û���
function ReturnGoodTypeGroup($groupid){
	$count=count($groupid);
	if($count==0)
	{
		return '';
	}
	$ids=',';
	for($i=0;$i<$count;$i++)
	{
		$ids.=intval($groupid[$i]).',';
	}
	return $ids;
}

//�����ֶα���
function DoPostGoodTypeVar($add){
	$add['tname']=hRepPostStr($add['tname'],1);
	$add['ttype']=(int)$add['ttype'];
	$add['levelid']=(int)$add['levelid'];
	$add['myorder']=(int)$add['myorder'];
	$add['gids']=hRepPostStr(ReturnGoodTypeGroup($add['groupid']),1);
	$add['showall']=(int)$add['showall'];
	if($add['showcid'])
	{
		$add['showcid']=','.$add['showcid'].',';
	}
	$add['showcid']=hRepPostStr($add['showcid'],1);
	if($add['hiddencid'])
	{
		$add['hiddencid']=','.$add['hiddencid'].',';
	}
	$add['hiddencid']=hRepPostStr($add['hiddencid'],1);
	return $add;
}

//�����Ƽ�
function AddGoodType($add,$userid,$username){
	global $empire,$dbtbpre;
	$add=DoPostGoodTypeVar($add);
	if(!$add['tname']||!$add['levelid']||$add['levelid']<1||$add['levelid']>255)
	{
		printerror("EmptyGoodTypeName","history.go(-1)");
    }
	CheckLevel($userid,$username,$classid,"class");
	//�ظ�
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsgoodtype where levelid='$add[levelid]' and ttype='$add[ttype]' limit 1");
	if($num)
	{
		printerror("ReGoodTypeLevelid","history.go(-1)");
	}
	$sql=$empire->query("insert into {$dbtbpre}enewsgoodtype(tname,ttype,levelid,myorder,groupid,showall,showcid,hiddencid) values('$add[tname]','$add[ttype]','$add[levelid]','$add[myorder]','$add[gids]','$add[showall]','$add[showcid]','$add[hiddencid]');");
	$tid=$empire->lastid();
	if($sql)
	{
		//������־
	    insert_dolog("ttype=".$add[ttype]."<br>tid=".$tid."<br>tname=".$add[tname]);
		printerror("AddGoodTypeSuccess","ListGoodType.php?ttype=$add[ttype]".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸��Ƽ�
function EditGoodType($add,$userid,$username){
	global $empire,$dbtbpre;
	$add=DoPostGoodTypeVar($add);
	$tid=(int)$add['tid'];
	if(!$tid||!$add['tname']||!$add['levelid']||$add['levelid']<1||$add['levelid']>255)
	{
		printerror("EmptyGoodTypeName","history.go(-1)");
    }
	CheckLevel($userid,$username,$classid,"class");
	//�ظ�
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsgoodtype where levelid='$add[levelid]' and ttype='$add[ttype]' and tid<>".$tid." limit 1");
	if($num)
	{
		printerror("ReGoodTypeLevelid","history.go(-1)");
	}
	//�޸�
	$sql=$empire->query("update {$dbtbpre}enewsgoodtype set tname='$add[tname]',ttype='$add[ttype]',levelid='$add[levelid]',myorder='$add[myorder]',groupid='$add[gids]',showall='$add[showall]',showcid='$add[showcid]',hiddencid='$add[hiddencid]' where tid='$tid'");
	if($sql)
	{
		insert_dolog("ttype=".$add[ttype]."<br>tid=".$tid."<br>tname=".$add[tname]);//������־
		printerror("EditGoodTypeSuccess","ListGoodType.php?ttype=$add[ttype]".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","");
	}
}

//ɾ���Ƽ�
function DelGoodType($add,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$add['tid'];
	if(!$tid)
	{
		printerror("NotDelGoodTid","");
	}
	CheckLevel($userid,$username,$classid,"class");
	$r=$empire->fetch1("select * from {$dbtbpre}enewsgoodtype where tid='$tid'");
	if(empty($r[tid]))
	{
		printerror("NotDelGoodTid","history.go(-1)");
	}
	//ɾ��
	$sql=$empire->query("delete from {$dbtbpre}enewsgoodtype where tid='$tid'");
	if($sql)
	{
		insert_dolog("ttype=".$add[ttype]."<br>tid=".$tid."<br>tname=".$r[tname]);//������־
		printerror("DelGoodTypeSuccess","ListGoodType.php?ttype=$add[ttype]".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","");
	}
}


$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=="AddGoodType")//����
{
	AddGoodType($_POST,$logininid,$loginin);
}
elseif($enews=="EditGoodType")//�޸�
{
	EditGoodType($_POST,$logininid,$loginin);
}
elseif($enews=="DelGoodType")//ɾ��
{
	DelGoodType($_GET,$logininid,$loginin);
}


$ttype=(int)$_GET['ttype'];
$ttypetitle=$ttype==0?'�Ƽ�':'ͷ��';
$search='&ttype='.$ttype;
$search.=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=50;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select tid,tname,ttype,levelid from {$dbtbpre}enewsgoodtype where ttype='$ttype'";
$totalquery="select count(*) as total from {$dbtbpre}enewsgoodtype where ttype='$ttype'";
$add='';
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by myorder desc,levelid limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$ttypetitle?>����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="69%" height="25">λ�ã�<a href="ListGoodType.php?ttype=<?=$ttype?><?=$ecms_hashur['ehref']?>">����<?=$ttypetitle?>����</a> </td>
    <td width="31%"><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="����<?=$ttypetitle?>����" onclick="self.location.href='AddGoodType.php?enews=AddGoodType&ttype=<?=$ttype?><?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="700" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="goodtypeform" method="post" action="ListGoodType.php" onsubmit="return confirm('ȷ��Ҫ�ύ?');">
    <input name="ttype" type="hidden" id="ttype" value="<?=$ttype?>">
    <tr class="header"> 
      <td width="24%" height="25"><div align="center"><?=$ttypetitle?>����</div></td>
      <td width="47%"><div align="center">��������</div></td>
      <td width="29%" height="25"><div align="center">����</div></td>
    </tr>
    <?php
  while($r=$empire->fetch($sql))
  {
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <div align="center"> 
          <?=$r['levelid']?>
          </div></td>
      <td><div align="center"> 
          <?=$r['tname']?>
          </div></td>
      <td height="25"><div align="center">[<a href="AddGoodType.php?enews=EditGoodType&tid=<?=$r[tid]?>&ttype=<?=$ttype?><?=$ecms_hashur['ehref']?>">�޸�</a>]  
        [<a href="AddGoodType.php?enews=AddGoodType&tid=<?=$r[tid]?>&ttype=<?=$ttype?>&docopy=1<?=$ecms_hashur['ehref']?>">����</a>] [<a href="ListGoodType.php?enews=DelGoodType&tid=<?=$r[tid]?>&ttype=<?=$ttype?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
    </tr>
    <?
  }
  ?>
    
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="3"> 
        <?=$returnpage?>      </td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>