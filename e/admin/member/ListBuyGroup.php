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
CheckLevel($logininid,$loginin,$classid,"buygroup");

//��ֵ����
function ReturnBuyGroupVar($add){
	$add[gmoney]=(int)$add[gmoney];
	$add[gfen]=(int)$add[gfen];
	$add[gdate]=(int)$add[gdate];
	$add[ggroupid]=(int)$add[ggroupid];
	$add[gzgroupid]=(int)$add[gzgroupid];
	$add[buygroupid]=(int)$add[buygroupid];
	$add[myorder]=(int)$add[myorder];
	$add['gname']=hRepPostStr($add['gname'],1);
	$add['gsay']=hRepPostStr2($add['gsay']);
	return $add;
}

//���ӳ�ֵ����
function AddBuyGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"buygroup");
	$add=ReturnBuyGroupVar($add);
	if(!$add[gname]||!$add[gmoney])
	{
		printerror('EmptyBuyGroup','history.go(-1)');
	}
	$sql=$empire->query("insert into {$dbtbpre}enewsbuygroup(gname,gmoney,gfen,gdate,ggroupid,gzgroupid,buygroupid,gsay,myorder) values('$add[gname]','$add[gmoney]','$add[gfen]','$add[gdate]','$add[ggroupid]','$add[gzgroupid]','$add[buygroupid]','$add[gsay]','$add[myorder]');");
	$id=$empire->lastid();
	if($sql)
	{
		//������־
	    insert_dolog("id=$id&gname=$add[gname]&gfen=$add[gfen]&gdate=$add[gdate]");
		printerror('AddBuyGroupSuccess','AddBuyGroup.php?enews=AddBuyGroup'.hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror('DbError','');
	}
}

//�޸ĳ�ֵ����
function EditBuyGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"buygroup");
	$id=(int)$add['id'];
	$add=ReturnBuyGroupVar($add);
	if(!$id||!$add[gname]||!$add[gmoney])
	{
		printerror('EmptyBuyGroup','history.go(-1)');
	}
	$sql=$empire->query("update {$dbtbpre}enewsbuygroup set gname='$add[gname]',gmoney='$add[gmoney]',gfen='$add[gfen]',gdate='$add[gdate]',ggroupid='$add[ggroupid]',gzgroupid='$add[gzgroupid]',buygroupid='$add[buygroupid]',gsay='$add[gsay]',myorder='$add[myorder]' where id='$id'");
	if($sql)
	{
		//������־
	    insert_dolog("id=$id&gname=$add[gname]&gfen=$add[gfen]&gdate=$add[gdate]");
		printerror('EditBuyGroupSuccess','ListBuyGroup.php'.hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror('DbError','');
	}
}

//ɾ����ֵ����
function DelBuyGroup($id,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"buygroup");
	$id=(int)$id;
	if(!$id)
	{
		printerror('EmptyBuyGroupid','');
	}
	$r=$empire->fetch1("select id,gname,gfen,gdate from {$dbtbpre}enewsbuygroup where id='$id'");
	if(!$r[id])
	{
		printerror('EmptyBuyGroupid','');
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsbuygroup where id='$id'");
	if($sql)
	{
		//������־
	    insert_dolog("id=$id&gname=$r[gname]&gfen=$r[gfen]&gdate=$r[gdate]");
		printerror('DelBuyGroupSuccess','ListBuyGroup.php'.hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror('DbError','');
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=='AddBuyGroup')//���ӳ�ֵ����
{
	AddBuyGroup($_POST,$logininid,$loginin);
}
elseif($enews=='EditBuyGroup')//�޸ĳ�ֵ����
{
	EditBuyGroup($_POST,$logininid,$loginin);
}
elseif($enews=='DelBuyGroup')//ɾ����ֵ����
{
	DelBuyGroup($_GET['id'],$logininid,$loginin);
}

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;
$page_line=25;
$offset=$line*$page;
$totalquery="select count(*) as total from {$dbtbpre}enewsbuygroup";
$num=$empire->gettotal($totalquery);
$query="select id,gname,gmoney,gfen,gdate from {$dbtbpre}enewsbuygroup";
$query.=" order by myorder,id limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����ֵ����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã�<a href="ListBuyGroup.php<?=$ecms_hashur['whehref']?>">�����ֵ����</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="���ӳ�ֵ����" onclick="self.location.href='AddBuyGroup.php?enews=AddBuyGroup<?=$ecms_hashur['ehref']?>';">
        </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%" height="25"> <div align="center">ID</div></td>
    <td width="41%" height="25"> <div align="center">��������</div></td>
    <td width="15%" height="25"> <div align="center">���(Ԫ)</div></td>
    <td width="11%" height="25"> <div align="center">����</div></td>
    <td width="11%"><div align="center">��Ч��(��)</div></td>
    <td width="16%" height="25"> <div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r[id]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[gname]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[gmoney]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[gfen]?>
      </div></td>
    <td><div align="center">
        <?=$r[gdate]?>
      </div></td>
    <td height="25"> <div align="center">[<a href="AddBuyGroup.php?enews=EditBuyGroup&id=<?=$r[id]?><?=$ecms_hashur['ehref']?>">�޸�</a>]��[<a href="ListBuyGroup.php?enews=DelBuyGroup&id=<?=$r[id]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="6"> &nbsp;&nbsp; 
      <?=$returnpage?>
      <div align="left"></div></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25" colspan="6">ǰ̨��ֵ��ַ��<a href="<?=$public_r[newsurl].'e/member/buygroup/'?>" target="_blank"><?=$public_r[newsurl].'e/member/buygroup/'?></a></td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>