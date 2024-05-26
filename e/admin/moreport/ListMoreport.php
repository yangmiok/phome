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
CheckLevel($logininid,$loginin,$classid,"moreport");

//�Ƿ�����
if($ecms_config['sets']['selfmoreportid']>1)
{
	printerror2('����������ʹ�ñ�����','history.go(-1)',9);
}

//���ӷ��ʶ�
function AddMoreport($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[pname]||!$add[ppath]||!$add[purl]||!$add[postpass]||!$add[tempgid])
	{
		printerror("EmptyMoreport","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"moreport");
	$add['pname']=hRepPostStr($add['pname'],1);
	$add['purl']=RepPostStr($add['purl'],1);
	$add['ppath']=RepPostStr($add['ppath'],1);
	$add['postpass']=RepPostStr($add['postpass'],1);
	$add['postfile']=RepPostStr($add['postfile'],1);
	$add['tempgid']=(int)$add['tempgid'];
	$add['mustdt']=(int)$add['mustdt'];
	$add['isclose']=(int)$add['isclose'];
	$add['closeadd']=(int)$add['closeadd'];
	$add['headersign']=hRepPostStr($add['headersign'],1);
	$add['openadmin']=(int)$add['openadmin'];
	$add['rehtml']=(int)$add['rehtml'];
	if(!file_exists($add['ppath'].'e/config/config.php'))
	{
		printerror("ErrorMoreportPath","history.go(-1)");
	}
	$sql=$empire->query("insert into {$dbtbpre}enewsmoreport(pname,purl,ppath,postpass,postfile,tempgid,mustdt,isclose,closeadd,headersign,openadmin,rehtml) values('$add[pname]','$add[purl]','$add[ppath]','$add[postpass]','$add[postfile]','$add[tempgid]','$add[mustdt]','$add[isclose]','$add[closeadd]','$add[headersign]','$add[openadmin]','$add[rehtml]');");
	$pid=$empire->lastid();
	//���»���
	Moreport_UpdateIsclose();
	GetConfig();
	if($sql)
	{
		//������־
	    insert_dolog("pid=$pid&pname=$add[pname]");
		printerror("AddMoreportSuccess","AddMoreport.php?enews=AddMoreport".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸ķ��ʶ�
function EditMoreport($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[pid]=(int)$add[pid];
	if(!$add[pid]||!$add[pname]||!$add[ppath]||!$add[purl]||!$add[postpass]||!$add[tempgid])
	{
		printerror("EmptyMoreport","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"moreport");
	$add['pname']=hRepPostStr($add['pname'],1);
	$add['purl']=RepPostStr($add['purl'],1);
	$add['ppath']=RepPostStr($add['ppath'],1);
	$add['postpass']=RepPostStr($add['postpass'],1);
	$add['postfile']=RepPostStr($add['postfile'],1);
	$add['tempgid']=(int)$add['tempgid'];
	$add['mustdt']=(int)$add['mustdt'];
	$add['isclose']=(int)$add['isclose'];
	$add['closeadd']=(int)$add['closeadd'];
	$add['headersign']=hRepPostStr($add['headersign'],1);
	$add['openadmin']=(int)$add['openadmin'];
	$add['rehtml']=(int)$add['rehtml'];
	if(!file_exists($add['ppath'].'e/config/config.php'))
	{
		printerror("ErrorMoreportPath","history.go(-1)");
	}
	$sql=$empire->query("update {$dbtbpre}enewsmoreport set pname='$add[pname]',purl='$add[purl]',ppath='$add[ppath]',postpass='$add[postpass]',postfile='$add[postfile]',tempgid='$add[tempgid]',mustdt='$add[mustdt]',isclose='$add[isclose]',closeadd='$add[closeadd]',headersign='$add[headersign]',openadmin='$add[openadmin]',rehtml='$add[rehtml]' where pid='$add[pid]'");
	//���»���
	Moreport_UpdateIsclose();
	GetConfig();
	if($sql)
	{
		//������־
	    insert_dolog("pid=$add[pid]&pname=$add[pname]");
		printerror("EditMoreportSuccess","ListMoreport.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ�����ʶ�
function DelMoreport($add,$userid,$username){
	global $empire,$dbtbpre;
	$pid=(int)$add['pid'];
	if(!$pid)
	{
		printerror("NotChangeMoreportId","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"moreport");
	$r=$empire->fetch1("select pname from {$dbtbpre}enewsmoreport where pid='$pid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsmoreport where pid='$pid'");
	//���»���
	Moreport_UpdateIsclose();
	GetConfig();
	if($sql)
	{
		//������־
		insert_dolog("pid=$pid&pname=$r[pname]");
		printerror("DelMoreportSuccess","ListMoreport.php".hReturnEcmsHashStrHref2(1));
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
	@set_time_limit(0);
	include('../../class/copypath.php');
	include('moreportfun.php');
}
//���ӷ��ʶ�
if($enews=="AddMoreport")
{
	AddMoreport($_POST,$logininid,$loginin);
}
elseif($enews=="EditMoreport")//�޸ķ��ʶ�
{
	EditMoreport($_POST,$logininid,$loginin);
}
elseif($enews=="DelMoreport")//ɾ�����ʶ�
{
	DelMoreport($_GET,$logininid,$loginin);
}
elseif($enews=="MoreportChangeCacheAll")//���·��ʶ����ݿ⻺��
{
	Moreport_ChangeCacheAll($_GET,$logininid,$loginin);
}
elseif($enews=="MoreportUpdateClassfileAll")//���·��ʶ���Ŀ�����ļ�
{
	Moreport_UpdateClassfileAll($_GET,$logininid,$loginin);
}
elseif($enews=="MoreportReDtPageAll")//���·��ʶ˶�̬ҳ��
{
	Moreport_ReDtPageAll($_GET,$logininid,$loginin);
}
elseif($enews=="MoreportClearTmpfileAll")//������ʶ���ʱ�ļ�
{
	Moreport_ClearTmpfileAll($_GET,$logininid,$loginin);
}
elseif($enews=="MoreportReIndexfileAll")//���·��ʶ˶�̬��ҳ�ļ�
{
	Moreport_ReIndexfileAll($_GET,$logininid,$loginin);
}

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=30;
$page_line=25;
$add="";
$offset=$line*$page;
$totalquery="select count(*) as total from {$dbtbpre}enewsmoreport";
$num=$empire->gettotal($totalquery);
$query="select * from {$dbtbpre}enewsmoreport";
$query.=" order by pid limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������վ���ʶ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã�<a href="ListMoreport.php<?=$ecms_hashur['whehref']?>">������վ���ʶ�</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="���ӷ��ʶ�" onclick="self.location.href='AddMoreport.php?enews=AddMoreport<?=$ecms_hashur['ehref']?>';">
		&nbsp;&nbsp;
        <input type="button" name="Submit52" value="�������з��ʶ˻����붯̬ҳ��" onclick="if(document.getElementById('moreportchangedata').style.display==''){document.getElementById('moreportchangedata').style.display='none';}else{document.getElementById('moreportchangedata').style.display='';}">
    </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tableborder" id="moreportchangedata" style="display:none">
	<form name="moreportchangedataform" method="GET" action="ListMoreport.php" onsubmit="return confirm('ȷ��Ҫ����?');">
	<?=$ecms_hashur['form']?>
	<input type="hidden" name="enews" value="MoreportChangeCacheAll">
    <tr class="header">
      <td height="25">�������з��ʶ˻����붯̬ҳ��</td>
    </tr>
    <tr>
    <td height="25" bgcolor="#FFFFFF"><input name="docache" type="checkbox" id="docache" value="1" checked>
      �������ݿ⻺��
      <input name="doclassfile" type="checkbox" id="doclassfile" value="1" checked>
      ������Ŀ�����ļ�
      <input name="dodtpage" type="checkbox" id="dodtpage" value="1" checked>
      ���¶�̬ҳ��
      <input name="dotmpfile" type="checkbox" id="dotmpfile" value="1" checked>
      ������ʱ�ļ�
      <input name="doreindex" type="checkbox" id="doreindex" value="1" checked>
      ���¶�̬��ҳ�ļ�
      <input type="submit" name="Submit" value="�ύ"></td>
  </tr>
  </form>
</table>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="tableborder">
  <form name="listmoreportform" method="post" action="ListMoreport.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <?=$ecms_hashur['form']?>
    <input type="hidden" name="enews" value="DelMoreport_all">
    <tr class="header"> 
      <td width="7%" height="25"> <div align="center">ID</div></td>
      <td width="25%" height="25"> <div align="center">���ʶ�</div></td>
      <td width="27%" height="25"> <div align="center">ʹ��ģ����</div></td>
      <td width="11%"><div align="center">ǿ�ƶ�̬ҳģʽ</div></td>
      <td width="11%"><div align="center">״̬</div></td>
      <td width="19%" height="25"> <div align="center">����</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
	//�����ʶ�
	if($r['pid']==1)
	{
		$r['pname']='<b>'.$r['pname'].'</b>';
		if(empty($r['purl']))
		{
			$r['purl']=$public_r['newsurl'];
		}
		$tgr=$empire->fetch1("select gid,gname,isdefault from {$dbtbpre}enewstempgroup where isdefault=1");
	}
	else
	{
		$tgr=$empire->fetch1("select gid,gname,isdefault from {$dbtbpre}enewstempgroup where gid='$r[tempgid]'");
	}
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25"> <div align="center"> 
          <?=$r[pid]?>
        </div></td>
      <td height="25"> <div align="center"> 
	  <a href="<?=$r[purl]?>" target="_blank"><?=$r[pname]?></a>
	   </div></td>
      <td height="25"> <div align="center"> 
          <?=$tgr[gname]?>
        </div></td>
      <td><div align="center"><?=$r[mustdt]==1?'��':'��'?></div></td>
      <td><div align="center"><?=$r[isclose]==1?'�ر�':'����'?></div></td>
      <td height="25"> <div align="center">
	  <?php
	  if($r['pid']==1)
	  {
	  ?>
	  	�����ʶ�
	  <?php
	  }
	  else
	  {
	  ?>
		 [<a href="AddMoreport.php?enews=EditMoreport&pid=<?=$r[pid]?><?=$ecms_hashur['ehref']?>">�޸�</a>] [<a href="ListMoreport.php?enews=DelMoreport&pid=<?=$r[pid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]
	  <?php
	  }
	  ?>
		</div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="6">&nbsp; 
        <?=$returnpage?>
        &nbsp;&nbsp;</td>
    </tr>
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>