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
CheckLevel($logininid,$loginin,$classid,"wap");

//����wapģ��
function AddWapStyle($add,$userid,$username){
	global $empire,$dbtbpre;
	$path=RepPathStr($add['path']);
	$path=(int)$path;
	if(empty($path)||empty($add['stylename']))
	{
		printerror("EmptyWapStyle","history.go(-1)");
	}
	//Ŀ¼�Ƿ����
	if(!file_exists("../../wap/template/".$path))
	{
		printerror("EmptyWapStylePath","history.go(-1)");
	}
	$add['stylename']=hRepPostStr($add['stylename'],1);
	$sql=$empire->query("insert into {$dbtbpre}enewswapstyle(stylename,path) values('$add[stylename]',$path);");
	if($sql)
	{
		$styleid=$empire->lastid();
		//������־
		insert_dolog("styleid=$styleid&stylename=$add[stylename]");
		printerror("AddWapStyleSuccess","WapStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸�wapģ��
function EditWapStyle($add,$userid,$username){
	global $empire,$dbtbpre;
	$styleid=(int)$add['styleid'];
	$path=RepPathStr($add['path']);
	$path=(int)$path;
	if(!$styleid||empty($path)||empty($add['stylename']))
	{
		printerror("EmptyWapStyle","history.go(-1)");
	}
	//Ŀ¼�Ƿ����
	if(!file_exists("../../wap/template/".$path))
	{
		printerror("EmptyWapStylePath","history.go(-1)");
	}
	$add['stylename']=hRepPostStr($add['stylename'],1);
	$sql=$empire->query("update {$dbtbpre}enewswapstyle set stylename='$add[stylename]',path=$path where styleid=$styleid");
	if($sql)
	{
		//������־
		insert_dolog("styleid=$styleid&stylename=$add[stylename]");
		printerror("EditWapStyleSuccess","WapStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ��wapģ��
function DelWapStyle($styleid,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	$styleid=(int)$styleid;
	if(!$styleid)
	{
		printerror("EmptyWapStyleid","history.go(-1)");
	}
	$r=$empire->fetch1("select stylename,path from {$dbtbpre}enewswapstyle where styleid=$styleid");
	if($styleid==$public_r['wapdefstyle'])
	{
		printerror("NotDelDefWapStyle","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewswapstyle where styleid=$styleid");
	if($sql)
	{
		//������־
		insert_dolog("styleid=$styleid&stylename=$r[stylename]");
		printerror("DelWapStyleSuccess","WapStyle.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//����wapģ��
if($enews=="AddWapStyle")
{
	AddWapStyle($_POST,$logininid,$loginin);
}
//�޸�wapģ��
elseif($enews=="EditWapStyle")
{
	EditWapStyle($_POST,$logininid,$loginin);
}
//ɾ��wapģ��
elseif($enews=="DelWapStyle")
{
	DelWapStyle($_GET['styleid'],$logininid,$loginin);
}
else
{}
$pr=$empire->fetch1("select wapdefstyle from {$dbtbpre}enewspublic limit 1");
$sql=$empire->query("select styleid,stylename,path from {$dbtbpre}enewswapstyle order by styleid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title></title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td><p>λ�ã�<a href="WapStyle.php<?=$ecms_hashur['whehref']?>">����WAPģ��</a></p></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit522" value="WAP����" onclick="self.location.href='SetWap.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<form name="form1" method="post" action="WapStyle.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">����WAPģ��: 
        <input name=enews type=hidden id="enews" value=AddWapStyle>
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> ģ������: 
        <input name="stylename" type="text" id="stylename">
        ģ��Ŀ¼:e/wap/template/ 
        <input name="path" type="text" id="path" size="6">
        (����д����) 
        <input type="submit" name="Submit" value="����">
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="7%"><div align="center">ID</div></td>
    <td width="29%" height="25"><div align="center">ģ������</div></td>
    <td width="30%"><div align="center">ģ��Ŀ¼</div></td>
    <td width="34%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  	$bgcolor="#FFFFFF";
	$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
  	if($r[styleid]==$pr['wapdefstyle'])
	{
		$bgcolor="#DBEAF5";
		$movejs='';
	}
  ?>
  <form name=form2 method=post action=WapStyle.php>
	  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditWapStyle>
    <input type=hidden name=styleid value=<?=$r[styleid]?>>
    <tr bgcolor="<?=$bgcolor?>"<?=$movejs?>> 
      <td><div align="center">
          <?=$r[styleid]?>
        </div></td>
      <td height="25"> <div align="center"> 
          <input name="stylename" type="text" id="stylename" value="<?=$r[stylename]?>">
        </div></td>
      <td><div align="center">e/wap/template/
<input name="path" type="text" id="path" value="<?=$r[path]?>" size="6">
        </div></td>
      <td height="25"><div align="center">
          <input type="submit" name="Submit3" value="�޸�">
          &nbsp; 
          <input type="button" name="Submit4" value="ɾ��" onclick="if(confirm('ȷ��Ҫɾ��?')){self.location.href='WapStyle.php?enews=DelWapStyle&styleid=<?=$r[styleid]?><?=$ecms_hashur['href']?>';}">
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
