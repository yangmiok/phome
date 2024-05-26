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
CheckLevel($logininid,$loginin,$classid,"log");

//ɾ����־
function DelLog($loginid,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"log");
	$loginid=(int)$loginid;
	if(!$loginid)
	{
		printerror("NotDelLogid","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewslog where loginid='$loginid'");
	if($sql)
	{
		//������־
		insert_dolog("loginid=".$loginid);
		printerror("DelLogSuccess","ListLog.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//����ɾ����־
function DelLog_all($loginid,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"log");
	$count=count($loginid);
	if(!$count)
	{
		printerror("NotDelLogid","history.go(-1)");
	}
	for($i=0;$i<$count;$i++)
	{
		$add.=" loginid='".intval($loginid[$i])."' or";
	}
	$add=substr($add,0,strlen($add)-3);
	$sql=$empire->query("delete from {$dbtbpre}enewslog where".$add);
	if($sql)
	{
		//������־
		insert_dolog("");
		printerror("DelLogSuccess","ListLog.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//����ɾ����־
function DelLog_date($add,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"log");
	$start=RepPostVar($add['startday']);
	$end=RepPostVar($add['endday']);
	if(!$start||!$end)
	{
		printerror('EmptyDelLogTime','');
	}
	$startday=$start.' 00:00:00';
	$endday=$end.' 23:59:59';
	$sql=$empire->query("delete from {$dbtbpre}enewslog where logintime<='$endday' and logintime>='$startday'");
	if($sql)
	{
		//������־
		insert_dolog("time=".$start."~".$end);
		printerror("DelLogSuccess","ListLog.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//����
function ToAddDateZero($n){
	if($n<10)
	{
		$n='0'.$n;
	}
	return $n;
}

//��������
function ReturnLogSelectDate($y,$m,$d){
	//��
	if(empty($y))
	{
		$y=date("Y");
	}
	for($i=2003;$i<=$thisyear+1;$i++)
	{
		$selected='';
		if($i==$y)
		{
			$selected=' selected';
		}
		$r['year'].="<option value='".$i."'".$selected.">".$i."</option>";
	}
	//��
	if(empty($m))
	{
		$m=date("m");
	}
	for($i=1;$i<=12;$i++)
	{
		$selected='';
		$mi=ToAddDateZero($i);
		if($mi==$m)
		{
			$selected=' selected';
		}
		$r['month'].="<option value='".$mi."'".$selected.">".$mi."</option>";
	}
	//��
	if(empty($d))
	{
		$d=date("d");
	}
	for($i=1;$i<=31;$i++)
	{
		$selected='';
		$di=ToAddDateZero($i);
		if($di==$d)
		{
			$selected=' selected';
		}
		$r['day'].="<option value='".$di."'".$selected.">".$di."</option>";
	}
	return $r;
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//ɾ����־
if($enews=="DelLog")
{
	$loginid=$_GET['loginid'];
	DelLog($loginid,$logininid,$loginin);
}
//����ɾ����־
elseif($enews=="DelLog_all")
{
	$loginid=$_POST['loginid'];
	DelLog_all($loginid,$logininid,$loginin);
}
elseif($enews=="DelLog_date")
{
	DelLog_date($_POST,$logininid,$loginin);
}

$line=20;//ÿҳ��ʾ����
$page_line=18;//ÿҳ��ʾ������
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$offset=$page*$line;//��ƫ����
$query="select loginid,username,loginip,logintime,status,password,loginauth,ipport from {$dbtbpre}enewslog";
$totalquery="select count(*) as total from {$dbtbpre}enewslog";
//����
$search='';
$search.=$ecms_hashur['ehref'];
$where='';
if($_GET['sear']==1)
{
	$search.="&sear=1";
	$a='';
	$and='';
	//״̬
	$status=(int)$_GET['status'];
	if($status)
	{
		if($status==1)
		{
			$a.="status=1";
		}
		else
		{
			$a.="status=0";
		}
		$search.="&status=$status";
	}
	//ʱ��
	$startday=RepPostVar($_GET['startday']);
	$endday=RepPostVar($_GET['endday']);
	if($startday&&$endday)
	{
		$and=$a?' and ':'';
		$search.="&startday=$startday&endday=$endday";
		$a.=$and."logintime<='".$endday." 23:59:59' and logintime>='".$startday." 00:00:00'";
	}
	//����
	$keyboard=RepPostVar($_GET['keyboard']);
	if($keyboard)
	{
		$and=$a?' and ':'';
		$show=RepPostStr($_GET['show'],1);
		if($show==1)
		{
			$a.=$and."username like '%$keyboard%'";
		}
		elseif($show==2)
		{
			$a.=$and."loginip like '%$keyboard%'";
		}
		else
		{
			$a.=$and."(username like '%$keyboard%' or loginip like '%$keyboard%')";
		}
		$search.="&keyboard=$keyboard&show=$show";
	}
	if($a)
	{
		$where.=" where ".$a;
	}
	$query.=$where;
	$totalquery.=$where;
}
$search2=$search;
//����
$mydesc=(int)$_GET['mydesc'];
$desc=$mydesc?'asc':'desc';
$orderby=(int)$_GET['orderby'];
if($orderby==1)//��½�û�
{
	$order="username ".$desc.",loginid desc";
	$usernamedesc=$mydesc?0:1;
}
elseif($orderby==2)//״̬
{
	$order="status ".$desc.",loginid desc";
	$statusdesc=$mydesc?0:1;
}
elseif($orderby==3)//��½IP
{
	$order="loginip ".$desc.",loginid desc";
	$loginipdesc=$mydesc?0:1;
}
elseif($orderby==4)//��½ʱ��
{
	$order="logintime ".$desc.",loginid desc";
	$logintimedesc=$mydesc?0:1;
}
else//ID
{
	$order="loginid ".$desc;
	$loginiddesc=$mydesc?0:1;
}
$search.="&orderby=$orderby&mydesc=$mydesc";
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by ".$order." limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<html>
<head>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css"> 
<title>�����½��־</title>
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
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
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>λ�ã���־���� &gt; <a href="ListLog.php<?=$ecms_hashur['whehref']?>">�����½��־</a></td>
    <td width="50%"><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="���������־" onclick="self.location.href='ListDolog.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
  
<br>
<table width="100%" align=center cellpadding=0 cellspacing=0>
  <form name=searchlogform method=get action='ListLog.php'>
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25"> <div align="center">ʱ��� 
          <input name="startday" type="text" value="<?=$startday?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
          �� 
          <input name="endday" type="text" value="<?=$endday?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
          ���ؼ��֣� 
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="show" id="show">
            <option value="0"<?=$show==0?' selected':''?>>����</option>
            <option value="1"<?=$show==1?' selected':''?>>�û���</option>
            <option value="2"<?=$show==2?' selected':''?>>��½IP</option>
          </select>
          <select name="status" id="status">
            <option value="0"<?=$status==0?' selected':''?>>����״̬</option>
            <option value="1"<?=$status==1?' selected':''?>>��½�ɹ���־</option>
            <option value="2"<?=$status==2?' selected':''?>>��½ʧ����־</option>
          </select>
          <input name=submit1 type=submit id="submit12" value=����>
          <input name="sear" type="hidden" id="sear" value="1">
        </div></td>
    </tr>
  </form>
</table>
<form name="form2" method="post" action="ListLog.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td width="7%"><div align="center"><a href="ListLog.php?orderby=0&mydesc=<?=$loginiddesc.$search2?>">ID</a></div></td>
      <td width="28%" height="25"><div align="center"><a href="ListLog.php?orderby=1&mydesc=<?=$usernamedesc.$search2?>">��½�û�</a></div></td>
      <td width="20%"><div align="center"><a href="ListLog.php?orderby=2&mydesc=<?=$statusdesc.$search2?>">״̬</a></div></td>
      <td width="17%" height="25"><div align="center"><a href="ListLog.php?orderby=3&mydesc=<?=$loginipdesc.$search2?>">��½IP</a></div></td>
      <td width="17%"><div align="center"><a href="ListLog.php?orderby=4&mydesc=<?=$logintimedesc.$search2?>">��½ʱ��</a></div></td>
      <td width="11%" height="25"><div align="center">ɾ��</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  	if($r['status'])
	{
		$status='��½�ɹ�';
	}
	else
	{
		$status=$r['loginauth']?'<font color="red">��֤���</font>':'<font color="red">�����</font>';
	}
  ?>
    <tr bgcolor="#FFFFFF" id=log<?=$r[loginid]?>>
      <td><div align="center"><?=$r[loginid]?></div></td>
      <td height="25"><div align="center"> 
          <?=$r[username]?>
        </div></td>
      <td><div align="center">
          <?=$status?>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[loginip]?>:<?=$r[ipport]?>
        </div></td>
      <td><div align="center"> 
          <?=$r[logintime]?>
        </div></td>
      <td height="25"><div align="center">[<a href="ListLog.php?enews=DelLog&loginid=<?=$r[loginid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ������־?');">ɾ��</a> 
          <input name="loginid[]" type="checkbox" id="loginid[]" value="<?=$r[loginid]?>" onclick="if(this.checked){log<?=$r[loginid]?>.style.backgroundColor='#DBEAF5';}else{log<?=$r[loginid]?>.style.backgroundColor='#ffffff';}">
          ]</div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="6"> 
        <?=$returnpage?>
        &nbsp;&nbsp; <input type="submit" name="Submit" value="����ɾ��"> <input name="enews" type="hidden" id="phome" value="DelLog_all"> 
        &nbsp; <input type=checkbox name=chkall value=on onClick=CheckAll(this.form)>
        ѡ��ȫ�� </td>
    </tr>
  </table>
</form>
<form action="ListLog.php" method="post" name="dellogform" id="dellogform" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td><div align="center">
          <input name="enews" type="hidden" id="enews" value="DelLog_date">
          ɾ���� 
          <input name="startday" type="text" id="startday" value="<?=$startday?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
          �� 
          <input name="endday" type="text" id="endday" value="<?=$endday?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
          ֮�����־
<input type="submit" name="Submit2" value="�ύ">
          </div></td>
    </tr>
  </table>
</form>
<?
db_close();
$empire=null;
?>
</body>
</html>