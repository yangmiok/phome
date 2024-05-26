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
CheckLevel($logininid,$loginin,$classid,"player");

//��֤�ļ�
function CheckPlayerFilename($filename){
	if(strstr($filename,"\\")||strstr($filename,"/")||strstr($filename,".."))
	{
		printerror("PlayerFileNotExist","history.go(-1)");
	}
	//�ļ��Ƿ����
	if(!file_exists("../../DownSys/play/".$filename))
	{
		printerror("PlayerFileNotExist","history.go(-1)");
	}
}

//------------------���Ӳ�����
function AddPlayer($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[player]||!$add[filename])
	{
		printerror("EmptyPlayerName","history.go(-1)");
	}
	CheckPlayerFilename($add[filename]);
	$add['player']=hRepPostStr($add['player'],1);
	$add['bz']=hRepPostStr($add['bz'],1);
	$sql=$empire->query("insert into {$dbtbpre}enewsplayer(player,filename,bz) values('".$add['player']."','".eaddslashes($add[filename])."','".$add[bz]."');");
	$id=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("id=$id<br>player=$add[player]");
		printerror("AddPlayerSuccess","player.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//----------------�޸Ĳ�����
function EditPlayer($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[id]=(int)$add[id];
	if(!$add[player]||!$add[filename]||!$add[id])
	{
		printerror("EmptyPlayerName","history.go(-1)");
	}
	CheckPlayerFilename($add[filename]);
	$add['player']=hRepPostStr($add['player'],1);
	$add['bz']=hRepPostStr($add['bz'],1);
	$sql=$empire->query("update {$dbtbpre}enewsplayer set player='".$add['player']."',filename='".eaddslashes($add[filename])."',bz='".$add['bz']."' where id='$add[id]'");
	if($sql)
	{
		//������־
		insert_dolog("id=$add[id]<br>player=$add[player]");
		printerror("EditPlayerSuccess","player.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//---------------ɾ��������
function DelPlayer($id,$userid,$username){
	global $empire,$dbtbpre;
	$id=(int)$id;
	if(!$id)
	{
		printerror("NotDelPlayerID","history.go(-1)");
	}
	$r=$empire->fetch1("select id,player from {$dbtbpre}enewsplayer where id='$id'");
	if(!$r[id])
	{
		printerror("NotDelPlayerID","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsplayer where id='$id'");
	if($sql)
	{
		//������־
		insert_dolog("id=$id<br>player=$r[player]");
		printerror("DelPlayerSuccess","player.php".hReturnEcmsHashStrHref2(1));
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
//���Ӳ�����
if($enews=="AddPlayer")
{
	AddPlayer($_POST,$logininid,$loginin);
}
//�޸Ĳ�����
elseif($enews=="EditPlayer")
{
	EditPlayer($_POST,$logininid,$loginin);
}
//ɾ��������
elseif($enews=="DelPlayer")
{
	$id=$_GET['id'];
	DelPlayer($id,$logininid,$loginin);
}
$sql=$empire->query("select id,player,filename,bz from {$dbtbpre}enewsplayer order by id");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���Ӳ�����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href="player.php<?=$ecms_hashur['whehref']?>">��������</a></td>
  </tr>
</table>
<form name="addplayerform" method="post" action="player.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="4">���Ӳ�����: <input type=hidden name=enews value=AddPlayer></td>
    </tr>
    <tr>
      <td width="14%" height="25" bgcolor="#FFFFFF">����������</td>
      <td width="33%" bgcolor="#FFFFFF">�ļ���</td>
      <td width="13%" bgcolor="#FFFFFF">˵��</td>
      <td width="40%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 
        <input name="player" type="text" id="player" value="">
      </td>
      <td bgcolor="#FFFFFF">e/DownSys/play/ 
        <input name="filename" type="text" id="filename" value="">
        <a href="#ecms" onclick="window.open('ChangePlayerFile.php?returnform=opener.document.addplayerform.filename.value<?=$ecms_hashur['ehref']?>','','width=400,height=500,scrollbars=yes');">[ѡ��]</a></td>
      <td bgcolor="#FFFFFF"><input name="bz" type="text" id="bz"></td>
      <td bgcolor="#FFFFFF"><input type="submit" name="Submit" value="����"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td width="8%"> 
      <div align="center">ID</div></td>
    <td width="14%" height="25">����������</td>
    <td width="33%">�ļ���</td>
    <td width="13%">˵��</td>
    <td width="32%" height="25"> ����</td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name="playerform<?=$r[id]?>" method=post action=player.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditPlayer>
    <input type=hidden name=id value=<?=$r[id]?>>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
      <td><div align="center"><?=$r[id]?></div></td>
      <td height="25"> <input name="player" type="text" value="<?=$r[player]?>"> 
      </td>
      <td>e/DownSys/play/ 
        <input name="filename" type="text" value="<?=$r[filename]?>"> 
        <a href="#ecms" onclick="window.open('ChangePlayerFile.php?returnform=opener.document.playerform<?=$r[id]?>.filename.value<?=$ecms_hashur['ehref']?>','','width=400,height=500,scrollbars=yes');">[ѡ��]</a></td>
      <td><input name="bz" type="text" value="<?=$r[bz]?>"></td>
      <td height="25"> <div align="left"> 
          <input type="submit" name="Submit3" value="�޸�">
          &nbsp; 
          <input type="button" name="Submit4" value="ɾ��" onclick="if(confirm('ȷ��Ҫɾ��?')){self.location.href='player.php?enews=DelPlayer&id=<?=$r[id]?><?=$ecms_hashur['href']?>';}">
        </div></td>
    </tr>
  </form>
  <?
  }
  db_close();
  $empire=null;
  ?>
</table>
</body>
</html>
