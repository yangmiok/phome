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
CheckLevel($logininid,$loginin,$classid,"key");

//���ӹؼ���
function AddKey($keyname,$keyurl,$userid,$username){
	global $empire,$dbtbpre;
	$cid=(int)$_POST['cid'];
	$fcid=(int)$_POST['fcid'];
	if(!$keyname||!$keyurl)
	{printerror("EmptyKeyname","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"key");
	$keyname=hRepPostStr($keyname,1);
	$keyurl=hRepPostStr($keyurl,1);
	$sql=$empire->query("insert into {$dbtbpre}enewskey(keyname,keyurl,cid) values('$keyname','$keyurl','$cid');");
	$keyid=$empire->lastid();
	GetConfig();//���»���
	if($sql)
	{
		//������־
		insert_dolog("keyid=".$keyid."<br>keyname=".$keyname);
		printerror("AddKeySuccess","key.php?fcid=$fcid".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸Ĺؼ���
function EditKey($keyid,$keyname,$keyurl,$userid,$username){
	global $empire,$dbtbpre;
	$cid=(int)$_POST['cid'];
	$fcid=(int)$_POST['fcid'];
	if(!$keyname||!$keyurl||!$keyid)
	{printerror("EmptyKeyname","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"key");
	$keyid=(int)$keyid;
	$keyname=hRepPostStr($keyname,1);
	$keyurl=hRepPostStr($keyurl,1);
	$sql=$empire->query("update {$dbtbpre}enewskey set keyname='$keyname',keyurl='$keyurl',cid='$cid' where keyid='$keyid'");
	GetConfig();//���»���
	if($sql)
	{
		//������־
		insert_dolog("keyid=".$keyid."<br>keyname=".$keyname);
		printerror("EditKeySuccess","key.php?fcid=$fcid".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ���ؼ���
function DelKey($keyid,$userid,$username){
	global $empire,$dbtbpre;
	$fcid=(int)$_GET['fcid'];
	$keyid=(int)$keyid;
	if(!$keyid)
	{printerror("NotDelKeyid","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"key");
	$r=$empire->fetch1("select keyname from {$dbtbpre}enewskey where keyid='$keyid'");
	$sql=$empire->query("delete from {$dbtbpre}enewskey where keyid='$keyid'");
	GetConfig();//���»���
	if($sql)
	{
		//������־
		insert_dolog("keyid=".$keyid."<br>keyname=".$r[keyname]);
		printerror("DelKeySuccess","key.php?fcid=$fcid".hReturnEcmsHashStrHref2(0));
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
//���ӹؼ���
if($enews=="AddKey")
{
	$keyname=$_POST['keyname'];
	$keyurl=$_POST['keyurl'];
	AddKey($keyname,$keyurl,$logininid,$loginin);
}
//�޸Ĺؼ���
elseif($enews=="EditKey")
{
	$keyid=$_POST['keyid'];
	$keyname=$_POST['keyname'];
	$keyurl=$_POST['keyurl'];
	EditKey($keyid,$keyname,$keyurl,$logininid,$loginin);
}
//ɾ���ؼ���
elseif($enews=="DelKey")
{
	$keyid=$_GET['keyid'];
	DelKey($keyid,$logininid,$loginin);
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
$add='';
//����
$fcid=(int)$_GET['fcid'];
if($fcid)
{
	$add=" where cid='$fcid'";
	$search.='&fcid='.$fcid;
}
$totalquery="select count(*) as total from {$dbtbpre}enewskey".$add;
$num=$empire->gettotal($totalquery);
$query="select keyid,keyname,keyurl,cid from {$dbtbpre}enewskey".$add." order by keyid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//����
$cstr='';
$csql=$empire->query("select classid,classname from {$dbtbpre}enewskeyclass");
while($cr=$empire->fetch($csql))
{
	$cstr.="<option value='$cr[classid]'>$cr[classname]</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ؼ���</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="56%">λ�ã�<a href="key.php<?=$ecms_hashur['whehref']?>">�������ݹؼ���</a></td>
    <td width="44%"><div align="right" class="emenubutton">
        <input type="button" name="Submit52" value="�������ݹؼ��ַ���" onclick="self.location.href='KeyClass.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">

  <tr> 
    <td> ѡ����ࣺ 
      <select name="fcid" id="fcid" onchange=window.location='key.php?<?=$ecms_hashur['ehref']?>&fcid='+this.options[this.selectedIndex].value>
        <option value="0">��ʾ���з���</option>
		<?=$fcid?str_replace("'$fcid'>","'$fcid' selected>",$cstr):$cstr?>
      </select> </td>
  </tr>
</table>

<br>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="key.php">
  <?=$ecms_hashur['form']?>
  <input type=hidden name=enews value=AddKey>
  <input type=hidden name=fcid value=<?=$fcid?>>
    <tr class="header">
      <td height="25">���ӹؼ���:</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> �ؼ���: 
        <input name="keyname" type="text" id="keyname">
        ���ӵ�ַ:
        <input name="keyurl" type="text" id="keyurl" value="http://" size="30">
        ��������:
        <select name="cid" id="cid">
          <option value="0">����������</option>
		  <?=$cstr?>
        </select> 
        <input type="submit" name="Submit" value="����">
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
	</form>
  </table>
<br>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="70%" height="25">�ؼ���</td>
    <td width="30%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=key.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditKey>
    <input type=hidden name=keyid value=<?=$r[keyid]?>>
	<input type=hidden name=fcid value=<?=$fcid?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25">�ؼ���: 
        <input name="keyname" type="text" id="keyname" value="<?=$r[keyname]?>">
        ���ӵ�ַ: 
        <input name="keyurl" type="text" id="keyurl" value="<?=$r[keyurl]?>" size="30">
        ��������: 
        <select name="cid" id="cid">
          <option value="0">����������</option>
          <?=$r[cid]?str_replace("'$r[cid]'>","'$r[cid]' selected>",$cstr):$cstr?>
        </select> </td>
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit3" value="�޸�">
          &nbsp; 
          <input type="button" name="Submit4" value="ɾ��" onclick="if(confirm('ȷ��Ҫɾ��?')){self.location.href='key.php?enews=DelKey&keyid=<?=$r[keyid]?>&fcid=<?=$fcid?><?=$ecms_hashur['href']?>';}">
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
