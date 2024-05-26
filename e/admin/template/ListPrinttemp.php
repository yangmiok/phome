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

//���Ӵ�ӡģ��
function AddPrintTemp($add,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	if(!$add[tempname]||!$add[temptext])
	{
		printerror("EmptyPrintTemp","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$add[tempname]=hRepPostStr($add[tempname],1);
	$add[temptext]=RepPhpAspJspcode($add[temptext]);
	$add[modid]=(int)$add[modid];
	$gid=(int)$add['gid'];
	$sql=$empire->query("insert into ".GetDoTemptb("enewsprinttemp",$gid)."(tempname,temptext,isdefault,showdate,modid) values('".$add[tempname]."','".eaddslashes2($add[temptext])."',0,'".eaddslashes($add[showdate])."','$add[modid]');");
	$tempid=$empire->lastid();
	//����ģ��
	AddEBakTemp('printtemp',$gid,$tempid,$add[tempname],$add[temptext],0,0,'',0,$add[modid],$add[showdate],0,0,0,$userid,$username);
	//����ҳ��
	if($gid==$public_r['deftempid']||(!$public_r['deftempid']&&($gid==1||$gid==0)))
	{
		GetPrintPage($tempid);
	}
	if($sql)
	{
		//������־
		insert_dolog("tempid=$tempid&tempname=$add[tempname]&gid=$gid");
		printerror("AddPrintTempSuccess","AddPrinttemp.php?enews=AddPrintTemp&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸Ĵ�ӡģ��
function EditPrintTemp($add,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	$tempid=(int)$add[tempid];
	if(!$tempid||!$add[tempname]||!$add[temptext])
	{
		printerror("EmptyPrintTemp","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$add[tempname]=hRepPostStr($add[tempname],1);
	$add[temptext]=RepPhpAspJspcode($add[temptext]);
	$add[modid]=(int)$add[modid];
	$gid=(int)$add['gid'];
	$sql=$empire->query("update ".GetDoTemptb("enewsprinttemp",$gid)." set tempname='".$add[tempname]."',temptext='".eaddslashes2($add[temptext])."',showdate='".eaddslashes($add[showdate])."',modid='$add[modid]' where tempid='$tempid'");
	//����ģ��
	AddEBakTemp('printtemp',$gid,$tempid,$add[tempname],$add[temptext],0,0,'',0,$add[modid],$add[showdate],0,0,0,$userid,$username);
	//����ҳ��
	if($gid==$public_r['deftempid']||(!$public_r['deftempid']&&($gid==1||$gid==0)))
	{
		GetPrintPage($tempid);
	}
	if($sql)
	{
		//������־
		insert_dolog("tempid=$tempid&tempname=$add[tempname]&gid=$gid");
		printerror("EditPrintTempSuccess","ListPrinttemp.php?gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ����ӡģ��
function DelPrintTemp($add,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	$tempid=(int)$add[tempid];
	if(empty($tempid))
	{
		printerror("NotChangePrintTempid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$r=$empire->fetch1("select tempname,isdefault from ".GetDoTemptb("enewsprinttemp",$gid)." where tempid=$tempid");
	if($r['isdefault'])
	{
		printerror("NotDelDefPrintTempid","history.go(-1)");
	}
	$sql=$empire->query("delete from ".GetDoTemptb("enewsprinttemp",$gid)." where tempid=$tempid");
	if($gid==$public_r['deftempid']||(!$public_r['deftempid']&&($gid==1||$gid==0)))
	{
		DelFiletext(ECMS_PATH.'e/data/filecache/template/print'.$tempid.'.php');
	}
	//ɾ�����ݼ�¼
	DelEbakTempAll('printtemp',$gid,$tempid);
	if($sql)
	{
		//������־
		insert_dolog("tempid=$tempid&tempname=$r[tempname]&gid=$gid");
		printerror("DelPrintTempSuccess","ListPrinttemp.php?gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//��ΪĬ�ϴ�ӡģ��
function DefPrintTemp($add,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	$tempid=(int)$add[tempid];
	if(!$tempid)
	{
		printerror("NotChangePrintTempid","history.go(-1)");
	}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewsprinttemp",$gid)." where tempid='$tempid'");
	$usql=$empire->query("update ".GetDoTemptb("enewsprinttemp",$gid)." set isdefault=0");
	$sql=$empire->query("update ".GetDoTemptb("enewsprinttemp",$gid)." set isdefault=1 where tempid='$tempid'");
	if($gid==$public_r['deftempid']||(!$public_r['deftempid']&&($gid==1||$gid==0)))
	{
		$empire->query("update {$dbtbpre}enewspublic set defprinttempid='$tempid' limit 1");
		GetConfig();//���»���
	}
	if($sql)
	{
		//������־
		insert_dolog("tempid=".$tempid."<br>tempname=".$tr[tempname]."&gid=$gid");
		printerror("DefPrintTempSuccess","ListPrinttemp.php?gid=$gid".hReturnEcmsHashStrHref2(0));
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
if($enews=="AddPrintTemp")//���Ӵ�ӡģ��
{
	AddPrintTemp($_POST,$logininid,$loginin);
}
elseif($enews=="EditPrintTemp")//�޸Ĵ�ӡģ��
{
	EditPrintTemp($_POST,$logininid,$loginin);
}
elseif($enews=="DelPrintTemp")//ɾ����ӡģ��
{
	DelPrintTemp($_GET,$logininid,$loginin);
}
elseif($enews=="DefPrintTemp")//Ĭ�ϴ�ӡģ��
{
	DefPrintTemp($_GET,$logininid,$loginin);
}

$gid=(int)$_GET['gid'];
$gname=CheckTempGroup($gid);
$urlgname=$gname."&nbsp;>&nbsp;";
$url=$urlgname."<a href=ListPrinttemp.php?gid=$gid".$ecms_hashur['ehref'].">�����ӡģ��</a>";
$search="&gid=$gid".$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select tempid,tempname,isdefault from ".GetDoTemptb("enewsprinttemp",$gid);
$totalquery="select count(*) as total from ".GetDoTemptb("enewsprinttemp",$gid);
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by tempid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����ӡģ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton"> 
        <input type="button" name="Submit5" value="���Ӵ�ӡģ��" onclick="self.location.href='AddPrinttemp.php?enews=AddPrintTemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>';">
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
  <?
  while($r=$empire->fetch($sql))
  {
  	$color="#ffffff";
	$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
  	if($r[isdefault])
  	{
  		$color="#DBEAF5";
		$movejs='';
  	}
  ?>
  <tr bgcolor="<?=$color?>"<?=$movejs?>> 
    <td height="25"><div align="center"> 
        <a href="EditTempid.php?tempno=11&tempid=<?=$r['tempid']?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>" target="_blank" title="�޸�ģ��ID"><?=$r[tempid]?></a>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[tempname]?>
      </div></td>
    <td height="25"><div align="center"> [<a href="AddPrinttemp.php?enews=EditPrintTemp&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
        [<a href="AddPrinttemp.php?enews=AddPrintTemp&docopy=1&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>">����</a>] 
        [<a href="ListPrinttemp.php?enews=DefPrintTemp&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��ҪĬ�ϣ�');">��ΪĬ��</a>] 
        [<a href="ListPrinttemp.php?enews=DelPrintTemp&tempid=<?=$r[tempid]?>&gid=<?=$gid?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
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
<?
db_close();
$empire=null;
?>
