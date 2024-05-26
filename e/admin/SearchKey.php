<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../data/dbcache/class.php");
$link=db_connect();
$empire=new mysqlquery();
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
CheckLevel($logininid,$loginin,$classid,"searchkey");

//ɾ�������ؼ���
function DelSearchKey($onclick,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"searchkey");
	$onclick=(int)$onclick;
	if(empty($onclick))
	{
		printerror("EmptySearchOnclick","history.go(-1)");
    }
	$sql=$empire->query("delete from {$dbtbpre}enewssearch where onclick<".$onclick.";");
	if($sql)
	{
		//������־
	    insert_dolog("onclick=".$onclick);
		printerror("DelSearchKeySuccess","SearchKey.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ�������ؼ���
function DelSearchKey_all($add,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"searchkey");
	$searchid=$add['searchid'];
	$count=count($searchid);
	if(empty($count))
	{
		printerror("EmptySearchId","history.go(-1)");
    }
	$ids='';
	for($i=0;$i<$count;$i++)
	{
		$dh=',';
		if($i==0)
		{
			$dh='';
		}
		$ids.=$dh.intval($searchid[$i]);
	}
	$sql=$empire->query("delete from {$dbtbpre}enewssearch where searchid in (".$ids.");");
	if($sql)
	{
		//������־
	    insert_dolog("");
		printerror("DelSearchKeySuccess","SearchKey.php".hReturnEcmsHashStrHref2(1));
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
//ɾ�������ؼ���
if($enews=="DelSearchKey")
{
	$onclick=$_POST['onclick'];
	DelSearchKey($onclick,$logininid,$loginin);
}
if($enews=="DelSearchKey_all")
{
	DelSearchKey_all($_POST,$logininid,$loginin);
}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//ÿҳ��ʾ����
$page_line=18;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select * from {$dbtbpre}enewssearch";
$totalquery="select count(*) as total from {$dbtbpre}enewssearch";
$classid=ehtmlspecialchars($_GET['classid']);
$bclassid=0;
if($classid!='all'&&strlen($classid)!=0)
{
	$bclassid=$classid;
	$query.=" where trueclassid='".intval($classid)."'";
	$totalquery.=" where trueclassid='".intval($classid)."'";
}
$search="&classid=".$classid.$ecms_hashur['ehref'];
//ȡ��������
$num=$empire->gettotal($totalquery);
$query.=" order by onclick desc limit $offset,$line";
$sql=$empire->query($query);
//���
$fcfile="../data/fc/ListEnews.php";
$class="<script src=../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",$bclassid,0,"|-",0,0);}
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����ؼ�������</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
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
    <td height="25">λ�ã�<a href="SearchKey.php<?=$ecms_hashur['whehref']?>">�����ؼ�������</a></td>
  </tr>
</table>

  
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="SearchKey.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25">ɾ�������ؼ��ּ�¼</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ɾ�������� <strong><font color="#FF0000">&lt;</font></strong> 
        <input name="onclick" type="text" id="onclick" value="0" size="8">
        �ļ�¼
        <input type="submit" name="Submit" value="ɾ��">
        <input name="enews" type="hidden" id="enews" value="DelSearchKey"></td>
    </tr>
	</form>
  </table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="searchkeyform" method="post" action="SearchKey.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <?=$ecms_hashur['form']?>
  <input type=hidden name=enews value=DelSearchKey_all>
    <tr class="header"> 
      <td height="25" colspan="6">��ʾ��Χ�� 
        <select name="classid" id="classid" onchange=window.location='SearchKey.php?<?=$ecms_hashur['ehref']?>&classid='+this.options[this.selectedIndex].value>
          <option value="all">ȫ���ؼ���</option>
          <option value="0">������Ŀ������</option>
          <?=$class?>
        </select></td>
    </tr>
    <tr> 
      <td width="6%"><div align="center"></div></td>
      <td width="10%" height="25"><div align="center">ID</div></td>
      <td width="30%" height="25"><div align="center">�ؼ���</div></td>
      <td width="18%" height="25"><div align="center">������Ŀ</div></td>
      <td width="27%" height="25"><div align="center">�����ֶ�</div></td>
      <td width="9%"><div align="center">����</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  	if($r['iskey'])
	{
		$r[keyboard]='[����������]';
	}
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td><div align="center"> 
          <input name="searchid[]" type="checkbox" id="searchid[]" value="<?=$r[searchid]?>">
        </div></td>
      <td height="25"> <div align="center"> 
          <?=$r[searchid]?>
        </div></td>
      <td height="25"> <div align="center"><a href='../search/result?searchid=<?=$r[searchid]?>' title="LastTime: <?=date("Y-m-d H:i:s",$r[searchtime])?>" target=_blank> 
          <?=$r[keyboard]?>
          </a></div></td>
      <td height="25"> <div align="center"><a href="SearchKey.php?<?=$ecms_hashur['ehref']?>&classid=<?=$r[classid]?>"> 
          <?=$r[classid]?>
          </a></div></td>
      <td height="25"> <div align="center"> 
          <?=$r[searchclass]?>
        </div></td>
      <td> <div align="center"> 
          <?=$r[onclick]?>
        </div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <div align="center">
          <input type=checkbox name=chkall value=on onclick="CheckAll(this.form)">
        </div></td>
      <td height="25" colspan="5"> 
        <?=$returnpage?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="Submit2" value="ɾ��"> </td>
    </tr>
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
