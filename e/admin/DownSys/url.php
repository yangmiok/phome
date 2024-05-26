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
CheckLevel($logininid,$loginin,$classid,"downurl");

//����url��ַ
function AddDownurl($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add[urlname]))
	{printerror("EmptyDownurl","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"downurl");
	$downtype=(int)$add['downtype'];
	$add['urlname']=hRepPostStr($add['urlname'],1);
	$add['url']=AddAddsData($add['url']);
	$sql=$empire->query("insert into {$dbtbpre}enewsdownurlqz(urlname,url,downtype) values('$add[urlname]','$add[url]','$downtype');");
	$urlid=$empire->lastid();
	if($sql)
	{
		//������־
		insert_dolog("urlid=".$urlid);
		printerror("AddDownurlSuccess","url.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸�url��ַ
function EditDownurl($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[urlid]=(int)$add[urlid];
	if(empty($add[urlname])||empty($add[urlid]))
	{printerror("EmptyDownurl","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"downurl");
	$downtype=(int)$add['downtype'];
	$add['urlname']=hRepPostStr($add['urlname'],1);
	$add['url']=AddAddsData($add['url']);
	$sql=$empire->query("update {$dbtbpre}enewsdownurlqz set urlname='$add[urlname]',url='$add[url]',downtype='$downtype' where urlid='$add[urlid]'");
	if($sql)
	{
		//������־
		insert_dolog("urlid=".$add[urlid]);
		printerror("EditDownurlSuccess","url.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ��url��ַ
function DelDownurl($urlid,$userid,$username){
	global $empire,$dbtbpre;
	$urlid=(int)$urlid;
	if(empty($urlid))
	{printerror("NotChangeDownurlid","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"downurl");
	$sql=$empire->query("delete from {$dbtbpre}enewsdownurlqz where urlid='$urlid'");
	if($sql)
	{
		//������־
		insert_dolog("urlid=".$urlid);
		printerror("DelDownurlSuccess","url.php".hReturnEcmsHashStrHref2(1));
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
//����ǰ׺
if($enews=="AddDownurl")
{
	AddDownurl($_POST,$logininid,$loginin);
}
//�޸�ǰ׺
elseif($enews=="EditDownurl")
{
	EditDownurl($_POST,$logininid,$loginin);
}
//ɾ��ǰ׺
elseif($enews=="DelDownurl")
{
	$urlid=$_GET['urlid'];
	DelDownurl($urlid,$logininid,$loginin);
}
else
{}
$sql=$empire->query("select urlid,urlname,url,downtype from {$dbtbpre}enewsdownurlqz order by urlid desc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�������ص�ַǰ׺</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href="url.php<?=$ecms_hashur['whehref']?>">�������ص�ַǰ׺</a></td>
  </tr>
</table>
<form name="form1" method="post" action="url.php">
  <input type=hidden name=enews value=AddDownurl>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" class="header">�������ص�ַǰ׺:</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> ����: 
        <input name="urlname" type="text" id="urlname">
        ��ַ: 
        <input name="url" type="text" id="url" value="http://" size="38">
        ���ط�ʽ: <select name="downtype" id="downtype">
          <option value="0">HEADER</option>
          <option value="1">META</option>
          <option value="2">READ</option>
        </select> <input type="submit" name="Submit" value="����"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="74%" height="25">���ص�ַǰ׺����:</td>
    <td width="26%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <form name=form2 method=post action=url.php>
	  <?=$ecms_hashur['form']?>
  <input type=hidden name=enews value=EditDownurl>
  <input type=hidden name=urlid value=<?=$r[urlid]?>>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25">����: 
        <input name="urlname" type="text" id="urlname" value="<?=$r[urlname]?>">
        ��ַ: 
        <input name="url" type="text" id="url" value="<?=$r[url]?>" size="30">
        <select name="downtype" id="downtype">
          <option value="0"<?=$r['downtype']==0?' selected':''?>>HEADER</option>
          <option value="1"<?=$r['downtype']==1?' selected':''?>>META</option>
          <option value="2"<?=$r['downtype']==2?' selected':''?>>READ</option>
        </select> </td>
    <td height="25"><div align="center">
          <input type="submit" name="Submit3" value="�޸�">&nbsp;
          <input type="button" name="Submit4" value="ɾ��" onclick="if(confirm('ȷ��Ҫɾ��?')){self.location.href='url.php?enews=DelDownurl&urlid=<?=$r[urlid]?><?=$ecms_hashur['href']?>';}">
        </div></td>
  </tr>
  </form>
  <?
  }
  db_close();
  $empire=null;
  ?>
</table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class=tableborder>
  <tr> 
    <td height="26" bgcolor="#FFFFFF"><strong>���ط�ʽ˵����</strong></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#FFFFFF"><strong>HEADER��</strong>ʹ��headerת��ͨ����Ϊ�����<br>
      <strong>META��</strong>ֱ��ת�ԣ������FTP��ַ�Ƽ�ѡ�������<br>
      <strong>READ��</strong>ʹ��PHP�����ȡ����������ǿ������ռ��Դ������������С�ļ���ѡ��</td>
  </tr>
</table>
</body>
</html>
