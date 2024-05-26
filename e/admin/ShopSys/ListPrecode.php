<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
require("class/hShopSysFun.php");
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
CheckLevel($logininid,$loginin,$classid,"precode");

//���ػ�Ա���б�
function ReturnPreGroupids($groupid){
	$count=count($groupid);
	if(!$count)
	{
		return '';
	}
	$gids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$groupid[$i]=(int)$groupid[$i];
		if(!$groupid[$i])
		{
			continue;
		}
		$gids.=$dh.$groupid[$i];
		$dh=',';
	}
	if($gids)
	{
		$gids=','.$gids.',';
	}
	return $gids;
}

//�����Ż���
function AddPrecode($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add['prename']||!$add['precode']||!$add['premoney'])
	{
		printerror("EmptyPrecode","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"precode");
	$add['precode']=RepPostVar($add['precode']);
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsshop_precode where precode='$add[precode]' limit 1");
	if($num)
	{
		printerror("RePrecode","history.go(-1)");
	}
	$addtime=time();
	$add['prename']=eaddslashes(ehtmlspecialchars($add['prename']));
	$add['premoney']=(int)$add['premoney'];
	$add['pretype']=(int)$add['pretype'];
	$add['reuse']=(int)$add['reuse'];
	$add['endtime']=$add['endtime']?to_time($add['endtime']):0;
	$add['musttotal']=(int)$add['musttotal'];
	$add['usenum']=(int)$add['usenum'];
	$groupids=ReturnPreGroupids($add['groupid']);
	$add['classid']=trim($add['classid']);
	$classids=$add['classid']?','.$add['classid'].',':'';
	$sql=$empire->query("insert into {$dbtbpre}enewsshop_precode(prename,precode,premoney,pretype,reuse,addtime,endtime,groupid,classid,musttotal,usenum) values('$add[prename]','$add[precode]','$add[premoney]','$add[pretype]','$add[reuse]','$addtime','$add[endtime]','$groupids','".eaddslashes($classids)."','$add[musttotal]','$add[usenum]');");
	$id=$empire->lastid();
	if($sql)
	{
		//������־
	    insert_dolog("id=$id&precode=$add[precode]<br>premoney=$add[premoney]&pretype=$add[pretype]");
		printerror("AddPrecodeSuccess","AddPrecode.php?enews=AddPrecode".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//���������Ż���
function AddMorePrecode($add,$userid,$username){
	global $empire,$dbtbpre;
	$donum=(int)$add['donum'];
	$precodenum=(int)$add['precodenum'];
	$add['prename']=eaddslashes(ehtmlspecialchars($add['prename']));
	$add['premoney']=(int)$add['premoney'];
	$add['pretype']=(int)$add['pretype'];
	$add['reuse']=(int)$add['reuse'];
	$add['endtime']=$add['endtime']?to_time($add['endtime']):0;
	$add['musttotal']=(int)$add['musttotal'];
	$add['usenum']=(int)$add['usenum'];
	$groupids=ReturnPreGroupids($add['groupid']);
	$add['classid']=trim($add['classid']);
	$classids=$add['classid']?','.$add['classid'].',':'';
	if(!$donum||!$precodenum||!$add['prename']||!$add['premoney'])
	{
		printerror("EmptyMorePrecode","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"precode");
	$addtime=time();
	//д���Ż���
	$no=1;
    while($no<=$donum)
	{
		$precode=strtoupper(make_password($precodenum));
		$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsshop_precode where precode='$precode' limit 1");
		if(!$num)
		{
			$sql=$empire->query("insert into {$dbtbpre}enewsshop_precode(prename,precode,premoney,pretype,reuse,addtime,endtime,groupid,classid,musttotal,usenum) values('$add[prename]','$precode','$add[premoney]','$add[pretype]','$add[reuse]','$addtime','$add[endtime]','$groupids','".eaddslashes($classids)."','$add[musttotal]','$add[usenum]');");
			$no+=1;
	    }
    }
	if($sql)
	{
		//������־
		insert_dolog("prenum=$donum&premoney=$add[premoney]&pretype=$add[pretype]");
		printerror("AddMorePrecodeSuccess","AddMorePrecode.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸��Ż���
function EditPrecode($add,$userid,$username){
	global $empire,$dbtbpre;
	$add['id']=(int)$add['id'];
	if(!$add['prename']||!$add['precode']||!$add['premoney']||!$add['id'])
	{
		printerror("EmptyPrecode","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"precode");
	$add['precode']=RepPostVar($add['precode']);
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsshop_precode where precode='$add[precode]' and id<>".$add[id]." limit 1");
	if($num)
	{
		printerror("RePrecode","history.go(-1)");
	}
	$time=(int)$add['time'];
	$add['prename']=eaddslashes(ehtmlspecialchars($add['prename']));
	$add['premoney']=(int)$add['premoney'];
	$add['pretype']=(int)$add['pretype'];
	$add['reuse']=(int)$add['reuse'];
	$add['endtime']=$add['endtime']?to_time($add['endtime']):0;
	$add['musttotal']=(int)$add['musttotal'];
	$add['usenum']=(int)$add['usenum'];
	$groupids=ReturnPreGroupids($add['groupid']);
	$add['classid']=trim($add['classid']);
	$classids=$add['classid']?','.$add['classid'].',':'';
	$classids=eaddslashes($classids);
	$sql=$empire->query("update {$dbtbpre}enewsshop_precode set prename='$add[prename]',precode='$add[precode]',premoney='$add[premoney]',pretype='$add[pretype]',reuse='$add[reuse]',endtime='$add[endtime]',groupid='$groupids',classid='$classids',musttotal='$add[musttotal]',usenum='$add[usenum]' where id='$add[id]'");
	if($sql)
	{
		//������־
		insert_dolog("id=$add[id]&precode=$add[precode]<br>premoney=$add[premoney]&pretype=$add[pretype]");
		printerror("EditPrecodeSuccess","ListPrecode.php?time=$time".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ���Ż���
function DelPrecode($add,$userid,$username){
	global $empire,$dbtbpre;
	$id=(int)$add['id'];
	if(!$id)
	{
		printerror("NotChangePrecodeid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"precode");
	$time=(int)$add['time'];
	$r=$empire->fetch1("select precode,premoney,pretype from {$dbtbpre}enewsshop_precode where id='$id'");
	$sql=$empire->query("delete from {$dbtbpre}enewsshop_precode where id='$id'");
	if($sql)
	{
		//������־
		insert_dolog("id=$id&precode=$r[precode]<br>premoney=$r[premoney]&pretype=$r[pretype]");
		printerror("DelPrecodeSuccess","ListPrecode.php?time=$time".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//����ɾ���Ż���
function DelPrecode_all($add,$userid,$username){
	global $empire,$dbtbpre;
	$id=$add['id'];
	$count=count($id);
	if(!$count)
	{
		printerror("NotChangePrecodeid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"precode");
	$ids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$ids.=$dh.intval($id[$i]);
		$dh=',';
	}
	$time=(int)$add['time'];
	$sql=$empire->query("delete from {$dbtbpre}enewsshop_precode where id in (".$ids.")");
	if($sql)
	{
		//������־
		insert_dolog("");
		printerror("DelPrecodeSuccess","ListPrecode.php?time=$add[time]".hReturnEcmsHashStrHref2(0));
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
if($enews=="AddPrecode")//�����Ż���
{
	AddPrecode($_POST,$logininid,$loginin);
}
elseif($enews=="EditPrecode")//�޸��Ż���
{
	EditPrecode($_POST,$logininid,$loginin);
}
elseif($enews=="DelPrecode")//ɾ���Ż���
{
	DelPrecode($_GET,$logininid,$loginin);
}
elseif($enews=="AddMorePrecode")//���������Ż���
{
	AddMorePrecode($_POST,$logininid,$loginin);
}
elseif($enews=="DelPrecode_all")//����ɾ���Ż���
{
	DelPrecode_all($_POST,$logininid,$loginin);
}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;
$page_line=25;
$add="";
$and=' where ';
$search="";
$search.=$ecms_hashur['ehref'];
$time=(int)$_GET['time'];
//����
$sear=(int)$_GET['sear'];
if($sear)
{
	$show=(int)$_GET['show'];
	$keyboard=$_GET['keyboard'];
	$keyboard=RepPostVar2($keyboard);
	if($keyboard)
	{
		if($show==1)//�Ż�������
		{
			$add.=$and."prename like '%$keyboard%'";
		}
		elseif($show==2)//�Ż���
		{
			$add.=$and."precode='$keyboard'";
		}
		else//���
		{
			$add.=$and."premoney='$keyboard'";
		}
		$and=' and ';
	}
	//����
	$pretype=(int)$_GET['pretype'];
	if($pretype)
	{
		if($pretype==1)//���
		{
			$add.=$and."pretype=0";
		}
		else//�ٷֱ�
		{
			$add.=$and."pretype=1";
		}
		$and=' and ';
	}
	//�ظ�ʹ��
	$reuse=(int)$_GET['reuse'];
	if($reuse)
	{
		if($reuse==1)//һ����ʹ��
		{
			$add.=$and."reuse=0";
		}
		else//���ظ�ʹ��
		{
			$add.=$and."reuse=1";
		}
		$and=' and ';
	}
	$search.="&sear=1&pretype=$pretype&reuse=$reuse&show=$show&keyboard=$keyboard";
}
//����
if($time)
{
	$todaytime=time();
	$search.="&time=$time";
	$add.=$and."endtime>0 and endtime<".$todaytime;
}
$offset=$line*$page;
$totalquery="select count(*) as total from {$dbtbpre}enewsshop_precode".$add;
$num=$empire->gettotal($totalquery);
$query="select id,prename,precode,pretype,premoney,reuse,addtime,endtime from {$dbtbpre}enewsshop_precode".$add;
$query.=" order by id desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����Ż���</title>
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
    <td width="50%">λ�ã�<a href="ListPrecode.php<?=$ecms_hashur['whehref']?>">�����Ż���</a><?=$time?' &gt; �����Ż���':''?></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="�����Ż���" onclick="self.location.href='AddPrecode.php?enews=AddPrecode<?=$ecms_hashur['ehref']?>';">
		&nbsp;&nbsp;
        <input type="button" name="Submit52" value="���������Ż���" onclick="self.location.href='AddMorePrecode.php<?=$ecms_hashur['whehref']?>';">
		&nbsp;&nbsp;
        <input type="button" name="Submit53" value="��������Ż���" onclick="self.location.href='ListPrecode.php?time=1<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <form name=search method=GET action=ListPrecode.php>
  <?=$ecms_hashur['eform']?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="6"> ������ 
        <select name="show" id="show">
          <option value="1"<?=$show==1?' selected':''?>>�Ż�������</option>
          <option value="2"<?=$show==2?' selected':''?>>�Ż���</option>
          <option value="3"<?=$show==3?' selected':''?>>���</option>
        </select>
		<input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>"> 
        <select name="pretype" id="pretype">
          <option value="0"<?=$pretype==0?' selected':''?>>��������</option>
          <option value="1"<?=$pretype==1?' selected':''?>>�������Ż���</option>
          <option value="2"<?=$pretype==2?' selected':''?>>�ٷֱȵ��Ż���</option>
        </select>
        <select name="reuse" id="reuse">
          <option value="0"<?=$reuse==0?' selected':''?>>����ʹ��</option>
          <option value="1"<?=$reuse==1?' selected':''?>>һ����ʹ��</option>
          <option value="2"<?=$reuse==2?' selected':''?>>���ظ�ʹ��</option>
        </select> 
        <input type="submit" name="Submit" value="����"> <input name="sear" type="hidden" id="sear" value="1"> 
        <input name="time" type="hidden" id="time" value="<?=$time?>"> </td>
    </tr>
  </form>
</table>
  
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="tableborder">
  <form name="listcardform" method="post" action="ListPrecode.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <?=$ecms_hashur['form']?>
    <input type="hidden" name="enews" value="DelPrecode_all">
	<input name="time" type="hidden" id="time" value="<?=$time?>">
    <tr class="header"> 
      <td width="2%"><div align="center"></div></td>
      <td width="5%" height="25"> <div align="center">ID</div></td>
      <td width="28%"><div align="center">�Ż�������</div></td>
      <td width="31%" height="25"> <div align="center">�Ż���</div></td>
      <td width="12%" height="25"> <div align="center">���(Ԫ)</div></td>
      <td width="7%"><div align="center">�ظ�ʹ��</div></td>
      <td width="15%" height="25"> <div align="center">����</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  	if($r['pretype']==1)
	{
		$premoney=$r['premoney'].'%';
	}
	else
	{
  		$premoney=$r['premoney'].'Ԫ';
	}
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td><div align="center"> 
          <input name="id[]" type="checkbox" id="id[]" value="<?=$r[id]?>">
        </div></td>
      <td height="25"> <div align="center"> 
          <?=$r[id]?>
        </div></td>
      <td><div align="center"><a title="<?="����ʱ�䣺".date('Y-m-d H:i:s',$r[addtime])."\r\n����ʱ�䣺".date('Y-m-d',$r[endtime])?>"><?=$r[prename]?></a></div></td>
      <td height="25"> <div align="center">  
          <?=$r[precode]?>
          </div></td>
      <td height="25"> <div align="center"> 
          <?=$premoney?>
        </div></td>
      <td><div align="center"><?=$r['reuse']==1?'���ظ�':'һ��'?></div></td>
      <td height="25"> <div align="center">[<a href="AddPrecode.php?enews=EditPrecode&id=<?=$r[id]?>&time=<?=$time?><?=$ecms_hashur['ehref']?>">�޸�</a>]&nbsp;[<a href="ListPrecode.php?enews=DelPrecode&id=<?=$r[id]?>&time=<?=$time?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <div align="center"> 
          <input type=checkbox name=chkall value=on onclick="CheckAll(this.form)">
        </div></td>
      <td height="25" colspan="6">&nbsp; 
        <?=$returnpage?>
        &nbsp;&nbsp; <input type="submit" name="Submit2" value="ɾ��ѡ��"> </td>
    </tr>
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>